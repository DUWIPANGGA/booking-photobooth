@extends('layouts.guest')

@section('title', 'Dashboard Saya - Vibes Studio')

@push('styles')
<style>
    .dashboard-container { max-width: 1100px; margin: 40px auto; padding: 0 24px; }
    
    .welcome-banner { 
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 24px; padding: 60px 50px; color: white; margin-bottom: 40px;
        position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(123,45,62,0.2);
    }
    .welcome-banner h1 { font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 10px; }
    .welcome-banner p { opacity: 0.9; font-size: 1.1rem; }
    .welcome-bg-icon { position: absolute; right: -20px; top: -20px; font-size: 12rem; opacity: 0.1; transform: rotate(-15deg); }

    .dash-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
    
    .dash-card { background: white; border-radius: 20px; padding: 30px; border: 1px solid var(--border-color); box-shadow: var(--shadow-md); }
    .card-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--primary-dark); margin-bottom: 25px; display: flex; align-items: center; gap: 12px; }
    
    .quick-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
    .stat-box { background: var(--bg-light); padding: 20px; border-radius: 16px; border: 1px solid var(--border-color); text-align: center; }
    .stat-val { display: block; font-size: 1.8rem; font-weight: 800; color: var(--primary); }
    .stat-lbl { font-size: 0.75rem; color: #8C6474; font-weight: 700; text-transform: uppercase; }

    .last-booking { 
        background: #fdfdfd; border: 1.5px solid var(--bg-light); border-radius: 16px; 
        padding: 20px; display: flex; align-items: center; gap: 20px;
    }
    .lb-icon { width: 60px; height: 60px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--primary); border: 1px solid var(--border-color); }
    .lb-info h4 { font-size: 1rem; color: var(--primary-dark); margin-bottom: 4px; }
    .lb-info p { font-size: 0.8rem; color: #888; }
    
    .btn-action-dash { 
        display: block; width: 100%; padding: 15px; border-radius: 12px; text-align: center; 
        text-decoration: none; font-weight: 700; font-size: 0.95rem; margin-bottom: 15px;
        transition: 0.3s;
    }
    .btn-book { background: var(--primary); color: white; }
    .btn-history { background: white; border: 1.5px solid var(--primary); color: var(--primary); }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="welcome-banner">
        <i class="fas fa-camera welcome-bg-icon"></i>
        <div style="position: relative; z-index: 2;">
            <h1>Halo, {{ auth()->user()->name }}!</h1>
            <p>Selamat datang kembali di Vibes Studio. Siap untuk mengabadikan momen serumu hari ini?</p>
        </div>
    </div>

    <div class="dash-grid">
        <div class="left-col">
            <div class="dash-card">
                <h3 class="card-title"><i class="fas fa-history"></i> Ringkasan Sesi Anda</h3>
                
                <div class="quick-stats">
                    <div class="stat-box">
                        <span class="stat-val">{{ auth()->user()->bookings()->count() }}</span>
                        <span class="stat-lbl">Total Booking</span>
                    </div>
                    <div class="stat-box">
                        <span class="stat-val">{{ auth()->user()->bookings()->where('status', 'finished')->count() }}</span>
                        <span class="stat-lbl">Sesi Selesai</span>
                    </div>
                </div>

                <h4 style="font-size: 0.9rem; color: var(--primary-dark); margin-bottom: 15px;">Pemesanan Terakhir</h4>
                @php $lastBooking = auth()->user()->bookings()->latest()->first(); @endphp
                @if($lastBooking)
                    <div class="last-booking">
                        <div class="lb-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div class="lb-info" style="flex: 1;">
                            <h4>Paket {{ $lastBooking->package->name }}</h4>
                            <p>{{ \Carbon\Carbon::parse($lastBooking->booking_date)->translatedFormat('d F Y') }} • {{ $lastBooking->booking_time }} WIB</p>
                        </div>
                        <div class="status-badge status-{{ $lastBooking->status }}" style="font-size: 0.65rem; padding: 4px 12px; border-radius: 10px; background: {{ $lastBooking->status == 'pending' ? '#FFF4E5' : '#E1F9E1' }}; color: {{ $lastBooking->status == 'pending' ? '#856404' : '#1E7E34' }};">
                            {{ strtoupper($lastBooking->status) }}
                        </div>
                    </div>
                    <a href="{{ route('booking.show', $lastBooking->id) }}" style="display: block; text-align: right; font-size: 0.8rem; color: var(--primary); margin-top: 10px; font-weight: 700; text-decoration: none;">Lihat Detail →</a>
                @else
                    <div style="text-align: center; padding: 30px; background: #fafafa; border-radius: 16px; border: 1.5px dashed #eee;">
                        <p style="font-size: 0.85rem; color: #999;">Anda belum memiliki riwayat pemesanan.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="right-col">
            <div class="dash-card">
                <h3 class="card-title" style="margin-bottom: 30px;"><i class="fas fa-rocket"></i> Menu Cepat</h3>
                
                <a href="{{ route('home') }}#paket" class="btn-action-dash btn-book">
                    <i class="fas fa-plus-circle"></i> Buat Booking Baru
                </a>
                <a href="{{ route('booking.index') }}" class="btn-action-dash btn-history">
                    <i class="fas fa-list-ul"></i> Riwayat Pemesanan
                </a>
                
                <div style="margin-top: 40px; border-top: 1px solid #eee; padding-top: 30px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="width: 45px; height: 45px; background: #25D366; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div>
                            <span style="display: block; font-size: 0.85rem; font-weight: 700; color: #333;">Butuh Bantuan?</span>
                            <a href="https://wa.me/6285603071072" style="font-size: 0.75rem; color: #25D366; text-decoration: none; font-weight: 600;">Hubungi Admin via WA</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
