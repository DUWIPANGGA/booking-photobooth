<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@vibesstudio.com'],
            [
                'name'         => 'Admin Vibes Studio',
                'email'        => 'admin@vibesstudio.com',
                'phone_number' => '081234567890',
                'password'     => Hash::make('admin123'),
                'role'         => 'admin',
            ]
        );

        $this->command->info('✅ Admin seeder berhasil! Email: admin@vibesstudio.com | Password: admin123');
    }
}
