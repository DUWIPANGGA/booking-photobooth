<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     */
    public function dashboard()
    {
        // Stats for cards
        $bookings = Booking::with(['user', 'package'])->latest()->paginate(10);
        
        // Monthly bookings chart data (Last 12 months)
        $monthlyStats = Booking::select(
            DB::raw('count(id) as total'),
            DB::raw("TO_CHAR(booking_date, 'Mon') as month"),
            DB::raw("EXTRACT(MONTH FROM booking_date) as month_num")
        )
        ->groupBy('month', 'month_num')
        ->orderBy('month_num')
        ->get();

        // Best seller packages (Pie chart)
        $packageStats = Booking::select('packages.name', DB::raw('count(bookings.id) as total'))
            ->join('packages', 'packages.id', '=', 'bookings.package_id')
            ->groupBy('packages.name')
            ->get();

        return view('admin.dashboard', compact('bookings', 'monthlyStats', 'packageStats'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
