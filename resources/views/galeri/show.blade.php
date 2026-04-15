@extends('layouts.guest')

@section('title', 'Gallery - ' . ucwords(str_replace('-', ' ', $theme)))

@push('styles')
<style>
    .theme-detail-section {
        padding: 60px 24px;
        background-color: var(--bg-light);
        text-align: center;
        min-height: calc(100vh - 130px);
    }

    .btn-close-gallery {
        position: fixed;
        top: 30px;
        right: 40px;
        font-size: 1.8rem;
        color: var(--text-dark);
        text-decoration: none;
        z-index: 1001;
        transition: var(--transition);
        background: rgba(255,255,255,0.8);
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    .btn-close-gallery:hover {
        transform: rotate(90deg);
        color: var(--primary);
    }

    .theme-header-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.4rem;
        color: var(--primary-dark);
        font-weight: 700;
        font-style: italic;
        margin-bottom: 40px;
    }

    .photo-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .photo-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        aspect-ratio: 1;
        border: 1px solid var(--border-color);
        transition: var(--transition);
        cursor: pointer;
    }

    .photo-item:hover {
        transform: scale(1.03);
        box-shadow: var(--shadow-md);
    }

    .photo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .photo-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .btn-close-gallery { top: 20px; right: 20px; width: 36px; height: 36px; font-size: 1.4rem; }
        .theme-header-title { font-size: 1.8rem; }
    }
</style>
@endpush

@section('content')
<section class="theme-detail-section">
    <a href="{{ route('galeri') }}" class="btn-close-gallery" title="Close">
        <i class="fas fa-times"></i>
    </a>

    <h1 class="theme-header-title">{{ ucwords(str_replace('-', ' ', $theme)) }}</h1>

    <div class="photo-grid">
        @php
            // Use a specific dummy image based on the theme or a default one
            $dummyImages = [
                'teater-vibes'   => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=600',
                '3d-spotlight'   => 'https://images.unsplash.com/photo-1520390138845-fd2d229dd553?q=80&w=600',
                'blue-vibes'     => 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=600',
                'basic'          => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=600',
                'homey'          => 'https://images.unsplash.com/photo-1513519245088-0e12902e35ca?q=80&w=600',
                'elevator-vibes' => 'https://plus.unsplash.com/premium_photo-1661601669467-36e395781a7d?q=80&w=600',
            ];
            $currentImg = $dummyImages[$theme] ?? 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=600';
        @endphp

        {{-- Show 6 dummy photos as in image 3 --}}
        @for($i = 0; $i < 6; $i++)
            <div class="photo-item">
                <img src="{{ $currentImg }}" alt="Gallery Image" class="photo-img">
            </div>
        @endfor
    </div>
</section>
@endsection
