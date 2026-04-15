<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'         => 'Hiraa',
            'email'        => 'user@gmail.com',
            'password'     => Hash::make('password'),
            'role'         => 'user',
            'phone_number' => '085314412737',
        ]);
        
        echo "✅ User seeder berhasil! Email: user@gmail.com | Password: password\n";
    }
}
