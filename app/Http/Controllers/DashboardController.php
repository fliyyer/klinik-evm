<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';

        return view('dashboard.index', [
            'user' => $user,
            'isAdmin' => $isAdmin,
            'sidebarSubtitle' => $isAdmin ? 'Login sebagai' : 'User aktif',
            'sidebarTitle' => $isAdmin ? 'Administrator' : $user->name,
            'menus' => $isAdmin
                ? [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'active' => true],
                    ['label' => 'Kelola Layanan', 'icon' => 'services'],
                    ['label' => 'Kelola Booking', 'icon' => 'booking'],
                    ['label' => 'Transaksi', 'icon' => 'transaction'],
                    ['label' => 'Laporan', 'icon' => 'report'],
                ]
                : [
                    ['label' => 'Cari Layanan', 'icon' => 'search', 'active' => true],
                    ['label' => 'Booking', 'icon' => 'booking'],
                    ['label' => 'Riwayat', 'icon' => 'history'],
                ],
        ]);
    }
}
