<?php

namespace App\Http\Controllers;

use App\Models\Background;
use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Show the booking form.
     */
    public function create(Request $request)
    {
        // Check if user has a pending booking
        $pendingBooking = Booking::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($pendingBooking) {
            return redirect()->route('booking.show', $pendingBooking->id)
                ->with('error', 'Anda masih memiliki pemesanan yang menunggu pembayaran. Silakan selesaikan pembayaran terlebih dahulu sebelum membuat pesanan baru.');
        }

        $packages = Package::all();
        $backgrounds = Background::all();
        
        $selectedPackageId = $request->query('package_id');
        $selectedPackageName = $request->query('package', 'Couple Vibes');
        
        $selectedPackage = null;
        if ($selectedPackageId) {
            $selectedPackage = Package::find($selectedPackageId);
        }
        
        if (!$selectedPackage) {
            $selectedPackage = Package::where('name', $selectedPackageName)->first() ?? $packages->first();
        }

        // Get booked times for today or selected date
        $selectedDate = $request->query('date', Carbon::today()->format('Y-m-d'));
        $bookedSlots = Booking::where('booking_date', $selectedDate)
            ->whereIn('status', ['pending', 'confirmed', 'finished'])
            ->get(['booking_time', 'duration']);

        return view('user.booking', compact('packages', 'backgrounds', 'selectedPackage', 'bookedSlots', 'selectedDate'));
    }

    /**
     * Store a new booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id'    => 'required|exists:packages,id',
            'background_id' => 'required|exists:backgrounds,id',
            'booking_date'  => 'required|date|after_or_equal:today',
            'booking_time'  => 'required',
            'notes'         => 'nullable|string',
            'extra_persons' => 'boolean',
            'extra_time'    => 'boolean',
        ]);

        // Check again for pending booking (security)
        if (Booking::where('user_id', Auth::id())->where('status', 'pending')->exists()) {
            return back()->with('error', 'Selesaikan pembayaran pesanan sebelumnya dulu ya!');
        }

        $package = Package::find($validated['package_id']);
        $duration = $package->duration;
        $totalPrice = $package->price;

        // Add-ons logic
        $extraPersonsCount = $request->boolean('extra_persons') ? 2 : 0;
        $extraTimeMinutes = $request->boolean('extra_time') ? 5 : 0;
        
        if ($extraPersonsCount) $totalPrice += 15000;
        if ($extraTimeMinutes) {
            $totalPrice += 15000;
            $duration += 5;
        }

        $startTime = Carbon::createFromFormat('Y-m-d H:i', $validated['booking_date'] . ' ' . $validated['booking_time']);
        $endTime = (clone $startTime)->addMinutes($duration);

        // Conflict check (Postgres compatible)
        $conflict = Booking::where('booking_date', $validated['booking_date'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereRaw("booking_time < ?", [$endTime->format('H:i:s')])
                      ->whereRaw("(booking_time + (duration * interval '1 minute')) > ?", [$startTime->format('H:i:s')]);
            })->exists();

        if ($conflict) {
            return back()->with('time_error', 'Waktu yang kamu pilih sudah di booking. Silahkan pilih waktu lain: 11.00 - 20.00');
        }

        $booking = Booking::create([
            'user_id'       => Auth::id(),
            'package_id'    => $package->id,
            'background_id' => $validated['background_id'],
            'booking_date'  => $validated['booking_date'],
            'booking_time'  => $validated['booking_time'],
            'duration'      => $duration,
            'extra_persons' => $extraPersonsCount,
            'extra_time'    => $extraTimeMinutes,
            'total_price'   => $totalPrice,
            'notes'         => $validated['notes'] ?? null,
            'status'        => 'pending',
        ]);

        return redirect()->route('booking.show', $booking->id)
            ->with('booking_success', true);
    }

    /**
     * Show booking detail.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);
        
        return view('user.booking_detail', compact('booking'));
    }

    /**
     * Show bookings index (already implemented, but can update).
     */
    public function index()
    {
        $bookings = Booking::with('package')->where('user_id', Auth::id())->latest()->get();
        return view('user.bookings_index', compact('bookings'));
    }
    /**
     * Cancel a booking.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) abort(403);
        
        // Optionally only allow cancellation if status is pending
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Pesanan yang sudah diproses tidak dapat dibatalkan.');
        }

        $booking->delete();

        return redirect()->route('home')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
