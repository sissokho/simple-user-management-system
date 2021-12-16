<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create(): View
    {
        $roles = Role::query()
            ->where('name', '<>', 'super-admin')
            ->get();

        return view('users.create', [
            'roles' => $roles
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role'],
            'password' => Str::random(60),
        ]);

        event(new UserCreated($user));

        return redirect()
            ->route('dashboard')
            ->with('status', 'The user was successfully created! An email has been sent to reset his/her password.');
    }

    public function edit(User $user): View
    {
        $roles = Role::query()
            ->where('name', '<>', 'super-admin')
            ->get();

        return view('users.edit', [
            'user' => $user->load('role'),
            'roles' => $roles
        ]);
    }

    public function resendPasswordResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
