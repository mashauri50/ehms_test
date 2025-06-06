<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        'name' => 'Ehms Tester',
        'email' => 'tester@example.com',
        'password' => Hash::make('password'),
    ]);

    User::create([
        'name' => 'Ehms Tester2',
        'email' => 'tester2@example.com',
        'password' => Hash::make('password'),
    ]);
    }
}
