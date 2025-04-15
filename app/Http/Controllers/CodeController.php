<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Assicurati di avere questa dipendenza
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use ZipArchive;
use App\Mail\CodesZipMail;

class CodeController extends Controller
{

    public function index() {
        $codes = Code::latest()->get();
        $companies = Company::all();
        $users = User::all();
        return view('admin.codes.index', compact('codes', 'companies', 'users'));
    }

    public function create() {
        $users = \App\Models\User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->surname . ' ' . $user->name . ' (' . $user->username . ')',
            ];
        });
        $companies = Company::all();
        return view('admin.codes.create', compact('users', 'companies'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'serie' => 'required|string|max:20',
            'quantita' => 'required|integer|min:1|max:1000',
            'qr' => 'nullable|file|image|max:2048',
            'points' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);
    
        $generatedCodes = [];
        $serie = strtoupper($validated['serie']);
        $quantita = (int) $validated['quantita'];
        $points = $validated['points'] ?? null;
        $status = $validated['status'] ?? 'active';
        $company = $validated['company'] ?? null;
    
        // Trova ultimo progressivo per la serie
        $last = Code::where('code', 'like', "$serie-%")
                    ->orderByDesc('id')
                    ->first();
    
        $startFrom = 1;
        if ($last) {
            $lastCode = explode('-', $last->code);
            $startFrom = isset($lastCode[1]) ? ((int)$lastCode[1]) + 1 : 1;
        }
    
        $qrPaths = [];
        for ($i = 0; $i < $quantita; $i++) {
            $progressive = str_pad($startFrom + $i, 6, '0', STR_PAD_LEFT);
            $codeValue = "$serie-$progressive";
    
            $qrPath = "qrcodes/$codeValue.png";
            \QrCode::format('png')
                ->size(400)
                ->errorCorrection('H') // ✅ livello alto di correzione errore
                ->margin(2)           // ✅ margine maggiore
                ->generate($codeValue, storage_path("app/public/{$qrPath}"));
    
            $newCode = Code::create([
                'code' => $codeValue,
                'qr' => "storage/$qrPath",
                'points' => $points,
                'company' => $company,
                'status' => $status,
            ]);
    
            $qrPaths[] = storage_path("app/public/{$qrPath}");
            $generatedCodes[] = $newCode;
        }
    
        // Crea ZIP
        $zipName = 'codici_' . Str::slug($serie) . '_' . now()->timestamp . '.zip';
        $zipPath = storage_path("app/public/zips/{$zipName}");
    
        if (!Storage::exists('public/zips')) {
            Storage::makeDirectory('public/zips');
        }
    
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($qrPaths as $path) {
                $zip->addFile($path, basename($path));
            }
            $zip->close();
        }
    
        // Trova email destinatario
        $companyUser = User::where('company', $company)->first();
        $toEmail = $companyUser?->email ?? Company::find($company)?->email ?? auth()->user()->email;
        if (!$toEmail) {
            return back()->withErrors(['email' => 'Impossibile determinare un indirizzo email per l’invio.']);
        }
    
        // Invia email
        Mail::to($toEmail)->send(new CodesZipMail($zipPath, $serie));
    
        return redirect()->route('admin.codes.index')->with('success', 'Codici creati e inviati per email.');
    }
    
    
    public function show(Code $code) {
        return view('admin.codes.show', compact('code'));
    }

    public function edit(Code $code) {
        $users = \App\Models\User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->surname . ' ' . $user->name . ' (' . $user->username . ')',
            ];
        });
        $companies = Company::all();
        return view('admin.codes.edit', compact('code', 'users', 'companies'));
    }

    public function update(Request $request, Code $code) {
        $validated = $request->validate([
            'user' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'points' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
        ]);
    
        $newUserId = $validated['user'] ?? null;
        $oldUserId = $code->user;
    
        // Caso 1: se l'utente è cambiato o è stato rimosso
        if ($oldUserId && $newUserId !== $oldUserId) {
            // NON toccare i punti del vecchio utente
            // E azzera i punti del codice se disassociato
            if (!$newUserId) {
                $validated['points'] = null;
            }
        }
    
        // Caso 2: se il codice ha punti e viene assegnato per la prima volta a un utente
        if (!$oldUserId && $newUserId && !empty($validated['points']) && is_numeric($validated['points'])) {
            $user = \App\Models\User::find($newUserId);
            if ($user) {
                $user->points = ($user->points ?? 0) + $validated['points'];
                $user->save();
            }
        }
    
        $code->update($validated);
    
        return redirect()->route('admin.codes.index')->with('success', 'Codice aggiornato correttamente.');
    }
    
    

    public function destroy(Code $code) {
        $code->delete();
        return redirect()->route('admin.codes.index')->with('success', 'Codice eliminato.');
    }

}
