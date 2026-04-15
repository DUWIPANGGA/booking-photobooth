@extends('layouts.guest')

@section('title', 'Booking Saya - Vibes Studio')

@push('styles')
<style>
    .index-container { max-width: 1000px; margin: 40px auto; padding: 0 24px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
    .page-title { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: var(--primary-dark); }
    
    .booking-card { 
        background: white; border-radius: 16px; margin-bottom: 20px; 
        border: 1px solid var(--border-color); box-shadow: var(--shadow-md);
        display: flex; overflow: hidden; transition: 0.3s;
    }
    .booking-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(123,45,62,0.15); }
    
    .pkg-icon-side { 
        width: 150px; background: rgba(123, 45, 62, 0.05); display: flex; 
        align-items: center; justify-content: center; font-size: 3rem; color: var(--primary);
    }
    
    .booking-details { flex: 1; padding: 25px; }
    .booking-id { font-size: 0.75rem; color: #8C6474; font-weight: 700; margin-bottom: 5px; display: block; }
    .booking-pkg-name { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--primary-dark); margin-bottom: 15px; }
    
    .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    .info-item { font-size: 0.85rem; color: #444; }
    .info-item span { display: block; color: #8C6474; font-size: 0.75rem; font-weight: 600; margin-bottom: 4px; }
    .info-item strong { color: var(--text-dark); font-weight: 700; }

    .status-side { 
        width: 180px; padding: 25px; display: flex; flex-direction: column; 
        align-items: center; justify-content: center; border-left: 1.5px dashed var(--bg-light);
    }
    .status-badge { 
        padding: 6px 20px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; 
        text-transform: uppercase; margin-bottom: 15px; width: 100%; text-align: center;
    }
    .status-pending { background: #FFF4E5; color: #856404; }
    .status-confirmed { background: #E1F9E1; color: #1E7E34; }
    .status-canceled { background: #FDE8E8; color: #C81E1E; }
    
    .btn-view-detail { 
        color: var(--primary); text-decoration: none; font-size: 0.85rem; 
        font-weight: 700; border-bottom: 1.5px solid var(--primary); 
    }
    
    .empty-action { 
        text-align: center; padding: 100px 0; background: white; 
        border-radius: 20px; border: 2px dashed var(--border-color); 
    }
</style>
@endpush

@section('content')
<div class="index-container">
    <div class="page-header">
        <h1 class="page-title">Riwayat Booking Saya</h1>
        <a href="{{ route('home') }}#paket" class="btn-wa" style="text-decoration: none; background: var(--primary); color: white; padding: 10px 25px; border-radius: 30px;">
            <i class="fas fa-plus"></i> Booking Baru
        </a>
    </div>

    @forelse($bookings as $booking)
    <div class="booking-card">
        <div class="pkg-icon-side">
            <i class="fas fa-camera-retro"></i>
        </div>
        <div class="booking-details">
            <span class="booking-id">#BK{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
            <h2 class="booking-pkg-name">Paket {{ $booking->package->name }}</h2>
            
            <div class="info-grid">
                <div class="info-item">
                    <span>TANGGAL SESI</span>
                    <strong>{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</strong>
                </div>
                <div class="info-item">
                    <span>WAKTU SESI</span>
                    <strong>{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }} WIB</strong>
                </div>
                <div class="info-item">
                    <span>TOTAL BAYAR</span>
                    <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>
        <div class="status-side">
            <div class="status-badge status-{{ $booking->status }}">
                {{ $booking->status == 'pending' ? 'BUM LUNAS' : ($booking->status == 'confirmed' ? 'LUNAS' : strtoupper($booking->status)) }}
            </div>
            <a href="{{ route('booking.show', $booking->id) }}" class="btn-view-detail">Lihat Detail</a>
        </div>
    </div>
    @empty
    <div class="empty-action">
        <i class="far fa-calendar-times" style="font-size: 4rem; color: var(--border-color); margin-bottom: 20px; display: block;"></i>
        <h2 style="font-family: 'Playfair Display', serif; color: var(--primary-dark);">Belum Ada Pesanan</h2>
        <p style="color: #8C6474; margin-bottom: 30px;">Kamu belum pernah melakukan pemesanan di Vibes Studio.</p>
        <a href="{{ route('home') }}#paket" class="btn-wa" style="text-decoration: none; background: var(--primary); padding: 12px 40px; border-radius: 30px; color: white;">Mulai Booking Sekarang</a>
    </div>
    @endforelse
</div>
@endsection
