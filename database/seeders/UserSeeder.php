<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Mama',  'email' => 'mama@tantefanipay.com',  'password' => '1974'],
            ['name' => 'Bapa',  'email' => 'bapa@tantefanipay.com',  'password' => '1971'],
            ['name' => 'Eldan', 'email' => 'eldan@tantefanipay.com', 'password' => '2004'],
            ['name' => 'Tio',   'email' => 'tio@tantefanipay.com',   'password' => '1998'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                ]
            );
        }
    }
}
