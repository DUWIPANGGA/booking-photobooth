@extends('layouts.guest')

@section('title', 'Beranda')

@push('styles')
<style>
    /* ===== HERO SECTION ===== */
    .hero-section {
        min-height: calc(100vh - 130px);
        display: flex;
        align-items: center;
        background-color: var(--bg-light);
        padding: 60px 80px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -60%;
        right: -15%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(196,118,138,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(123,45,62,0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-content {
        flex: 1;
        max-width: 480px;
        z-index: 1;
        animation: fadeInLeft 0.8s ease;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        color: var(--primary-dark);
        line-height: 1.25;
        margin-bottom: 20px;
    }

    .hero-subtitle {
        font-size: 1.05rem;
        color: var(--primary);
        line-height: 1.7;
        font-weight: 400;
        margin-bottom: 36px;
    }

    .hero-cta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .btn-cta-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--white);
        padding: 14px 32px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        box-shadow: 0 4px 20px rgba(123,45,62,0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cta-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px rgba(123,45,62,0.4);
        color: var(--white);
    }

    .btn-cta-outline {
        border: 2px solid var(--primary);
        color: var(--primary);
        padding: 12px 30px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cta-outline:hover {
        background-color: var(--primary);
        color: var(--white);
        transform: translateY(-2px);
    }

    /* ===== HERO VISUAL ===== */
    .hero-visual {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1;
        animation: fadeInRight 0.8s ease;
    }

    .hero-logo-circle {
        width: 380px;
        height: 380px;
        border-radius: 50%;
        background: radial-gradient(circle at 40% 40%, #FFFFFF 0%, #F0E4E0 50%, #E8D5D0 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow:
            0 0 0 12px rgba(123,45,62,0.06),
            0 0 0 24px rgba(123,45,62,0.03),
            0 20px 60px rgba(123,45,62,0.18);
        text-align: center;
        padding: 30px;
        position: relative;
        transition: var(--transition);
    }

    .hero-logo-circle:hover {
        transform: scale(1.02) rotate(1deg);
        box-shadow:
            0 0 0 14px rgba(123,45,62,0.08),
            0 0 0 28px rgba(123,45,62,0.04),
            0 30px 80px rgba(123,45,62,0.22);
    }

    .hero-logo-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3D1A24 0%, #6B2233 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        box-shadow: 0 8px 24px rgba(61,26,36,0.3);
    }

    .hero-logo-icon i {
        font-size: 2.8rem;
        color: #D4A574;
    }

    .hero-logo-name {
        font-family: 'Great Vibes', cursive;
        font-size: 2.6rem;
        color: var(--primary-dark);
        line-height: 1.1;
        margin-bottom: 8px;
    }

    .hero-logo-tagline {
        font-family: 'Poppins', sans-serif;
        font-size: 0.7rem;
        letter-spacing: 3px;
        color: var(--text-muted);
        text-transform: lowercase;
        font-weight: 400;
    }

    /* ===== STATS STRIP ===== */
    .stats-strip {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        padding: 30px 80px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        gap: 20px;
    }

    .stat-item {
        text-align: center;
        color: var(--white);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        display: block;
    }

    .stat-label {
        font-size: 0.8rem;
        opacity: 0.85;
        letter-spacing: 0.5px;
    }

    .stat-divider {
        width: 1px;
        height: 50px;
        background: rgba(255,255,255,0.2);
    }

    /* ===== FEATURES SECTION ===== */
    .features-section {
        padding: 80px 80px;
        background-color: var(--bg-light);
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-tag {
        display: inline-block;
        background: rgba(123,45,62,0.1);
        color: var(--primary);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--primary-dark);
        margin-bottom: 12px;
    }

    .section-subtitle {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .section-divider {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-soft));
        border-radius: 2px;
        margin: 16px auto 0;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    .feature-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        padding: 36px 28px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-soft));
        transform: scaleX(0);
        transition: var(--transition);
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-md);
    }

    .feature-card:hover::before {
        transform: scaleX(1);
    }

    .feature-icon {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(123,45,62,0.08), rgba(123,45,62,0.15));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        transition: var(--transition);
    }

    .feature-card:hover .feature-icon {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    }

    .feature-icon i {
        font-size: 1.7rem;
        color: var(--primary);
        transition: var(--transition);
    }

    .feature-card:hover .feature-icon i {
        color: var(--white);
    }

    .feature-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 10px;
    }

    .feature-desc {
        color: var(--text-muted);
        font-size: 0.875rem;
        line-height: 1.7;
    }

    /* ===== PACKAGES SECTION ===== */
    .packages-section {
        padding: 80px 80px;
        background: linear-gradient(180deg, var(--bg-light) 0%, #EFE3DE 100%);
        scroll-margin-top: 70px;
    }

    .packages-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        margin-top: 0;
    }

    .package-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        padding: 36px 28px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        transition: var(--transition);
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .package-card.featured {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        color: var(--white);
        transform: scale(1.04);
        box-shadow: var(--shadow-lg);
        border-color: transparent;
    }

    .package-card:hover:not(.featured) {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .package-badge {
        position: absolute;
        top: -12px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(90deg, #D4A574, #C4906A);
        color: #3D1A24;
        padding: 4px 18px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .package-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 6px;
        color: var(--primary-dark);
    }

    .package-card.featured .package-name { color: var(--white); }

    .package-price {
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: var(--primary);
        margin-bottom: 4px;
    }

    .package-card.featured .package-price { color: #D4A574; }

    .package-duration {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 20px;
    }

    .package-card.featured .package-duration { color: rgba(255,255,255,0.7); }

    .package-divider {
        height: 1px;
        background: var(--border-color);
        margin-bottom: 20px;
    }

    .package-card.featured .package-divider { background: rgba(255,255,255,0.2); }

    .package-features {
        list-style: none;
        flex: 1;
        margin-bottom: 28px;
    }

    .package-features li {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 0;
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    .package-card.featured .package-features li { color: rgba(255,255,255,0.85); }

    .package-features li i {
        font-size: 0.75rem;
        color: var(--primary-soft);
        width: 16px;
        flex-shrink: 0;
    }

    .package-card.featured .package-features li i { color: #D4A574; }

    .btn-package {
        display: block;
        text-align: center;
        padding: 12px 24px;
        border-radius: 24px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: var(--transition);
    }

    .btn-package-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        box-shadow: 0 4px 16px rgba(123,45,62,0.25);
    }

    .btn-package-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(123,45,62,0.35);
        color: var(--white);
    }

    .btn-package-white {
        background: var(--white);
        color: var(--primary-dark);
        box-shadow: 0 4px 16px rgba(255,255,255,0.25);
    }

    .btn-package-white:hover {
        background: rgba(255,255,255,0.9);
        transform: translateY(-2px);
        color: var(--primary-dark);
    }

    /* ===== GALLERY SECTION ===== */
    .gallery-section {
        padding: 80px 80px;
        background-color: var(--bg-card);
        scroll-margin-top: 70px;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: auto auto;
        gap: 16px;
    }

    .gallery-item {
        border-radius: var(--radius-sm);
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, var(--bg-light), var(--border-color));
        aspect-ratio: 1;
        cursor: pointer;
        transition: var(--transition);
    }

    .gallery-item:first-child {
        grid-column: span 2;
        grid-row: span 2;
        aspect-ratio: 1;
    }

    .gallery-item:hover {
        transform: scale(1.02);
        box-shadow: var(--shadow-md);
        z-index: 2;
    }

    .gallery-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: var(--primary-soft);
        font-size: 0.8rem;
        min-height: 150px;
    }

    .gallery-placeholder i { font-size: 2rem; opacity: 0.5; }

    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(123,45,62,0.7), transparent);
        opacity: 0;
        transition: var(--transition);
        display: flex;
        align-items: flex-end;
        padding: 16px;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-overlay span {
        color: var(--white);
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* ===== HOW TO SECTION ===== */
    .how-section {
        padding: 80px 80px;
        background: var(--bg-light);
        scroll-margin-top: 70px;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        position: relative;
    }

    .steps-grid::after {
        content: '';
        position: absolute;
        top: 36px;
        left: 12.5%;
        right: 12.5%;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-soft), transparent);
        pointer-events: none;
    }

    .step-item {
        text-align: center;
        position: relative;
        z-index: 1;
        animation: fadeInUp 0.6s ease forwards;
    }

    .step-number {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        font-size: 1.4rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 8px 24px rgba(123,45,62,0.25);
        transition: var(--transition);
    }

    .step-item:hover .step-number {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 12px 32px rgba(123,45,62,0.35);
    }

    .step-title {
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .step-desc {
        color: var(--text-muted);
        font-size: 0.82rem;
        line-height: 1.6;
    }

    /* ===== CTA BANNER ===== */
    .cta-banner {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 50%, var(--primary-light) 100%);
        padding: 70px 80px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        pointer-events: none;
    }

    .cta-banner::after {
        content: '';
        position: absolute;
        bottom: -60%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%;
        pointer-events: none;
    }

    .cta-banner h2 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        color: var(--white);
        margin-bottom: 14px;
        position: relative;
        z-index: 1;
    }

    .cta-banner p {
        color: rgba(255,255,255,0.8);
        font-size: 1rem;
        margin-bottom: 32px;
        position: relative;
        z-index: 1;
    }

    .btn-cta-white {
        background: var(--white);
        color: var(--primary-dark);
        padding: 14px 40px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    }

    .btn-cta-white:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 32px rgba(0,0,0,0.2);
        color: var(--primary-dark);
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(30px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .hero-section         { padding: 50px 40px; }
        .hero-title           { font-size: 2.4rem; }
        .hero-logo-circle     { width: 300px; height: 300px; }
        .features-section,
        .packages-section,
        .gallery-section,
        .how-section,
        .stats-strip,
        .cta-banner           { padding-left: 40px; padding-right: 40px; }
        .steps-grid::after    { display: none; }
    }

    @media (max-width: 768px) {
        .hero-section {
            flex-direction: column;
            text-align: center;
            padding: 40px 24px;
            gap: 40px;
        }

        .hero-content     { max-width: 100%; }
        .hero-cta         { justify-content: center; }
        .hero-logo-circle { width: 260px; height: 260px; }
        .hero-title       { font-size: 2rem; }

        .features-grid,
        .packages-grid    { grid-template-columns: 1fr; }
        .package-card.featured { transform: none; }

        .gallery-grid     { grid-template-columns: repeat(2, 1fr); }
        .gallery-item:first-child { grid-column: span 2; }

        .steps-grid       { grid-template-columns: repeat(2, 1fr); }

        .stats-strip {
            flex-wrap: wrap;
            gap: 16px;
            padding: 24px;
        }
        .stat-divider { display: none; }

        .features-section,
        .packages-section,
        .gallery-section,
        .how-section,
        .cta-banner { padding: 50px 24px; }
    }
</style>
@endpush

@section('content')

<!-- ===== HERO SECTION ===== -->
<section class="hero-section" style="background-color: #FDF5F2;">
    <div class="hero-content" style="max-width: 600px;">
        <h1 class="hero-title" style="font-weight: 900; font-family: 'Poppins', sans-serif; font-size: 3.5rem; color: #000; margin-bottom: 20px; line-height: 1.1;">Selamat Datang<br>di Vibes Studio</h1>
        <p class="hero-subtitle" style="font-size: 1.6rem; font-family: 'Playfair Display', serif; color: #5C1F2D; margin-bottom: 40px; line-height: 1.4;">
            Tempat terbaik untuk menyimpan momen berharga<br>
            bersama orang tersayang 😊❤️
        </p>
        <div class="hero-cta">
            <a href="{{ auth()->check() ? (auth()->user()->role == 'admin' ? route('admin.dashboard') : route('booking.create')) : route('login') }}" 
               class="btn-cta-primary" 
               style="padding: 16px 50px; font-size: 1.2rem; background-color: #80404D; border-radius: 40px; border: none; font-weight: 600; font-family: 'Playfair Display', serif;">
                Pesan Sekarang
            </a>
        </div>
    </div>

    <div class="hero-visual">
        <div class="hero-logo-circle" style="width: 450px; height: 450px; background: white; border: 15px solid #FDF5F2; outline: none; box-shadow: 0 30px 60px rgba(0,0,0,0.05);">
            <div class="hero-logo-icon" style="width: 140px; height: 140px; background: #3D1A24;">
                <i class="fas fa-home" style="font-size: 4rem; color: #FFFFFF;"></i>
            </div>
            <div class="hero-logo-name" style="font-size: 3.5rem; letter-spacing: -1px;">Vibes Studio</div>
            <div class="hero-logo-tagline" style="font-size: 0.9rem; letter-spacing: 4px;">save your memories here!</div>
        </div>
    </div>
</section>

<!-- ===== STATS STRIP ===== -->
<div class="stats-strip">
    <div class="stat-item">
        <span class="stat-number">500+</span>
        <span class="stat-label">Pelanggan Puas</span>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <span class="stat-number">3</span>
        <span class="stat-label">Paket Tersedia</span>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <span class="stat-number">4.9⭐</span>
        <span class="stat-label">Rating Kepuasan</span>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <span class="stat-number">2 Tahun</span>
        <span class="stat-label">Pengalaman</span>
    </div>
</div>

<!-- ===== FEATURES SECTION ===== -->
<section class="features-section" id="fitur">
    <div class="section-header">
        <span class="section-tag">✨ Keunggulan Kami</span>
        <h2 class="section-title">Kenapa Pilih Vibes Studio?</h2>
        <p class="section-subtitle">Kami hadir untuk membuat setiap momen menjadi tak terlupakan</p>
        <div class="section-divider"></div>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-camera-retro"></i>
            </div>
            <h3 class="feature-title">Kamera Profesional</h3>
            <p class="feature-desc">Menggunakan peralatan kamera terkini untuk menghasilkan foto berkualitas tinggi dan jernih.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-palette"></i>
            </div>
            <h3 class="feature-title">Frame Kekinian</h3>
            <p class="feature-desc">Ribuan pilihan tema dan frame unik yang selalu diperbarui mengikuti tren terkini.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-bolt"></i>
            </div>
            <h3 class="feature-title">Cetak Instan</h3>
            <p class="feature-desc">Hasil foto langsung dicetak dalam hitungan detik menggunakan printer berkualitas premium.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-cloud-download-alt"></i>
            </div>
            <h3 class="feature-title">Soft Copy Digital</h3>
            <p class="feature-desc">Semua foto tersimpan dan bisa diunduh kapanpun, dimanapun melalui link eksklusif.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3 class="feature-title">Cocok Semua Momen</h3>
            <p class="feature-desc">Ulang tahun, pernikahan, wisuda, gathering — semua momen spesial kami siap abadikan.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <i class="fas fa-star"></i>
            </div>
            <h3 class="feature-title">Mudah & Terjangkau</h3>
            <p class="feature-desc">Booking online mudah, harga bersahabat, dan layanan terbaik untuk pengalaman foto yang menyenangkan.</p>
        </div>
    </div>
</section>

<!-- ===== PACKAGES SECTION ===== -->
<section class="packages-section" id="paket">
    <div class="section-header">
        <span class="section-tag">📦 Paket Kami</span>
        <h2 class="section-title">Pilih Paket Terbaik</h2>
        <p class="section-subtitle">Semua paket sudah termasuk cetak foto langsung di tempat</p>
        <div class="section-divider"></div>
    </div>
    <div class="packages-grid">
        @foreach($packages as $pkg)
        <div class="package-card {{ $pkg->name == 'Teater Vibes' ? 'featured' : '' }}">
            @if($pkg->name == 'Teater Vibes')
                <div class="package-badge">⭐ Terpopuler</div>
            @endif
            <div class="package-name">{{ $pkg->name }}</div>
            <div class="package-price">Rp {{ number_format($pkg->price, 0, ',', '.') }}</div>
            <div class="package-duration">/ sesi ({{ $pkg->duration }} menit)</div>
            <div class="package-divider"></div>
            <ul class="package-features">
                <li><i class="fas fa-check"></i> {{ $pkg->max_person }}</li>
                @if($pkg->features && is_array($pkg->features))
                    @foreach($pkg->features as $feature)
                        <li><i class="fas fa-check"></i> {{ $feature }}</li>
                    @endforeach
                @endif
            </ul>
            <a href="{{ auth()->check() ? route('booking.create', ['package_id' => $pkg->id]) : route('register') }}" class="btn-package {{ $pkg->name == 'Teater Vibes' ? 'btn-package-white' : 'btn-package-primary' }}">Pilih Paket</a>
        </div>
        @endforeach
    </div>
</section>

<!-- ===== GALLERY SECTION ===== -->
<section class="gallery-section" id="galeri">
    <div class="section-header">
        <span class="section-tag">📷 Galeri</span>
        <h2 class="section-title">Momen Indah Pelanggan</h2>
        <p class="section-subtitle">Setiap foto bercerita tentang kebahagiaan yang tak ternilai</p>
        <div class="section-divider"></div>
    </div>
    <div class="gallery-grid">
        @forelse($galleryPhotos as $photo)
        <div class="gallery-item">
            <img src="{{ asset('storage/' . $photo->image) }}" alt="Gallery" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="gallery-overlay"><span>📸 {{ $photo->category->name }}</span></div>
        </div>
        @empty
        <div class="gallery-item">
            <div class="gallery-placeholder">
                <i class="fas fa-image"></i>
                <span>Belum ada foto</span>
            </div>
            <div class="gallery-overlay"><span>📸 Vibes Studio</span></div>
        </div>
        @endforelse
    </div>
</section>

<!-- ===== HOW TO ORDER SECTION ===== -->
<section class="how-section" id="cara-transaksi">
    <div class="section-header">
        <span class="section-tag">📋 Cara Transaksi</span>
        <h2 class="section-title">Cara Pesan Semudah 1-2-3-4</h2>
        <p class="section-subtitle">Proses booking yang cepat, mudah, dan menyenangkan</p>
        <div class="section-divider"></div>
    </div>
    <div class="steps-grid">
        <div class="step-item">
            <div class="step-number">1</div>
            <div class="step-title">Daftar / Login</div>
            <p class="step-desc">Buat akun atau login ke akun yang sudah ada untuk mulai proses booking.</p>
        </div>
        <div class="step-item">
            <div class="step-number">2</div>
            <div class="step-title">Pilih Paket</div>
            <p class="step-desc">Pilih paket yang sesuai dengan kebutuhan dan anggaran kamu.</p>
        </div>
        <div class="step-item">
            <div class="step-number">3</div>
            <div class="step-title">Tentukan Jadwal</div>
            <p class="step-desc">Pilih tanggal dan jam sesi foto yang tersedia sesuai keinginanmu.</p>
        </div>
        <div class="step-item">
            <div class="step-number">4</div>
            <div class="step-title">Bayar & Datang!</div>
            <p class="step-desc">Lakukan pembayaran dan datang ke studio tepat waktu. Let's gooo! 🎉</p>
        </div>
    </div>
</section>

<!-- ===== CTA BANNER ===== -->
<section class="cta-banner" id="pemesanan">
    <h2>Siap Mengabadikan Momenmu? 📸</h2>
    <p>Jangan tunda lagi! Booking sekarang dan dapatkan kenangan indah bersama orang-orang tercinta.</p>
    <a href="{{ route('register') }}" class="btn-cta-white" id="cta-book-btn">
        <i class="fas fa-calendar-check"></i>
        Booking Sekarang — Gratis Daftar!
    </a>
</section>

@endsection

@push('scripts')
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Intersection Observer for animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.feature-card, .package-card, .step-item, .gallery-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
</script>
@endpush
