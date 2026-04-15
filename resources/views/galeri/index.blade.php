@extends('layouts.guest')

@section('title', 'Galeri Portfolio')

@push('styles')
<style>
    .galeri-section {
        padding: 60px 24px;
        background-color: var(--bg-light);
        text-align: center;
    }

    .btn-kembali {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        color: var(--primary);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 30px;
        float: left;
        transition: var(--transition);
    }
    .btn-kembali:hover {
        background: var(--primary);
        color: white;
    }

    .galeri-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        color: var(--primary-dark);
        margin: 40px 0 10px;
        clear: both;
    }

    .galeri-divider {
        width: 80px;
        height: 2px;
        background: var(--primary-soft);
        margin: 0 auto 50px;
    }

    .galeri-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .theme-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        border: 1px solid var(--border-color);
        text-decoration: none;
        display: block;
    }

    .theme-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-md);
    }

    .theme-img-wrapper {
        position: relative;
        aspect-ratio: 4/5;
        overflow: hidden;
    }

    .theme-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .theme-card:hover .theme-img {
        transform: scale(1.1);
    }

    .theme-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 20px;
        opacity: 0.8;
    }

    .view-gallery-btn {
        color: white;
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .theme-name {
        padding: 20px;
        background: white;
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.1rem;
        font-style: italic;
    }

    @media (max-width: 992px) {
        .galeri-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
        .galeri-grid { grid-template-columns: 1fr; }
        .galeri-title { font-size: 1.8rem; }
    }
</style>
@endpush

@section('content')
<section class="galeri-section">
    <div class="container" style="max-width: 1100px; margin: 0 auto; overflow: hidden;">
        <a href="{{ route('home') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <h1 class="galeri-title">Momen Dalam Setiap Vibes</h1>
        <div class="galeri-divider"></div>

        <div class="galeri-grid">
            @php
                $themes = [
                    ['name' => 'Teater Vibes', 'slug' => 'teater-vibes', 'img' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=600'],
                    ['name' => '3D Spotlight', 'slug' => '3d-spotlight', 'img' => 'https://images.unsplash.com/photo-1520390138845-fd2d229dd553?q=80&w=600'],
                    ['name' => 'Blue Vibes', 'slug' => 'blue-vibes', 'img' => 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=600'],
                    ['name' => 'Basic', 'slug' => 'basic', 'img' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=600'],
                    ['name' => 'Homey', 'slug' => 'homey', 'img' => 'https://images.unsplash.com/photo-1513519245088-0e12902e35ca?q=80&w=600'],
                    ['name' => 'Elevator Vibes', 'slug' => 'elevator-vibes', 'img' => 'https://images.unsplash.com/photo-1541339907198-e08759df9a73?q=80&w=600'],
                ];
            @endphp

            @foreach($themes as $theme)
                <a href="{{ route('galeri.show', $theme['slug']) }}" class="theme-card">
                    <div class="theme-img-wrapper">
                        <img src="{{ $theme['img'] }}" alt="{{ $theme['name'] }}" class="theme-img">
                        <div class="theme-overlay">
                            <span class="view-gallery-btn">View Gallery <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                    <div class="theme-name">{{ $theme['name'] }}</div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
