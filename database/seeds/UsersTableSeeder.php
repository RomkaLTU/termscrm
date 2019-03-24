<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'manage_users']);
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo( Permission::all() );
        Role::create(['name' => 'User']);

        $user = \App\User::create([
            'name' => 'Jack Doe',
            'duties' => 'Direktorius',
            'email' => 'admin@example.com',
            'password' => 'admin',
        ]);
        $user->assignRole('Admin');

        $user = \App\User::create([
            'name' => 'Mary Jane',
            'duties' => 'Administratorė',
            'email' => 'maryj@example.com',
            'password' => 'admin',
        ]);
        $user->assignRole('User');

        $user = \App\User::create([
            'name' => 'Oliver Smith',
            'duties' => 'Vadybininkas',
            'email' => 'oliver@example.com',
            'password' => 'admin',
        ]);
        $user->assignRole('User');
    }
}
