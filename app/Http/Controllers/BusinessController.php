<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use ZipArchive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


use App\Models\User;
use App\Models\Code;
use App\Models\Company;
use App\Models\Discount;

class BusinessController extends Controller
{
    /**
     * Mostra il form per caricare punti.
     */
    public function assign()
    {
        $users = User::all();
        $codes = Code::with('user')->get(); // 👈 questa è la chiave!
        $companies = Company::all();
        return view('business.assign', compact('users', 'codes', 'companies'));
    }



    /**
     * Mostra il form per emettere uno sconto.
     */
    public function discount()
    {
        $users = User::all();
        $codes = Code::with('user')->get(); // 👈 questa è la chiave!
        $companies = Company::all();
        return view('business.discount', compact('users', 'codes', 'companies'));
    }

    /**
     * Mostra il form per verificare una tessera.
     */
    public function verify()
    {
        $codes = Code::with('user')->get();
        $users = User::all();
        return view('business.verify', compact('codes', 'users'));
    }



    public function burn()
    {
        $codes = \App\Models\Code::all(); // oppure: use App\Models\Code;
        return view('business.burn', compact('codes'));
    }



    public function storeAssign(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'points' => 'required|integer|min:1',
        ]);

        $userId = $validated['user_id'];
        $pointsToAdd = (int) $validated['points'];

        // Prova ad assegnare i punti a un utente reale
        $user = User::find($userId);

        if ($user) {
            $user->points = (int) $user->points + $pointsToAdd;
            $user->save();

            return redirect()->route('business.dashboard')
                ->with('success', "✅ Aggiunti $pointsToAdd punti a {$user->name} {$user->surname}");
        }

        // Se non è un utente, prova come codice (tessera al portatore)
        $code = Code::find($userId);
        if ($code) {
            $code->points = (int) $code->points + $pointsToAdd;
            $code->save();

            return redirect()->route('business.dashboard')
                ->with('success', "✅ Aggiunti $pointsToAdd punti alla Tessera {$code->code}");
        }

        return redirect()->route('business.dashboard')
            ->with('error', '❌ Utente o codice non valido.');
    }

    public function storeDiscount(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'points' => 'required|integer|min:1',
        ]);

        $userId = $request->input('user_id');
        $points = (int) $request->input('points');

        $company = Company::find(auth()->user()->company);
        if (! $company || $company->points < $points) {
            return redirect()->route('dashboard')->with('error', 'Punti insufficienti per l’operazione.');
        }

        // 🔹 1. Tenta con un utente
        $user = User::find($userId);
        if ($user) {
            if ((int) $user->points < $points) {
                return redirect()->route('dashboard')->with('error', 'L’utente non ha abbastanza punti.');
            }

            $user->points -= $points;
            $user->save();

            $company->points -= $points;
            $company->save();

            Discount::create([
                'company' => $company->id,
                'user' => $user->id,
                'points' => $points,
            ]);

            return redirect()->route('business.dashboard')->with('success', "Sconto applicato a {$user->name} {$user->surname}.");
        }

        // 🔹 2. Tenta come tessera
        $code = Code::find($userId);
        if (! $code) {
            return redirect()->route('dashboard')->with('error', 'Codice non valido.');
        }

        if ($code->status !== 'active') {
            return redirect()->route('business.dashboard')->with('error', '❌ Questa tessera è disattivata.');
        }

        $currentPoints = (int) $code->points; // forzo null → 0
        if ($currentPoints <= 0) {
            return redirect()->route('dashboard')->with('error', '❌ La tessera non ha punti da sottrarre.');
        }

        if ($currentPoints < $points) {
            return redirect()->route('dashboard')->with('error', '❌ La tessera non ha abbastanza punti.');
        }

        $code->points -= $points;
        $code->save();

        $company->points -= $points;
        $company->save();

        Discount::create([
            'company' => $company->id,
            'user' => $code->user ?? null,
            'points' => $points,
        ]);

        return redirect()->route('business.dashboard')->with('success', "Sconto applicato alla Tessera {$code->code}.");
    }




    public function storeBurn(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string'
        ]);

        $code = Code::where('code', $validated['code'])->first();

        if (! $code) {
            return redirect()->route('business.burn')->with('error', '❌ Tessera non trovata.');
        }

        if ($code->user) {
            return redirect()->route('business.burn')->with('error', '❌ Tessera associata a un utente, non può essere riscattata.');
        }

        $pointsToRecover = (int) ($code->points ?? 0);

        $company = Company::find(auth()->user()->company);

        if ($company && $pointsToRecover > 0) {
            $company->points += $pointsToRecover;
            $company->save();
        }

        $code->points = 0;
        $code->user = auth()->id(); // 👈 assegna l'utente loggato
        $code->save();

        return redirect()->route('business.dashboard')
            ->with('success', "✅ Tessera {$code->code} riscattata con successo. {$pointsToRecover} punti trasferiti alla tua azienda.");
    }


    public function analytics()
    {
        $companyId = auth()->user()->company;

        $discounts = Discount::where('company', $companyId)
            ->orderBy('created_at')
            ->get(['created_at as date', 'points']);

        return view('business.analytics', compact('discounts'));
    }

    public function assignUser()
    {
        $companyId = auth()->user()->company;
    
        // Se l'utente non ha una company, restituisce solo il form senza tabella
        $users = User::whereNull('company')->get();
        $assignedUsers = $companyId
        ? User::where('company', $companyId)
            ->where('id', '!=', auth()->id()) // 👈 escludi l'utente loggato
            ->get()
        : collect();

    
        return view('business.assign-user', compact('users', 'assignedUsers'));
    }
    

    public function storeAssignUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);
        $companyId = auth()->user()->company;

        if (!$companyId) {
            return redirect()->back()->with('error', '⚠️ Nessuna company associata all’utente loggato.');
        }

        $user->company = $companyId;
        $user->role = 'business';
        $user->save();

        return redirect()->route('business.dashboard')->with('success', "✅ Utente {$user->name} {$user->surname} assegnato correttamente alla gestione del business.");
    }

    public function removeAssignedUser($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->company !== auth()->user()->company) {
            return redirect()->back()->with('error', '❌ Questo utente non appartiene alla tua azienda.');
        }

        $user->company = null;
        $user->save();

        return redirect()->back()->with('success', '✅ Utente rimosso con successo dalla tua azienda.');
    }

    public function myCodes()
    {
        $companyId = auth()->user()->company;
    
        if (! $companyId) {
            return redirect()->route('business.dashboard')->with('error', 'Nessuna azienda associata al tuo account.');
        }
    
        $codes = \App\Models\Code::where('company', $companyId)->get();
    
        return view('business.mycodes', compact('codes'));
    }
    

    public function removeCode($id)
    {
        $user = auth()->user();
    
        $code = \App\Models\Code::where('id', $id)
            ->where('company', $user->company)
            ->whereNull('user')
            ->first();
    
        if (! $code) {
            return redirect()->route('business.mycodes')->with('error', '❌ Tessera non trovata, non tua o già assegnata.');
        }
    
        $code->delete();
    
        return redirect()->route('business.mycodes')->with('success', '✅ Tessera rimossa con successo.');
    }
    

    public function generateCode()
    {
        $user = auth()->user();
        $companyId = $user->company;
    
        if (! $companyId) {
            return redirect()->back()->with('error', 'Nessuna azienda associata all’account.');
        }
    
        $serie = $companyId . 'BUS';
        $quantita = 1;
        $points = 0;
        $status = 'active';
    
        // Trova ultimo progressivo per la serie
        $last = Code::where('code', 'like', "$serie-%")
                    ->orderByDesc('id')
                    ->first();
    
        $startFrom = 1;
        if ($last) {
            $lastCode = explode('-', $last->code);
            $startFrom = isset($lastCode[1]) ? ((int)$lastCode[1]) + 1 : 1;
        }
    
        $progressive = str_pad($startFrom, 6, '0', STR_PAD_LEFT);
        $codeValue = "$serie-$progressive";
    
        $qrPath = "qrcodes/$codeValue.png";
        \QrCode::format('png')
            ->size(400)
            ->errorCorrection('H')
            ->margin(2)
            ->generate($codeValue, storage_path("app/public/{$qrPath}"));
    
        $code = Code::create([
            'code' => $codeValue,
            'qr' => "storage/$qrPath",
            'points' => $points,
            'company' => $companyId,
            'status' => $status,
            'user' => null,
        ]);
    
        return redirect()->route('business.mycodes')->with('success', "✅ Tessera $codeValue generata con successo.");
    }

    public function myCodesUser()
    {
        $codes = \App\Models\Code::where('user', auth()->id())
            ->where('status', 'active')
            ->get();

        return view('business.mycodes-user', compact('codes'));
    }

    public function removeUserCode($id)
    {
        $code = \App\Models\Code::where('id', $id)
            ->where('user', auth()->id())
            ->where('status', 'active')
            ->first();

        if (! $code) {
            return redirect()->route('business.mycodes-user')->with('error', '❌ Tessera non trovata o non tua.');
        }

        $code->status = 'inactive';
        $code->save();

        return redirect()->route('business.mycodes-user')->with('success', '✅ Tessera disattivata con successo.');
    }

    public function codeAssociation()
    {
        $codes = \App\Models\Code::where('status', 'active')
            ->whereNull('user')
            ->get();

        $userCodes = \App\Models\Code::where('user', auth()->id())
            ->where('status', 'active')
            ->get();

        return view('business.associate-code', compact('codes', 'userCodes'));
    }


    public function storeCodeAssociation(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string'
        ]);

        $code = \App\Models\Code::where('code', $validated['code'])
            ->where('status', 'active')
            ->whereNull('user')
            ->first();

        if (! $code) {
            return redirect()->route('business.code-association')->with('error', '❌ Tessera non trovata o già associata.');
        }

        $code->user = auth()->id();
        $code->save();

        return redirect()->route('business.mycodes-user')->with('success', "✅ Tessera {$code->code} associata con successo.");
    }

    public function editCompany()
    {
        $user = auth()->user();
        $company = \App\Models\Company::findOrFail($user->company);
        $categories = \App\Models\Category::all();

        // Attuale (sbagliato se la view è company-edit.blade.php)
        return view('business.company-edit', compact('company', 'categories'));

    }


    public function updateCompany(Request $request)
    {
        $user = auth()->user();
        $company = \App\Models\Company::findOrFail($user->company);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'coordinates' => 'nullable|string',
            'website' => 'nullable|string',
            'category' => 'nullable|integer|exists:categories,id',
            'piva' => 'nullable|string',
            'cf' => 'nullable|string',
            'pec' => 'nullable|string',
            'codice_univoco' => 'nullable|string',
            'existing_pictures' => 'array',
            'existing_pictures.*' => 'string',
            'pictures.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // immagini esistenti
        $pictures = $request->input('existing_pictures', []);

        // nuove immagini
        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $pic) {
                if ($pic->isValid()) {
                    $path = $pic->store('companies', 'public');
                    $pictures[] = 'storage/' . $path;
                }
            }
        }

        $company->update([
            ...$validated,
            'pictures' => json_encode($pictures),
        ]);

        return redirect()->route('business.company.edit')->with('success', '✅ Dati azienda aggiornati.');
    }









    




}