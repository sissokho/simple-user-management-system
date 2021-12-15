<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
}
