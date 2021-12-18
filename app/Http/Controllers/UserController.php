<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Events\UserEmailChanged;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
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

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->fill($request->safe()->except(['role']));

        if (!auth()->user()->is($user)) {
            $user->fill([
                'role_id' => $request->role
            ]);
        }

        $user->save();

        if ($user->wasChanged('email')) {
            $user->markEmailAsNotVerified();
            event(new Registered($user)); // Use built-in registered event to send an email verification notification
        }

        return back()->with('status', 'Account informations have been successfully updated!');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return back()->with('status', "User's account was successfully deleted!");
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
