@extends('layouts.guest')

@section('title', 'Pemesanan Studio - Vibes Studio')

@push('styles')
<style>
    .main-container { max-width: 1000px; margin: 40px auto; padding: 0 24px; }
    
    .back-nav { margin-bottom: 24px; }
    .btn-kembali {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px;
        background: white; border: 1px solid var(--border-color); border-radius: 20px;
        color: var(--primary); text-decoration: none; font-size: 0.85rem; font-weight: 500;
        transition: 0.3s;
    }
    .btn-kembali:hover { background: var(--bg-light); transform: translateX(-5px); }

    .page-title { text-align: center; font-family: 'Playfair Display', serif; font-size: 2.2rem; color: var(--primary-dark); margin-bottom: 40px; }

    .booking-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    
    .card { background: white; border-radius: 12px; padding: 24px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); }
    .full-width-card { grid-column: span 2; }

    /* Package Details */
    .pkg-header { display: flex; gap: 30px; align-items: flex-start; }
    .pkg-image { width: 220px; height: 220px; border-radius: 50%; object-fit: cover; border: 8px solid rgba(123,45,62,0.05); }
    .pkg-info { flex: 1; }
    .pkg-name { font-size: 1.8rem; color: var(--primary-dark); font-weight: 700; margin-bottom: 20px; }
    .pkg-details { list-style: none; display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .pkg-details li { font-size: 0.85rem; color: #3D1A24; display: flex; align-items: center; gap: 10px; }
    .pkg-details li i { color: #C08C78; width: 16px; }

    .add-on-section { margin-top: 20px; }
    .add-on-title { font-weight: 700; font-size: 0.9rem; margin-bottom: 12px; display: block; }
    .add-on-item { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; font-size: 0.85rem; }
    .checkbox-label { display: flex; align-items: center; gap: 10px; cursor: pointer; }
    .add-on-price { background: #7B3E3E; color: white; padding: 2px 8px; border-radius: 10px; font-size: 0.65rem; font-weight: 700; }

    /* Background Concept */
    .bg-concept { margin-top: 20px; }
    .bg-dropdown { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.85rem; }

    /* Form Controls */
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 10px; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 6px; color: var(--primary-dark); }
    .form-input { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 0.85rem; }

    /* Schedule / Time Slots */
    .time-header { font-size: 1rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 20px; }
    .time-picker-row { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
    .time-select { padding: 8px; border: 1px solid var(--primary); border-radius: 6px; background: white; font-weight: 600; }
    .timezone-box { background: white; border: 1px solid var(--primary); padding: 8px 16px; border-radius: 6px; font-weight: 600; }

    .time-slots { 
        display: flex; flex-direction: column; gap: 10px; 
        max-height: 250px; overflow-y: auto; padding-right: 10px;
        margin-top: 15px;
    }
    .time-slots::-webkit-scrollbar { width: 4px; }
    .time-slots::-webkit-scrollbar-track { background: var(--bg-light); border-radius: 10px; }
    .time-slots::-webkit-scrollbar-thumb { background: var(--primary-soft); border-radius: 10px; }

    .time-slot-btn { 
        display: flex; align-items: center; gap: 12px;
        padding: 12px 20px; background: #FFF5F5; border: 1.5px solid #FFEDED; 
        border-radius: 12px; color: #80404D; font-size: 0.82rem; font-weight: 600;
        transition: 0.3s;
    }
    .time-slot-btn i { font-size: 0.9rem; color: #E74C3C; }
    .slot-label { font-size: 0.7rem; color: #C4768A; display: block; margin-top: 2px; }

    /* Calendar */
    .calendar-box { text-align: center; }
    .cal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .cal-month { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-style: italic; color: var(--primary-dark); font-weight: 700; }
    .cal-days { display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; }
    .cal-day-name { font-size: 0.75rem; font-weight: 700; color: #7B3E3E; font-style: italic; }
    .cal-date { 
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; 
        font-size: 0.8rem; border-radius: 4px; cursor: pointer; transition: 0.2s;
        border: 1px solid transparent;
    }
    .cal-date:hover:not(.empty) { background: var(--bg-light); }
    .cal-date.active { background: #7B3E3E; color: white; border-radius: 5px; box-shadow: 0 4px 10px rgba(123,62,62,0.3); }
    .cal-date.today { background: var(--border-color); border-color: var(--primary-soft); }

    /* Total Footer */
    .booking-footer { margin-top: 40px; display: flex; justify-content: space-between; align-items: center; }
    .total-box { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 800; color: var(--primary-dark); }
    .btn-submit { 
        background: #7B3E3E; color: white; padding: 14px 60px; border-radius: 40px; 
        font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700;
        border: none; cursor: pointer; box-shadow: 0 10px 20px rgba(123,62,62,0.3);
        transition: 0.3s;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 15px 30px rgba(123,62,62,0.4); }

    @media (max-width: 850px) {
        .booking-grid { grid-template-columns: 1fr; }
        .full-width-card { grid-column: span 1; }
        .pkg-header { flex-direction: column; align-items: center; text-align: center; }
        .pkg-details { grid-template-columns: 1fr; }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="main-container">
    <div class="back-nav">
        <a href="{{ route('home') }}" class="btn-kembali">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <h1 class="page-title">Pemesanan Studio</h1>

    <form action="{{ route('booking.store') }}" method="POST" id="booking-form">
        @csrf
        <input type="hidden" name="package_id" value="{{ $selectedPackage->id }}">
        <input type="hidden" name="booking_date" id="booking_date_input" value="{{ $selectedDate }}">

        <div class="booking-grid">
            <!-- Package Detail Card -->
            <div class="card full-width-card">
                <div class="pkg-header">
                    <img src="{{ $selectedPackage->image ?? 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?q=80&w=400' }}" alt="Package" class="pkg-image">
                    <div class="pkg-info">
                        <h2 class="pkg-name">{{ $selectedPackage->name }}</h2>
                        <ul class="pkg-details">
                            <li><i class="fas fa-money-bill-wave"></i> Rp {{ number_format($selectedPackage->price, 0, ',', '.') }}</li>
                            <li><i class="far fa-clock"></i> {{ $selectedPackage->duration }} Menit Sesi Foto</li>
                            @if($selectedPackage->features && is_array($selectedPackage->features))
                                @foreach($selectedPackage->features as $feature)
                                    <li><i class="fas fa-check"></i> {{ $feature }}</li>
                                @endforeach
                            @endif
                            <li><i class="fas fa-users"></i> {{ $selectedPackage->max_person }}</li>
                        </ul>
                    </div>
                    <div style="flex: 0 0 250px;">
                        <span class="add-on-title">Add On</span>
                        <div class="add-on-section">
                            <div class="add-on-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="extra_persons" value="1" onchange="updateTotal()"> Extra Person (max 2)
                                </label>
                                <span class="add-on-price">15K</span>
                            </div>
                            <div class="add-on-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="extra_time" value="1" onchange="updateTotal()"> Extra Time 5 minutes
                                </label>
                                <span class="add-on-price">15K</span>
                            </div>
                        </div>

                        <div class="bg-concept">
                            <span class="add-on-title">Background Concept</span>
                            <select name="background_id" class="bg-dropdown" required>
                                <option value="" disabled selected>Pilih Background</option>
                                @foreach($backgrounds as $bg)
                                    <option value="{{ $bg->id }}">{{ $bg->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info Card -->
            <div class="card">
                <h3 class="time-header">Data Pemesan</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-input" placeholder="Masukan Nama" value="{{ auth()->user()->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" class="form-input" placeholder="Masukan No HP" value="{{ auth()->user()->phone_number }}" disabled>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <h3 class="time-header">Pilih Jam Sesi (Durasi {{ $selectedPackage->duration }} Menit)</h3>
                    <div class="time-picker-row">
                        <select name="hour" id="hour_select" class="time-select" onchange="updateTimeInput()">
                            @for($i=10; $i<=21; $i++)
                                <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                            @endfor
                        </select>
                        <span>-</span>
                        <select name="minute" id="minute_select" class="time-select" onchange="updateTimeInput()">
                            @for($i=0; $i<60; $i+=5)
                                <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                            @endfor
                        </select>
                        <div class="timezone-box">WIB</div>
                    </div>
                    <input type="hidden" name="booking_time" id="booking_time_input" value="11:00">

                    <div style="margin-top: 30px;">
                        <h4 style="font-size: 0.85rem; color: #8C6474; margin-bottom: 15px;"><i class="fas fa-info-circle"></i> Jadwal Terisi ({{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F') }})</h4>
                        <div class="time-slots">
                            @forelse($bookedSlots as $slot)
                                <div class="time-slot-btn">
                                    <i class="fas fa-clock"></i>
                                    <div>
                                        <span>{{ \Carbon\Carbon::parse($slot->booking_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->booking_time)->addMinutes($slot->duration)->format('H:i') }} WIB</span>
                                        <span class="slot-label">Sudah Dipesan</span>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: #999; font-size: 0.8rem; background: #fafafa; border-radius: 12px; border: 1.5px dashed #eee;">
                                    Belum ada pemesanan untuk tanggal ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Card -->
            <div class="card calendar-box">
                <h3 class="time-header" style="text-align: left;">Pilih Jadwal</h3>
                <div class="cal-header">
                    <i class="fas fa-chevron-left"></i>
                    <span class="cal-month">{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('F Y') }}</span>
                    <i class="fas fa-chevron-right"></i>
                </div>
                <div class="cal-days">
                    <div class="cal-day-name">Min</div>
                    <div class="cal-day-name">Sen</div>
                    <div class="cal-day-name">Sel</div>
                    <div class="cal-day-name">Rab</div>
                    <div class="cal-day-name">Kam</div>
                    <div class="cal-day-name">Jum</div>
                    <div class="cal-day-name">Sab</div>

                    @for($i=1; $i<=31; $i++)
                        <div class="cal-date {{ $i == \Carbon\Carbon::parse($selectedDate)->day ? 'active' : '' }}" onclick="selectDate({{ $i }})">{{ $i }}</div>
                    @endfor
                </div>
            </div>
        </div>

        <div class="booking-footer">
            <div class="total-box">
                Total: <span id="total-display">Rp {{ number_format($selectedPackage->price, 0, ',', '.') }}</span>
            </div>
            <button type="submit" class="btn-submit">Submit</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const basePrice = {{ $selectedPackage->price }};
    
    function updateTotal() {
        let total = basePrice;
        if (document.querySelector('input[name="extra_persons"]').checked) total += 15000;
        if (document.querySelector('input[name="extra_time"]').checked) total += 15000;
        
        document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function selectDate(day) {
        const month = "{{ \Carbon\Carbon::parse($selectedDate)->format('Y-m') }}";
        const newDate = month + '-' + String(day).padStart(2, '0');
        window.location.href = "{{ route('booking.create') }}?package={{ $selectedPackage->name }}&date=" + newDate;
    }

    function updateTimeInput() {
        const h = document.getElementById('hour_select').value;
        const m = document.getElementById('minute_select').value;
        document.getElementById('booking_time_input').value = h + ':' + m;
    }

    @if(session('time_error'))
        Swal.fire({
            title: 'Waktu tidak tersedia!',
            text: "{{ session('time_error') }}",
            icon: 'error',
            confirmButtonColor: '#7B3E3E',
            background: '#F5EDE8'
        });
    @endif

    @if(session('booking_success'))
        Swal.fire({
            title: 'Pemesanan Berhasil!',
            text: 'Booking anda telah dikonfirmasi.',
            icon: 'success',
            confirmButtonColor: '#7B3E3E',
            timer: 3000
        });
    @endif
</script>
@endpush
