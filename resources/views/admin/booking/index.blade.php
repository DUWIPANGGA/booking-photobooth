@extends('layouts.admin')

@section('page_title', 'Manajemen Booking')

@section('styles')
<style>
    .badge { padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; }
    .status-pending { background: #FFF9E6; color: #D4A017; }
    .status-confirmed { background: #E6F9F1; color: #27AE60; }
    .status-canceled { background: #FDECEA; color: #EB5757; }
    .status-finished { background: #F4F7FB; color: #5C6BC0; }

    .table-container { background: white; border-radius: 16px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
    .search-filter-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }

    .btn-action { width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: 1px solid #eee; background: white; color: #666; cursor: pointer; transition: 0.2s; }
    .btn-action:hover { background: #f5f5f5; border-color: var(--primary); color: var(--primary); }

    /* Modal Styling */
    .modal-backdrop { fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: none; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .modal-card { background: white; width: 100%; max-width: 500px; border-radius: 16px; overflow: hidden; animation: slideUp 0.3s ease; }
    @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-header { background: var(--primary); color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
    .modal-body { padding: 25px; }
</style>
@endsection

@section('content')
<div class="table-container">
    <form action="{{ route('admin.booking.index') }}" method="GET" class="search-filter-row">
        <div style="display: flex; gap: 10px; flex: 1;">
            <div style="position: relative; flex: 1; max-width: 300px;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 12px; color: #ccc;"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" style="padding-left: 45px; border-radius: 10px;" placeholder="Cari nama atau ID...">
            </div>
            <select name="status" class="form-control" style="width: 150px; border-radius: 10px;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
            </select>
        </div>
        <button type="submit" class="btn-save-modal" style="padding: 10px 20px;">Filter</button>
    </form>

    <div class="table-responsive" style="overflow-x: auto;">
        <table style="width: 100%; min-width: 1000px; border-collapse: separate; border-spacing: 0 10px;">
            <thead>
                <tr style="text-align: left; color: #8C6474; font-size: 0.85rem; text-transform: uppercase;">
                    <th style="padding: 10px 20px;">ID & Customer</th>
                    <th style="padding: 10px 20px;">Paket & Latar</th>
                    <th style="padding: 10px 20px;">Jadwal</th>
                    <th style="padding: 10px 20px;">Total</th>
                    <th style="padding: 10px 20px;">Status</th>
                    <th style="padding: 10px 20px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr style="background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                    <td style="padding: 15px 20px; border-radius: 12px 0 0 12px; border: 1px solid #f9f9f9; border-right: none;">
                        <span style="font-weight: 700; color: #333; display: block;">#BK{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <span style="font-size: 0.9rem; color: #666;">{{ $booking->user->name }}</span>
                    </td>
                    <td style="padding: 15px 20px; border-top: 1px solid #f9f9f9; border-bottom: 1px solid #f9f9f9;">
                        <span style="font-weight: 600; color: var(--primary); display: block;">{{ $booking->package->name }}</span>
                        <span style="font-size: 0.75rem; color: #888;">Bg: {{ $booking->background->name ?? 'Default' }}</span>
                    </td>
                    <td style="padding: 15px 20px; border-top: 1px solid #f9f9f9; border-bottom: 1px solid #f9f9f9;">
                        <span style="font-weight: 600; color: #333; display: block;">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
                        <span style="font-size: 0.8rem; color: #888;">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }} WIB</span>
                    </td>
                    <td style="padding: 15px 20px; border-top: 1px solid #f9f9f9; border-bottom: 1px solid #f9f9f9;">
                        <span style="font-weight: 700; color: #333;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </td>
                    <td style="padding: 15px 20px; border-top: 1px solid #f9f9f9; border-bottom: 1px solid #f9f9f9;">
                        <span class="badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                    </td>
                    <td style="padding: 15px 20px; border-radius: 0 12px 12px 0; border: 1px solid #f9f9f9; border-left: none;">
                        <div style="display: flex; gap: 8px;">
                            <button title="Ubah Status" class="btn-action" onclick="openStatusModal({{ $booking->id }}, '{{ $booking->status }}')">
                                <i class="fas fa-check-circle"></i>
                            </button>
                            <button title="Ubah Jadwal" class="btn-action" onclick="openRescheduleModal({{ $booking->id }}, '{{ $booking->booking_date }}', '{{ $booking->booking_time }}')">
                                <i class="fas fa-calendar-edit"></i>
                            </button>
                            <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Hapus booking ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus" class="btn-action" style="color: #EB5757;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 50px; color: #999;">
                        Belum ada data booking.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal-backdrop" id="statusModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.2rem; margin: 0;">Update Status Booking</h3>
            <button onclick="closeModal('statusModal')" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.5rem;">&times;</button>
        </div>
        <form id="statusForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label style="font-weight: 700; color: var(--primary-dark); margin-bottom: 10px; display: block;">Pilih Status Baru</label>
                    <select name="status" id="statusSelect" class="form-control" style="border-radius: 10px;">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed (Paid)</option>
                        <option value="finished">Finished</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
                <button type="submit" class="btn-save-modal" style="width: 100%; margin-top: 20px; padding: 12px;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Reschedule -->
<div class="modal-backdrop" id="rescheduleModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.2rem; margin: 0;">Ubah Jadwal Booking</h3>
            <button onclick="closeModal('rescheduleModal')" style="background: none; border: none; color: white; cursor: pointer; font-size: 1.5rem;">&times;</button>
        </div>
        <form id="rescheduleForm" method="POST">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="font-weight: 700; color: var(--primary-dark); margin-bottom: 10px; display: block;">Tanggal Baru</label>
                    <input type="date" name="booking_date" id="newDate" class="form-control" style="border-radius: 10px;" required>
                </div>
                <div class="form-group">
                    <label style="font-weight: 700; color: var(--primary-dark); margin-bottom: 10px; display: block;">Waktu Baru</label>
                    <input type="time" name="booking_time" id="newTime" class="form-control" style="border-radius: 10px;" required>
                </div>
                <button type="submit" class="btn-save-modal" style="width: 100%; margin-top: 20px; padding: 12px;">Update Jadwal</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openStatusModal(id, currentStatus) {
        document.getElementById('statusForm').action = `/admin/booking/${id}/status`;
        document.getElementById('statusSelect').value = currentStatus;
        document.getElementById('statusModal').style.display = 'flex';
    }

    function openRescheduleModal(id, currentDate, currentTime) {
        document.getElementById('rescheduleForm').action = `/admin/booking/${id}/reschedule`;
        document.getElementById('newDate').value = currentDate;
        document.getElementById('newTime').value = currentTime.substring(0, 5);
        document.getElementById('rescheduleModal').style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal-backdrop') {
            event.target.style.display = 'none';
        }
    }
</script>
@endsection
