<?php

namespace Database\Seeders;

use App\Models\Background;
use Illuminate\Database\Seeder;

class BackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $backgrounds = [
            ['name' => 'Red Velvet'],
            ['name' => 'Classic Grey'],
            ['name' => 'Sky Blue'],
            ['name' => 'Garden Vibes'],
            ['name' => 'Industrial'],
        ];

        foreach ($backgrounds as $bg) {
            Background::create($bg);
        }
    }
}
