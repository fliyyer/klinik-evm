<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        $search = trim((string) $request->query('q', ''));

        $transactions = Booking::query()
            ->with(['user', 'service'])
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
            ->latest()
            ->get();

        return view('admin.transactions.index', [
            'user' => $user,
            'menus' => $this->adminMenus('transaction'),
            'transactions' => $transactions,
            'searchQuery' => $search,
        ]);
    }

    private function adminMenus(string $activeKey): array
    {
        $menus = [
            'dashboard' => ['label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('dashboard')],
            'services' => ['label' => 'Kelola Layanan', 'icon' => 'services', 'href' => route('admin.services.index')],
            'booking' => ['label' => 'Kelola Booking', 'icon' => 'booking', 'href' => route('admin.bookings.index')],
            'transaction' => ['label' => 'Transaksi', 'icon' => 'transaction', 'href' => route('admin.transactions.index')],
            'report' => ['label' => 'Laporan', 'icon' => 'report', 'href' => route('admin.reports.index')],
        ];

        return collect($menus)
            ->map(fn ($menu, $key) => [...$menu, 'active' => $key === $activeKey])
            ->values()
            ->all();
    }
}
