<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPermissions = Permission::pluck('id')->all();
        $clientPermissions = Permission::where('name', 'like', 'client-%')->pluck('id')->all();

        $admin = Role::create(['name' => 'Admin', 'guard_name' => 'api']);
        $admin->syncPermissions($allPermissions);

        $user = Role::create(['name' => 'User', 'guard_name' => 'api']);
        $user->syncPermissions($clientPermissions);
    }
}
