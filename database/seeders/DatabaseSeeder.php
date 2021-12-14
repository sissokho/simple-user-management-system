<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create Permissions
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'delete user']);

        // Create roles and assign permissions
        $superAdminRole = Role::create(['name' => 'super-admin']); // Has all permissions. see AuthServiceProvider

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('create user');
        $adminRole->givePermissionTo('edit user');
        $adminRole->givePermissionTo('view user');
        $adminRole->givePermissionTo('delete user');

        $userRole = Role::create(['name' => 'user']);

        // Create a superadmin
        $superAdmin = User::factory()->create([
            'name' => 'Mouhamadou Moustapha',
            'email' => 'siskomouhamed@gmail.com',
        ]);

        $superAdmin->assignRole($superAdminRole);
    }
}
