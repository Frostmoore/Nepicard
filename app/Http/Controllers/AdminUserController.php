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

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string'],
            'company' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update($validated);

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
