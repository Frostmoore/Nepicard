<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ApprovalController extends Controller
{
    // In App\Http\Controllers\Admin\ApprovalController.php

    public function approve(User $user)
    {
        if ($user->status == 1) {
            return redirect()->route('dashboard')->with('error', 'Utente già approvato.');
        }

        $user->status = 1;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Utente approvato con successo.');
    }

}

