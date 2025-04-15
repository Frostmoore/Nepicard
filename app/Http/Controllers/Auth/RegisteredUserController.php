<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Mail\BusinessApprovalRequest;
use App\Models\User;
use App\Models\Company;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => ['nullable', 'string', 'max:255'],
        ]);

        $isBusiness = $request->has('is_business');
        $companyId = null;
        $role = 'user';
        $status = 1;

        if ($isBusiness && $request->filled('company_name')) {
            $company = Company::create([
                'name' => $request->company_name,
            ]);
            $companyId = $company->id;
            $role = 'business';
            $status = 0; // in attesa approvazione
        }

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'company' => $companyId,
            'status' => $status,
        ]);

        event(new Registered($user));

        if ($status === 0) {
            // Trova primo admin o superadmin
            $admin = User::whereIn('role', ['admin', 'superadmin'])->first();
            if ($admin) {
                Mail::to($admin->email)->send(new BusinessApprovalRequest($user));
            }
    
            return redirect()->route('business.pending');
        }
    
        Auth::login($user);
        return redirect('dashboard');
    }

    public function approve($id)
    {
        $user = User::find($id);

        if (! $user || $user->status == 1) {
            return redirect()->route('dashboard')->with('error', 'Utente non valido o già approvato.');
        }

        $user->status = 1;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Utente approvato con successo.');
    }

}
