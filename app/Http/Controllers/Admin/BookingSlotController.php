<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingSlotController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        return view('admin.bookings.index', [
            'user' => $user,
            'menus' => $this->adminMenus('booking'),
            'slots' => BookingSlot::query()->orderBy('booking_date')->orderBy('booking_time')->get(),
        ]);
    }

    public function create(): View
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        return view('admin.bookings.create', [
            'user' => $user,
            'menus' => $this->adminMenus('booking'),
            'slot' => new BookingSlot(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        $data = $request->validate([
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'quota' => ['required', 'integer', 'min:1', 'max:999'],
            'is_available' => ['required', 'boolean'],
        ]);

        BookingSlot::query()->create($data);

        return redirect()->route('admin.bookings.index')->with('success', 'Slot booking berhasil ditambahkan.');
    }

    public function edit(BookingSlot $booking): View
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        return view('admin.bookings.create', [
            'user' => $user,
            'menus' => $this->adminMenus('booking'),
            'slot' => $booking,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, BookingSlot $booking): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        $data = $request->validate([
            'booking_date' => ['required', 'date'],
            'booking_time' => ['required', 'date_format:H:i'],
            'quota' => ['required', 'integer', 'min:1', 'max:999'],
            'is_available' => ['required', 'boolean'],
        ]);

        $booking->update($data);

        return redirect()->route('admin.bookings.index')->with('success', 'Slot booking berhasil diperbarui.');
    }

    public function destroy(BookingSlot $booking): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Slot booking berhasil dihapus.');
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
