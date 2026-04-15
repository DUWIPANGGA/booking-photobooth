@extends('layouts.guest')

@section('title', 'Gallery - ' . $category->name)

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

    /* Lightbox */
    .lightbox-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.9);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .lightbox-overlay.active {
        display: flex;
    }
    .lightbox-overlay img {
        max-width: 90vw;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 0 40px rgba(0,0,0,0.5);
    }
    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 2rem;
        cursor: pointer;
        line-height: 1;
        opacity: 0.8;
        transition: opacity 0.2s;
    }
    .lightbox-close:hover { opacity: 1; }

    .empty-gallery {
        grid-column: 1/-1;
        text-align: center;
        padding: 60px 20px;
        color: var(--text-muted);
    }
    .empty-gallery i {
        font-size: 3rem;
        margin-bottom: 16px;
        opacity: 0.4;
        display: block;
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

    <h1 class="theme-header-title">{{ $category->name }}</h1>

    <div class="photo-grid">
        @forelse($category->photos as $photo)
            <div class="photo-item" onclick="openLightbox('{{ asset('storage/' . $photo->image) }}')">
                <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $category->name }}" class="photo-img" loading="lazy">
            </div>
        @empty
            <div class="empty-gallery">
                <i class="fas fa-images"></i>
                <p style="font-size: 1.1rem;">Belum ada foto di galeri ini.</p>
                <a href="{{ route('galeri') }}" style="color: var(--primary); font-weight:600; margin-top:8px; display:inline-block;">
                    ← Kembali ke Galeri
                </a>
            </div>
        @endforelse
    </div>
</section>

{{-- Lightbox --}}
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox(event)">
    <span class="lightbox-close" onclick="document.getElementById('lightbox').classList.remove('active')">&times;</span>
    <img id="lightbox-img" src="" alt="Foto Galeri">
</div>
@endsection

@push('scripts')
<script>
    function openLightbox(src) {
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox').classList.add('active');
    }
    function closeLightbox(e) {
        if (e.target === document.getElementById('lightbox')) {
            document.getElementById('lightbox').classList.remove('active');
        }
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') document.getElementById('lightbox').classList.remove('active');
    });
</script>
@endpush
