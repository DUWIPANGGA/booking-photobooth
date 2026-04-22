@extends('layouts.guest')

@section('title', 'Paket Vibes Studio')

@push('styles')
    <style>
        .paket-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
            min-height: 100vh;
        }

        .main-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            color: #80404D;
            margin-bottom: 60px;
            font-weight: 700;
        }

        .konsep-section {
            margin-bottom: 60px;
        }

        .konsep-title {
            font-family: 'Poppins', sans-serif;
            font-style: italic;
            font-weight: 800;
            font-size: 1.5rem;
            color: #80404D;
            margin-bottom: 30px;
            text-align: left;
        }

        .package-flex {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .package-item {
            flex: 0 1 calc(33.333% - 20px);
            min-width: 280px;
            max-width: 350px;
        }

        .pkg-name-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .pkg-name-wrapper::before,
        .pkg-name-wrapper::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #a68c92;
            margin: 0 15px;
        }

        .pkg-name {
            font-family: 'Poppins', sans-serif;
            font-style: italic;
            font-weight: 800;
            font-size: 1.2rem;
            color: #80404D;
        }

        .pkg-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: 0.3s;
        }

        .pkg-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(128, 64, 77, 0.15);
        }

        .pkg-img {
            width: 100%;
            aspect-ratio: 1.4;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .pkg-price {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-style: italic;
            font-size: 1.2rem;
            color: #80404D;
            margin-bottom: 15px;
        }

        .pkg-features {
            list-style: none;
            text-align: left;
            margin: 0 auto 25px;
            display: inline-block;
            font-size: 0.85rem;
            color: #5C1F2D;
            line-height: 1.5;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
        }

        .pkg-features li {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 4px;
        }

        .pkg-features li::before {
            content: '•';
            color: #80404D;
            font-weight: 900;
            font-size: 1.2rem;
            line-height: 1;
            margin-top: 1px;
        }

        .btn-pilih {
            background: #80404D;
            color: white;
            border: none;
            padding: 10px 35px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-pilih:hover {
            background: #5C1F2D;
            transform: scale(1.05);
            color: white;
        }

        @media (max-width: 992px) {
            .package-item {
                flex: 0 1 calc(50% - 15px);
            }
        }

        @media (max-width: 768px) {
            .package-item {
                flex: 0 1 100%;
                max-width: 400px;
            }
        }
    </style>
@endpush

@section('content')
    @php
        // Grouping packages based on the predefined concepts
        $basicPackages = $packages
            ->filter(function ($p) {
                return in_array($p->name, ['Couple Vibes', 'Bestie Vibes', 'Gang Vibes']);
            })
            ->sortBy(function ($p) {
                return array_search($p->name, ['Couple Vibes', 'Bestie Vibes', 'Gang Vibes']);
            });

        $teaterPackages = $packages
            ->filter(function ($p) {
                return in_array($p->name, ['Teater Vibes', '3D Spotlight']);
            })
            ->sortBy(function ($p) {
                return array_search($p->name, ['Teater Vibes', '3D Spotlight']);
            });

        $bluePackages = $packages
            ->filter(function ($p) {
                return in_array($p->name, ['Blue Vibes', 'Elevator Vibes']);
            })
            ->sortBy(function ($p) {
                return array_search($p->name, ['Blue Vibes', 'Elevator Vibes']);
            });

        // In case there are other packages not in these predefined lists
        $otherPackages = $packages->filter(function ($p) {
            return !in_array($p->name, [
                'Couple Vibes',
                'Bestie Vibes',
                'Gang Vibes',
                'Teater Vibes',
                '3D Spotlight',
                'Blue Vibes',
                'Elevator Vibes',
            ]);
        });

        $groups = [
            'Paket Konsep Basic & Homey' => $basicPackages,
            'Paket Konsep Teater Vibes & 3D Spotlight' => $teaterPackages,
            'Paket Konsep Blue Vibes & Elevator Vibes' => $bluePackages,
        ];
    @endphp

    <div class="paket-container">
        <a href="{{ route('home') }}" class="btn-kembali-wrapper">
            <span class="btn-kembali-circle"><i class="fas fa-arrow-left"></i></span>
            <span class="text-kembali">Kembali</span>
        </a>

        <h1 class="main-title">Paket Vibes Studio</h1>

        @foreach ($groups as $title => $groupPackages)
            @if ($groupPackages->count() > 0)
                <div class="konsep-section">
                    <h2 class="konsep-title">{{ $title }}</h2>
                    <div class="package-flex">
                        @foreach ($groupPackages as $p)
                            <div class="package-item">
                                <div class="pkg-name-wrapper"><span class="pkg-name">{{ $p->name }}</span></div>
                                <div class="pkg-card">
                                    <img src="{{ $p->image ? asset('storage/' . $p->image) : 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=400' }}"
                                        class="pkg-img">
                                    <div class="pkg-price">Mulai RP. {{ number_format($p->price, 0, ',', '.') }}</div>
                                    <ul class="pkg-features">
                                        @if ($p->features && is_array($p->features))
                                            @foreach ($p->features as $f)
                                                <li>{{ $f }}</li>
                                            @endforeach
                                        @else
                                            @if ($p->max_person)
                                                <li>{{ $p->max_person }}</li>
                                            @endif
                                            @if ($p->duration)
                                                <li>{{ $p->duration }} Menit Sesi Foto</li>
                                            @endif
                                        @endif
                                    </ul>
                                    <a href="{{ route('booking.create', ['package' => $p->name]) }}" class="btn-pilih">Pilih
                                        Paket</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        @if ($otherPackages->count() > 0)
            <div class="konsep-section">
                <h2 class="konsep-title">Paket Lainnya</h2>
                <div class="package-flex">
                    @foreach ($otherPackages as $p)
                        <div class="package-item">
                            <div class="pkg-name-wrapper"><span class="pkg-name">{{ $p->name }}</span></div>
                            <div class="pkg-card">
                                <img src="{{ $p->image ? asset('storage/' . $p->image) : 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=400' }}"
                                    class="pkg-img">
                                <div class="pkg-price">Mulai RP. {{ number_format($p->price, 0, ',', '.') }}</div>
                                <ul class="pkg-features">
                                    @if ($p->features && is_array($p->features))
                                        @foreach ($p->features as $f)
                                            <li>{{ $f }}</li>
                                        @endforeach
                                    @else
                                        @if ($p->max_person)
                                            <li>{{ $p->max_person }}</li>
                                        @endif
                                        @if ($p->duration)
                                            <li>{{ $p->duration }} Menit Sesi Foto</li>
                                        @endif
                                    @endif
                                </ul>
                                <a href="{{ route('booking.create', ['package' => $p->name]) }}" class="btn-pilih">Pilih
                                    Paket</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
