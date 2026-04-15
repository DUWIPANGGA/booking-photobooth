@extends('layouts.guest')

@section('title', 'Detail Pemesanan - Vibes Studio')

@push('styles')
<style>
    .page-wrapper { background-color: #FDF5F2; min-height: 100vh; padding: 60px 0; }
    .detail-container { max-width: 950px; margin: 0 auto; padding: 0 24px; }
    
    .back-nav { margin-bottom: 24px; position: absolute; left: 40px; top: 120px; }
    .btn-kembali {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px;
        background: white; border: 1px solid #eee; border-radius: 12px;
        color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 500;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: 0.3s;
    }
    .btn-kembali:hover { transform: translateX(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }

    .page-title { text-align: center; font-family: 'Playfair Display', serif; font-size: 2.8rem; color: #5C1F2D; margin-bottom: 40px; font-weight: 700; position: relative; }
    .page-title::after { 
        content: ''; position: absolute; bottom: -15px; left: 50%; transform: translateX(-50%); 
        width: 180px; height: 1.5px; background: #E8D5D0; 
    }

    .main-detail-card { 
        background: white; border-radius: 20px; padding: 40px; 
        box-shadow: 0 15px 50px rgba(123, 45, 62, 0.08); display: flex; gap: 40px; 
        align-items: stretch;
    }

    .info-left { flex: 1; border-right: 1.5px solid #FDF5F2; padding-right: 40px; }
    .info-right { flex: 0 0 400px; display: flex; flex-direction: column; justify-content: space-between; }

    .reservasi-code { font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #5C1F2D; font-weight: 700; margin-bottom: 40px; }
    
    .detail-list { list-style: none; }
    .detail-list li { 
        font-family: 'Poppins', sans-serif; font-size: 1.25rem; color: #5C1F2D; 
        margin-bottom: 15px; display: flex; align-items: center; gap: 12px;
    }
    .detail-list li::before { content: '•'; color: #80404D; font-size: 2rem; line-height: 0; margin-top: 5px; }

    /* Payment Box */
    .payment-box { 
        background: white; border-radius: 20px; padding: 30px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.04); text-align: center; height: 100%;
        display: flex; flex-direction: column; justify-content: center;
    }
    .payment-title { font-family: 'Poppins', sans-serif; font-size: 1.4rem; color: #8C6474; margin-bottom: 25px; }
    .payment-desc { font-size: 1.2rem; line-height: 1.4; color: #5C1F2D; margin-bottom: 30px; }
    .payment-total { font-family: 'Poppins', sans-serif; font-size: 1.4rem; color: #5C1F2D; font-weight: 600; text-align: right; margin-bottom: 30px; }

    .action-row { display: flex; gap: 15px; justify-content: center; }
    
    .btn-download { 
        flex: 1; border: 2px solid #80404D; color: #80404D; text-decoration: none;
        padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 10px;
        font-weight: 600; font-size: 1rem; transition: 0.3s;
    }
    .btn-download:hover { background: #80404D; color: white; }

    .btn-cancel { 
        flex: 1; background: #80404D; color: white; border: none;
        padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 10px;
        font-weight: 600; font-size: 1rem; cursor: pointer; transition: 0.3s;
    }
    .btn-cancel:hover { background: #5C1F2D; transform: translateY(-2px); }

    /* PRINT STYLE (A4 CINEMATIC TICKET) */
    @media print {
        @page { size: A4 portrait; margin: 0; }
        body { background: white !important; margin: 0; padding: 0; }
        .site-header, .site-logo, .navbar, .back-nav, .btn-download, .btn-cancel, .page-title::after { display: none !important; }
        
        .page-wrapper { background: white !important; padding: 0 !important; min-height: auto !important; }
        .detail-container { visibility: visible; width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; position: static !important; }
        
        .page-title { visibility: visible; display: block !important; margin-top: 50px !important; text-align: center !important; font-size: 2.5rem !important; }

        .main-detail-card { 
            visibility: visible; display: flex !important; border: 2px solid #5C1F2D !important; 
            margin: 40px !important; border-radius: 0 !important; box-shadow: none !important;
            padding: 0 !important; overflow: hidden; height: 450px;
        }

        .info-left { 
            visibility: visible; flex: 2; border-right: 2px dashed #5C1F2D !important; 
            padding: 40px !important; background: #FFF5F2 !important; position: relative;
        }
        .info-left::after {
            content: 'VIBES STUDIO'; position: absolute; bottom: 20px; right: 20px;
            font-size: 4rem; font-weight: 800; opacity: 0.05; font-family: 'Poppins', sans-serif;
        }

        .info-right { visibility: visible; flex: 1; padding: 40px !important; display: flex !important; flex-direction: column !important; justify-content: center !important; }
        
        .payment-box { visibility: visible; border: none !important; box-shadow: none !important; padding: 0 !important; }
        .reservasi-code { visibility: visible; font-size: 2.2rem !important; margin-bottom: 20px !important; border-bottom: 2px solid #5C1F2D; display: inline-block; }
        
        .detail-list li { visibility: visible; font-size: 1.1rem !important; margin-bottom: 15px !important; }
        .detail-list li::before { visibility: visible; font-size: 1.5rem !important; }

        .payment-title { visibility: visible; font-size: 1.4rem !important; text-transform: uppercase; letter-spacing: 2px; }
        .payment-desc { visibility: visible; font-size: 0.95rem !important; margin-bottom: 30px !important; }
        .payment-total { visibility: visible; font-size: 1.8rem !important; border-top: 2px solid #5C1F2D !important; padding-top: 15px !important; color: #5C1F2D !important; }

        .footer-note { 
            display: block !important; visibility: visible; text-align: center; margin-top: 20px; font-size: 1rem;
            color: #8C6474;
        }
    }

    .footer-note { display: none; }

    @media (max-width: 900px) {
        .main-detail-card { flex-direction: column; }
        .info-right { flex: 1; min-width: 100%; }
        .info-left { border-right: none; border-bottom: 1.5px solid #FDF5F2; padding-right: 0; padding-bottom: 40px; }
        .back-nav { position: static; margin-bottom: 20px; }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="detail-container">
        <div class="back-nav">
            <a href="{{ route('home') }}" class="btn-kembali">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <h1 class="page-title">Detail Pemesanan</h1>

        <div class="main-detail-card">
            <!-- Left Section -->
            <div class="info-left">
                <div class="reservasi-code">Kode Reservasi: VS{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
                
                <ul class="detail-list">
                    <li>Nama: {{ $booking->user->name }}</li>
                    <li>Tanggal: {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</li>
                    <li>Jam: {{ \Carbon\Carbon::parse($booking->booking_time)->format('H.i') }}-{{ \Carbon\Carbon::parse($booking->booking_time)->addMinutes((int)$booking->duration)->format('H.i') }}</li>
                    <li>Paket: {{ $booking->package->name }}</li>
                    <li>Durasi: {{ $booking->duration }} Menit</li>
                    <li>Jumlah Orang: {{ $booking->extra_persons ? $booking->package->max_person . ' + 2' : $booking->package->max_person }} Orang</li>
                </ul>
            </div>

            <!-- Right Section -->
            <div class="info-right">
                <div class="payment-box">
                    <h3 class="payment-title">Informasi Pembayaran</h3>
                    <p class="payment-desc">
                        Pembayaran dilakukan langsung di studio setelah sesi foto selesai.
                    </p>
                    <div class="payment-total">
                        Total: Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </div>

                    <div class="action-row">
                        <a href="javascript:window.print()" class="btn-download">
                            <i class="fas fa-download"></i> Download Bukti
                        </a>
                        <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-cancel">
                                Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="footer-note">
                <p>Terima kasih telah memilih Vibes Studio!</p>
                <p>Simpan bukti ini untuk ditunjukkan saat kedatangan.</p>
                <p style="margin-top: 10px; font-weight: bold;">#SaveYourMemories</p>
            </div>
        </div>
    </div>
</div>
@endsection
