<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Arditha',
            'username' => 'arditha15',
            'email' => 'ardbeater@gmail.com',
            'password' => Hash::make('2060:'),
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Moncek',
            'username' => 'moncek06',
            'email' => 'armoni@gmail.com',
            'password' => Hash::make('bbpes'),
            'role' => 'User',
        ]);
    }
}
