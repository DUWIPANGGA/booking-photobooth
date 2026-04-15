@extends('layouts.admin')

@section('page_title', 'Dashboard Overview')

@section('styles')
<style>
    /* Stats Row */
    .summary-grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
        width: 100%;
    }
    @media (min-width: 768px) {
        .summary-grid {
            gap: 24px;
        }
    }
    .summary-card {
        flex: 1;
        background: white;
        padding: 24px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.03);
        transition: 0.3s;
    }
    .summary-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(123, 45, 62, 0.08); }
    
    .icon-box {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
    }
    .icon-blue { background: rgba(52, 152, 219, 0.1); color: #3498db; }
    .icon-green { background: rgba(46, 204, 113, 0.1); color: #2ecc71; }
    .icon-purple { background: rgba(155, 89, 182, 0.1); color: #9b59b2; }
    .icon-gold { background: rgba(241, 196, 15, 0.1); color: #f1c40f; }

    .stat-info .label { font-size: 0.8rem; color: #8C6474; margin-bottom: 4px; display: block; }
    .stat-info .value { font-size: 1.4rem; font-weight: 700; color: var(--primary-dark); }

    /* Chart Layout */
    .charts-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }
    @media (min-width: 1024px) {
        .charts-grid {
            grid-template-columns: 2fr 1fr;
        }
    }
    .chart-box { min-height: 420px; }
    .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .chart-title { font-size: 1.1rem; font-weight: 700; color: var(--primary-dark); }

    /* Recent Table */
    .table-section { background: white; border-radius: 16px; padding: 20px; }
    @media (min-width: 768px) {
        .table-section { padding: 30px; }
    }
    .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
    
    .search-wrapper { position: relative; width: 100%; max-width: 300px; }
    .search-wrapper i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #ccc; }
    .search-input { 
        width: 100%; padding: 10px 15px 10px 40px; 
        border: 1.5px solid #F0F0F0; border-radius: 10px; font-size: 0.85rem;
        transition: 0.3s;
    }
    .search-input:focus { border-color: var(--primary); outline: none; }

    table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    th { text-align: left; padding: 15px 20px; font-size: 0.8rem; color: #8C6474; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    tr.booking-row { background: #FFFFFF; transition: 0.2s; }
    tr.booking-row:hover { background: #fdfdfd; transform: scale(1.002); }
    td { padding: 18px 20px; border-top: 1px solid #f9f9f9; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }
    td:first-child { border-left: 1px solid #f9f9f9; border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    td:last-child { border-right: 1px solid #f9f9f9; border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

    .user-pill { display: flex; align-items: center; gap: 10px; }
    .user-initial { width: 32px; height: 32px; border-radius: 10px; background: var(--bg-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.75rem; }

    .badge { padding: 6px 14px; border-radius: 8px; font-size: 0.75rem; font-weight: 600; }
    .badge-pending { background: #FFF9E6; color: #D4A017; }
    .badge-confirmed { background: #E6F9F1; color: #27AE60; }
    .badge-canceled { background: #FDECEA; color: #EB5757; }
    .badge-finished { background: #F4F7FB; color: #5C6BC0; }

    .date-box { font-size: 0.85rem; color: #333; font-weight: 600; }
    .time-sub { font-size: 0.75rem; color: #888; display: block; margin-top: 3px; }

    /* Pagination */
    .pagination-wrapper { margin-top: 25px; display: flex; justify-content: center; }
</style>
@endsection

@section('content')
<!-- Charts Section -->
<div class="charts-grid">
    <div class="card chart-box">
        <div class="chart-header">
            <h3 class="chart-title">Analisis Pemesanan Bulanan</h3>
            <span style="font-size: 0.75rem; color: #888;">Updated 1m ago</span>
        </div>
        <div style="height: 320px; position: relative;">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    <div class="card chart-box">
        <div class="chart-header">
            <h3 class="chart-title">Populer Paket</h3>
        </div>
        <div style="height: 320px; position: relative;">
            <canvas id="packageChart"></canvas>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="card table-section">
    <div class="table-header">
        <h3 class="chart-title">Riwayat Pemesanan Terbaru</h3>
        <div class="search-wrapper">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" placeholder="Cari nama atau paket...">
        </div>
    </div>

    <div class="table-responsive" style="overflow-x: auto;">
        <table style="min-width: 800px;">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Tanggal & Waktu</th>
                    <th>Paket Dipilih</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr class="booking-row">
                    <td>
                        <div class="user-pill">
                            <div class="user-initial">{{ substr($booking->user->name, 0, 1) }}</div>
                            <div>
                                <span style="font-weight: 600; font-size: 0.9rem; display: block;">{{ $booking->user->name }}</span>
                                <span style="font-size: 0.75rem; color: #888;">ID: #BK{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="date-box">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</div>
                        <span class="time-sub">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }} WIB</span>
                    </td>
                    <td>
                        <span style="font-weight: 600; color: var(--primary);">{{ $booking->package->name }}</span>
                        <span class="time-sub">{{ $booking->extra_persons ? '+ Extra Person' : '' }} {{ $booking->extra_time ? '+ Extra Time' : '' }}</span>
                    </td>
                    <td>
                        <span style="font-weight: 700;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $booking->status }}">
                            {{ $booking->status == 'pending' ? 'Pending' : ($booking->status == 'confirmed' ? 'Confirmed' : ucfirst($booking->status)) }}
                        </span>
                    </td>
                    <td>
                        <button style="background: none; border: none; color: #ccc; cursor: pointer; font-size: 1.1rem;"><i class="fas fa-ellipsis-v"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 60px;">
                        <i class="fas fa-folder-open" style="font-size: 3rem; color: #eee; margin-bottom: 15px; display: block;"></i>
                        <span style="color: #bbb;">Belum ada pesanan masuk hari ini.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $bookings->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Configuration common styles
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.color = "#8C6474";

    // Monthly Chart
    const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
    const gradient = ctxMonthly.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(128, 64, 77, 0.4)');
    gradient.addColorStop(1, 'rgba(128, 64, 77, 0)');

    new Chart(ctxMonthly, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyStats->pluck('month')) !!}.length ? {!! json_encode($monthlyStats->pluck('month')) !!} : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Total Bookings',
                data: {!! json_encode($monthlyStats->pluck('total')) !!}.length ? {!! json_encode($monthlyStats->pluck('total')) !!} : [15, 25, 12, 45, 30, 60],
                borderColor: '#80404D',
                borderWidth: 3,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#80404D',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { grid: { borderDash: [5, 5], color: '#f0f0f0' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        }
    });

    // Package Chart (Donut)
    const ctxPackage = document.getElementById('packageChart').getContext('2d');
    new Chart(ctxPackage, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($packageStats->pluck('name')) !!}.length ? {!! json_encode($packageStats->pluck('name')) !!} : ['Couple', 'Teater', 'Elevator'],
            datasets: [{
                data: {!! json_encode($packageStats->pluck('total')) !!}.length ? {!! json_encode($packageStats->pluck('total')) !!} : [40, 30, 30],
                backgroundColor: ['#80404D', '#C08C78', '#E8D5D0', '#3D1A24'],
                hoverOffset: 15,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            },
            cutout: '70%'
        }
    });
</script>
@endsection
