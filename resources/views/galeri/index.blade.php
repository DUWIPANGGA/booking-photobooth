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
            @forelse($categories as $category)
                <a href="{{ route('galeri.show', $category->id) }}" class="theme-card">
                    <div class="theme-img-wrapper">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="theme-img">
                        @elseif($category->photos->first())
                            <img src="{{ asset('storage/' . $category->photos->first()->image) }}" alt="{{ $category->name }}" class="theme-img">
                        @else
                            <div class="theme-img" style="background: linear-gradient(135deg, #d4a0b0 0%, #8b5e6a 100%); display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-images" style="font-size:3rem; color:rgba(255,255,255,0.5);"></i>
                            </div>
                        @endif
                        <div class="theme-overlay">
                            <span class="view-gallery-btn">
                                View Gallery <i class="fas fa-arrow-right"></i>
                                @if($category->photos_count > 0)
                                    <small style="opacity:0.8;">({{ $category->photos_count }} foto)</small>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="theme-name">{{ $category->name }}</div>
                </a>
            @empty
                <div style="grid-column: 1/-1; text-align:center; padding: 60px 20px; color: var(--text-muted);">
                    <i class="fas fa-images" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.4; display:block;"></i>
                    <p style="font-size: 1.1rem;">Belum ada galeri tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
