<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $users = User::query()
            ->with('role')
            ->where('id', '<>', auth()->id())
            ->whereRelation('role', 'name', '<>', 'super-admin')
            ->when(auth()->user()->hasRole('admin'), function (Builder $query) {
                $query->whereRelation('role', 'name', '<>', 'admin');
            })
            ->paginate(5);

        return view('dashboard', [
            'users' => $users
        ]);
    }
}
