<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'package', 'background']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('id', 'like', '%' . $request->search . '%');
        }

        $bookings = $query->latest()->paginate(10);
        return view('admin.booking.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,canceled,finished',
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status booking #' . $booking->id . ' berhasil diperbarui.');
    }

    public function reschedule(Request $request, Booking $booking)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
        ]);

        $booking->update([
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
        ]);

        return back()->with('success', 'Jadwal booking #' . $booking->id . ' berhasil diubah.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking berhasil dihapus.');
    }
}
