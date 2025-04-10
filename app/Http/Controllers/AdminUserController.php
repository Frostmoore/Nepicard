<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{

    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('surname', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('username', 'like', "%$search%");
            });
        }

        $users = $query->orderBy('id', 'desc')->get();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'role' => ['required', 'string'],
        ]);

        $user->fill($validated);

        if ($request->role === 'business') {
            $user->fill($request->only([
                'coordinates',
                'ditta',
                'sede',
                'piva',
                'cf',
                'pec',
                'codice_univoco',
            ]));
        } else {
            // Pulisci i campi aziendali se il ruolo non è business
            $user->fill([
                'coordinates' => null,
                'ditta' => null,
                'sede' => null,
                'piva' => null,
                'cf' => null,
                'pec' => null,
                'codice_univoco' => null,
            ]);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Utente aggiornato con successo.');
    }


    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('success', 'Utente eliminato.');
    }

    public function sendReset(User $user): RedirectResponse
    {
        Password::sendResetLink(['email' => $user->email]);

        return back()->with('success', "Email di reset inviata a {$user->email}");
    }
}
