<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->hasPermissionTo("view {$model->role->name}")) {
            return true;
        }

        return $user->is($model);
    }

    /**
     * Determine whether the user can create a model with the specified role.
     */
    public function create(User $user, string $role): bool
    {
        return $user->hasPermissionTo("create {$role}");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->hasPermissionTo("edit {$model->role->name}")) {
            return true;
        }

        return $user->is($model);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo("delete {$model->role->name}");
    }

    /**
     * Determine whether the user can update the model's password.
     */
    public function updatePassword(User $user, User $model): bool
    {
        return $user->is($model);
    }
}
