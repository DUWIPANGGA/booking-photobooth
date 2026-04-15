<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            // Group 1: Basic & Homey
            [
                'name' => 'Couple Vibes',
                'price' => 30000,
                'duration' => 10,
                'max_person' => '1-2 Orang',
                'features' => ['1-2 Orang', '10 Menit Sesi Foto', 'All softfile via G-drive', 'Cetak 1 lembar 4R', 'Concept Basic & Homey'],
                'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=400',
            ],
            [
                'name' => 'Bestie Vibes',
                'price' => 50000,
                'duration' => 10,
                'max_person' => '2-4 Orang',
                'features' => ['1-2 Orang', '10 Menit Sesi Foto', 'All softfile via G-drive', 'Cetak 2 lembar 4R', 'Concept Basic & Homey'],
                'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=400',
            ],
            [
                'name' => 'Gang Vibes',
                'price' => 85000,
                'duration' => 10,
                'max_person' => '4+ Orang',
                'features' => ['1-2 Orang', '10 Menit Sesi Foto', 'All softfile via G-drive', 'Cetak 4 lembar 4R', 'Concept Basic & Homey'],
                'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=400',
            ],
            // Group 2: Teater & 3D
            [
                'name' => 'Teater Vibes',
                'price' => 35000,
                'duration' => 7,
                'max_person' => '1-2 Orang',
                'features' => ['1-2 Orang', '7 Menit Sesi Foto', 'All softfile via G-drive', 'Cetak strip 2 lembar'],
                'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=400',
            ],
            [
                'name' => '3D Spotlight',
                'price' => 35000,
                'duration' => 7,
                'max_person' => '1-2 Orang',
                'features' => ['1-2 Orang', '7 Menit Sesi Foto', 'All softfile via G-drive', 'Cetak strip 2 lembar'],
                'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=400',
            ],
            // Group 3: Blue & Elevator
            [
                'name' => 'Blue Vibes',
                'price' => 35000,
                'duration' => 7,
                'max_person' => '1-2 Orang',
                'features' => ['1-2 Orang', '7 Menit Sesi Foto', 'All softfile via G-drive', 'Cetak strip 2 lembar'],
                'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=400',
            ],
            [
                'name' => 'Elevator Vibes',
                'price' => 35000,
                'duration' => 7,
                'max_person' => '1-2 Orang',
                'features' => ['1-2 Orang', '7 Menit Sesi Foto', 'All softfile via G-drive', 'Cetak strip 2 lembar'],
                'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=400',
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(['name' => $pkg['name']], $pkg);
        }
    }
}
