<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdatePasswordController extends Controller
{
    public function __invoke(UpdatePasswordRequest $request, User $user): RedirectResponse
    {
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The provided password does not match your current password.'
            ], 'password');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('password-status', 'Your password was successfully changed!');
    }
}
