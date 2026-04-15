@extends('layouts.guest')

@section('title', 'Cara Transaksi')

@push('styles')
<style>
    .trans-section {
        padding: 60px 24px;
        background-color: var(--bg-light);
        text-align: center;
        min-height: calc(100vh - 130px);
    }

    .btn-kembali-trans {
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
    .btn-kembali-trans:hover {
        background: var(--primary);
        color: white;
    }

    .trans-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.6rem;
        color: var(--primary-dark);
        margin: 40px 0 10px;
        clear: both;
        font-weight: 700;
    }

    .trans-divider {
        width: 120px;
        height: 2px;
        background: var(--primary-soft);
        margin: 0 auto 60px;
    }

    /* Steps Grid */
    .trans-steps-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto 50px;
    }

    .trans-step-card {
        background: white;
        border-radius: 12px;
        padding: 40px 24px;
        position: relative;
        box-shadow: var(--shadow-sm);
        border: 1.5px solid var(--border-color);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .trans-step-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-soft);
    }

    .step-badge {
        position: absolute;
        top: -24px;
        left: 50%;
        transform: translateX(-50%);
        width: 48px;
        height: 48px;
        background: #9E4458;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        box-shadow: 0 4px 10px rgba(158, 68, 88, 0.4);
    }

    .step-icon-box {
        margin: 20px 0;
    }

    .step-icon-box i {
        font-size: 3rem;
        color: #C08C78; /* Muted copper/brown as in screenshot */
    }

    .step-name {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: var(--primary-dark);
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .step-text {
        font-size: 0.85rem;
        color: #8C6474;
        line-height: 1.6;
        padding: 0 5px;
    }

    /* Contact Box */
    .contact-box {
        max-width: 500px;
        margin: 80px auto 0;
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: var(--shadow-sm);
        border: 1.5px solid var(--border-color);
    }

    .contact-btn-row {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 24px;
        flex-wrap: wrap;
    }

    .contact-link {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-dark);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: var(--transition);
    }

    .contact-link:hover {
        color: var(--primary);
    }

    .contact-link i {
        font-size: 1.4rem;
    }

    .contact-link.wa i { color: #25D366; }
    .contact-link.ig i { color: #E4405F; }

    @media (max-width: 1024px) {
        .trans-steps-grid { grid-template-columns: repeat(2, 1fr); gap: 40px 20px; }
    }

    @media (max-width: 600px) {
        .trans-steps-grid { grid-template-columns: 1fr; gap: 45px 0; }
        .trans-title { font-size: 2rem; }
    }
</style>
@endpush

@section('content')
<section class="trans-section">
    <div class="container" style="max-width: 1200px; margin: 0 auto; overflow: hidden;">
        <a href="{{ route('home') }}" class="btn-kembali-trans">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <h1 class="trans-title">Cara Transaksi</h1>
        <div class="trans-divider"></div>

        <div class="trans-steps-grid">
            <!-- Step 1 -->
            <div class="trans-step-card">
                <div class="step-badge">1</div>
                <div class="step-icon-box">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="step-name">Pilih Paket</div>
                <p class="step-text">Pilih paket pemotretan yang sesuai dengan kebutuhan Anda untuk mengabadikan momen terbaik.</p>
            </div>

            <!-- Step 2 -->
            <div class="trans-step-card">
                <div class="step-badge">2</div>
                <div class="step-icon-box">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="step-name">Isi Reservasi</div>
                <p class="step-text">Lengkapi reservasi pemesanan dengan memilih jadwal, tema, serta detail sesi foto sesuai keinginan Anda.</p>
            </div>

            <!-- Step 3 -->
            <div class="trans-step-card">
                <div class="step-badge">3</div>
                <div class="step-icon-box">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div class="step-name">Konfirmasi Booking</div>
                <p class="step-text">Periksa kembali detail pemesanan Anda untuk memastikan semua data sudah sesuai sebelum melanjutkan.</p>
            </div>

            <!-- Step 4 -->
            <div class="trans-step-card">
                <div class="step-badge">4</div>
                <div class="step-icon-box">
                    <i class="fas fa-store"></i>
                </div>
                <div class="step-name">Datang & Bayar di Tempat</div>
                <p class="step-text">Datang sesuai jadwal dan tunjukan detail booking, lalu lakukan pembayaran ditempat.</p>
            </div>
        </div>

        <div class="contact-box">
            <h3 style="color: var(--primary-dark); font-size: 1.1rem; margin-bottom: 10px;">Ada pertanyaan lebih lanjut?</h3>
            <p style="font-size: 0.85rem; color: #8C6474;">Hubungi kami melalui kontak berikut untuk informasi lebih lengkap.</p>
            
            <div class="contact-btn-row">
                <a href="#" class="contact-link wa">
                    <i class="fab fa-whatsapp"></i> +6285603071072
                </a>
                <a href="#" class="contact-link ig">
                    <i class="fab fa-instagram"></i> vibesstudio.im
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
