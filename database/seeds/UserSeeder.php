<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Rafał Kucharski',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ])->assignRole([Role::where('name', 'Admin')->first()->id]);

        $users = factory(User::class, 9)->create();
        foreach ($users as $user) {
            $user->assignRole([Role::where('name', 'User')->first()->id]);
        }
    }
}
