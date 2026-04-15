@extends('layouts.guest')

@section('title', 'Paket Vibes Studio')

@push('styles')
<style>
    .paket-container { max-width: 1200px; margin: 0 auto; padding: 40px 24px; background: #FDF5F2; min-height: 100vh; }
    
    .btn-kembali-wrapper { margin-bottom: 20px; }
    .btn-kembali-circle { 
        display: inline-flex; align-items: center; justify-content: center; 
        width: 32px; height: 32px; border-radius: 50%; border: 1.5px solid #80404D;
        color: #80404D; text-decoration: none; font-size: 0.8rem; margin-right: 10px;
    }
    .text-kembali { color: #80404D; font-size: 0.9rem; font-weight: 600; text-decoration: none; }

    .main-title { 
        text-align: center; font-family: 'Playfair Display', serif; font-size: 2.8rem; 
        color: #80404D; margin-bottom: 60px; position: relative;
    }
    .main-title::after {
        content: ''; position: absolute; bottom: -15px; left: 50%; transform: translateX(-50%);
        width: 150px; height: 1px; background: #D2B48C;
    }

    .konsep-section { margin-bottom: 80px; }
    .konsep-title { 
        font-family: 'Poppins', sans-serif; font-style: italic; font-weight: 800; 
        font-size: 1.6rem; color: #80404D; margin-bottom: 40px; 
    }

    .package-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; }
    .package-grid.two-cols { grid-template-columns: repeat(2, 1fr); max-width: 800px; margin: 0 auto; }

    .pkg-card {
        background: white; border-radius: 20px; padding: 25px; 
        box-shadow: 0 15px 40px rgba(0,0,0,0.05); text-align: center;
        transition: 0.3s; border: 1px solid #f0f0f0;
    }
    .pkg-card:hover { transform: translateY(-8px); box-shadow: 0 20px 50px rgba(123,45,62,0.1); }

    .pkg-name-wrapper { position: relative; margin-bottom: 25px; padding: 0 20px; }
    .pkg-name-wrapper::before, .pkg-name-wrapper::after {
        content: ''; position: absolute; top: 50%; width: 50px; height: 1px; background: #D2B48C;
    }
    .pkg-name-wrapper::before { left: 0; }
    .pkg-name-wrapper::after { right: 0; }
    .pkg-name { font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.5rem; color: #80404D; font-weight: 700; }

    .pkg-img { width: 100%; aspect-ratio: 1.4; object-fit: cover; border-radius: 12px; margin-bottom: 20px; }
    
    .pkg-price { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 1.3rem; color: #80404D; margin-bottom: 15px; }
    
    .pkg-features { 
        list-style: none; text-align: left; margin: 0 auto 30px; 
        display: inline-block; font-size: 0.85rem; color: #5C1F2D; 
        line-height: 1.6; font-weight: 500;
    }
    .pkg-features li { display: flex; align-items: flex-start; gap: 8px; margin-bottom: 4px; }
    .pkg-features li::before { content: '•'; color: #80404D; font-weight: 900; }

    .btn-pilih { 
        background: #80404D; color: white; border: none; padding: 10px 40px; 
        border-radius: 30px; font-weight: 700; cursor: pointer; transition: 0.3s;
        text-decoration: none; display: inline-block;
    }
    .btn-pilih:hover { background: #5C1F2D; transform: scale(1.05); }

    @media (max-width: 992px) {
        .package-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .package-grid { grid-template-columns: 1fr; }
        .package-grid.two-cols { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="paket-container">
    <div class="btn-kembali-wrapper">
        <a href="{{ route('home') }}" class="btn-kembali-circle"><i class="fas fa-arrow-left"></i></a>
        <a href="{{ route('home') }}" class="text-kembali">Kembali</a>
    </div>

    <h1 class="main-title">Paket Vibes Studio</h1>

    <div class="konsep-section">
        <div class="package-grid">
            @forelse($packages as $p)
                <div class="pkg-card">
                    <div class="pkg-name-wrapper"><span class="pkg-name">{{ $p->name }}</span></div>
                    <img src="{{ $p->image ? asset('storage/' . $p->image) : 'https://images.unsplash.com/photo-1557683316-973673baf926?q=80&w=400' }}" class="pkg-img">
                    <div class="pkg-price">Mulai RP. {{ number_format($p->price, 0, ',', '.') }}</div>
                    <ul class="pkg-features">
                        @if($p->max_person) <li>{{ $p->max_person }}</li> @endif
                        @if($p->duration) <li>{{ $p->duration }} Menit Sesi Foto</li> @endif
                        @if($p->features && is_array($p->features))
                            @foreach($p->features as $f)
                                <li>{{ $f }}</li>
                            @endforeach
                        @endif
                    </ul>
                    <br>
                    <a href="{{ route('booking.create', ['package' => $p->name]) }}" class="btn-pilih">Pilih Paket</a>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 100px; color: #8C6474;">
                    <i class="fas fa-box-open" style="font-size: 4rem; opacity: 0.2; margin-bottom: 20px; display: block;"></i>
                    <p style="font-weight: 600;">Belum ada paket yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
