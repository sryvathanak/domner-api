<?php

namespace Database\Seeders;

use App\Models\Client\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'vathanak',
            'email' => 'vathanak@gmail.com',
            'password' => Hash::make('vathanak@2002'),
        ]);
    }
}
