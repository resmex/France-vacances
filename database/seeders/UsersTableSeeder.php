<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
public function run()
{
    // Admin
    if (!User::where('email', 'admin@francevacances.co.uk')->exists()) {
        User::create([
            'name'     => 'Adelvina Mrema',
            'email'    => 'admin@francevacances.co.uk',
            'role'     => 'admin',
            'password' => Hash::make('password'),
        ]);
    }

    // Customer 1
    if (!User::where('email', 'happiness.pius@francevacances.co.uk')->exists()) {
        User::create([
            'name'     => 'Happiness Pius',
            'email'    => 'happiness.pius@francevacances.co.uk',
            'role'     => 'customer',
            'password' => Hash::make('password'),
        ]);
    }

    // Customer 2
    if (!User::where('email', 'remmy.stephen@francevacances.co.uk')->exists()) {
        User::create([
            'name'     => 'Remmy Stephen',
            'email'    => 'remmy.stephen@francevacances.co.uk',
            'role'     => 'customer',
            'password' => Hash::make('password'),
        ]);
    }

    // Customer 3
    if (!User::where('email', 'gospel.ayo@francevacances.co.uk')->exists()) {
        User::create([
            'name'     => 'Gospel Ayo',
            'email'    => 'gospel.ayo@francevacances.co.uk',
            'role'     => 'customer',
            'password' => Hash::make('password'),
        ]);
    }

    // Customer 4
    if (!User::where('email', 'florine.koddy@francevacances.co.uk')->exists()) {
        User::create([
            'name'     => 'Florine Koddy',
            'email'    => 'florine.koddy@francevacances.co.uk',
            'role'     => 'customer',
            'password' => Hash::make('password'),
        ]);
    }
}
}
