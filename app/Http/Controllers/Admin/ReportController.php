<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        $menus = [
            ['label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('dashboard'), 'active' => false],
            ['label' => 'Kelola Layanan', 'icon' => 'services', 'href' => route('admin.services.index'), 'active' => false],
            ['label' => 'Kelola Booking', 'icon' => 'booking', 'href' => route('admin.bookings.index'), 'active' => false],
            ['label' => 'Transaksi', 'icon' => 'transaction', 'href' => route('admin.transactions.index'), 'active' => false],
            ['label' => 'Laporan', 'icon' => 'report', 'href' => route('admin.reports.index'), 'active' => true],
        ];

        return view('admin.reports.index', [
            'user' => $user,
            'menus' => $menus,
            'fromDate' => now()->startOfMonth()->toDateString(),
            'toDate' => now()->toDateString(),
            'searchQuery' => '',
        ]);
    }

    public function preview(Request $request): View
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        $fromDate = (string) $request->query('from_date', now()->startOfMonth()->toDateString());
        $toDate = (string) $request->query('to_date', now()->toDateString());
        $search = trim((string) $request->query('q', ''));

        $transactions = Booking::query()
            ->with(['user', 'service'])
            ->whereBetween('booking_date', [$fromDate, $toDate])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })->orWhereHas('service', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->get();

        return view('admin.reports.preview', [
            'user' => $user,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'searchQuery' => $search,
            'transactions' => $transactions,
        ]);
    }
}
