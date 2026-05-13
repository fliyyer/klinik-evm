<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';
        $search = trim((string) request('q', ''));

        $services = collect();
        if (! $isAdmin) {
            $services = Service::query()
                ->where('is_active', true)
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($inner) use ($search) {
                        $inner->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->orderBy('name')
                ->get();
        }

        return view('dashboard.index', [
            'user' => $user,
            'isAdmin' => $isAdmin,
            'searchQuery' => $search,
            'sidebarSubtitle' => $isAdmin ? 'Login sebagai' : 'User aktif',
            'sidebarTitle' => $isAdmin ? 'Administrator' : $user->name,
            'menus' => $isAdmin
                ? [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard')],
                    ['label' => 'Kelola Layanan', 'icon' => 'services', 'href' => route('admin.services.index'), 'active' => request()->routeIs('admin.services.*')],
                    ['label' => 'Kelola Booking', 'icon' => 'booking', 'href' => route('admin.bookings.index'), 'active' => request()->routeIs('admin.bookings.*')],
                    ['label' => 'Transaksi', 'icon' => 'transaction', 'href' => route('admin.transactions.index'), 'active' => request()->routeIs('admin.transactions.*')],
                    ['label' => 'Laporan', 'icon' => 'report', 'href' => route('admin.reports.index'), 'active' => request()->routeIs('admin.reports.*')],
                ]
                : [
                    ['label' => 'Cari Layanan', 'icon' => 'search', 'href' => route('dashboard'), 'active' => true],
                    ['label' => 'Booking', 'icon' => 'booking', 'href' => route('user.bookings.create'), 'active' => false],
                    ['label' => 'Riwayat', 'icon' => 'history', 'href' => route('user.bookings.index'), 'active' => false],
                ],
            'services' => $services,
        ]);
    }
}
