<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@myshop.com',
            'password' => bcrypt('password')
        ]);
        $admin->roles()->attach(1);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@myshop.com',
            'password' => bcrypt('password')
        ]);
        $user->roles()->attach(2);

        $salesRep = User::create([
            'name' => 'Sales Rep',
            'email' => 'sales@myshop.com',
            'password' => bcrypt('password')
        ]);
        $salesRep->roles()->attach(3);
    }
}
