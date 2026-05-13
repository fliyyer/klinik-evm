<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return view('user.bookings.index', [
            'user' => $user,
            'menus' => $this->userMenus('history'),
            'bookings' => Booking::query()
                ->with('service')
                ->where('user_id', $user->id)
                ->latest()
                ->get(),
        ]);
    }

    public function create(Request $request): View
    {
        $user = auth()->user();

        return view('user.bookings.create', [
            'user' => $user,
            'menus' => $this->userMenus('booking'),
            'services' => Service::query()->where('is_active', true)->orderBy('name')->get(),
            'slots' => BookingSlot::query()
                ->where('is_available', true)
                ->where('quota', '>', 0)
                ->whereDate('booking_date', '>=', now()->toDateString())
                ->orderBy('booking_date')
                ->orderBy('booking_time')
                ->get(),
            'selectedServiceId' => (int) $request->query('service_id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $slot = BookingSlot::query()
            ->whereDate('booking_date', $data['booking_date'])
            ->where('booking_time', $data['booking_time'].':00')
            ->where('is_available', true)
            ->where('quota', '>', 0)
            ->first();

        if (! $slot) {
            return back()
                ->withInput()
                ->withErrors(['booking_time' => 'Slot waktu tidak tersedia. Silakan pilih slot lain.']);
        }

        DB::transaction(function () use ($data, $slot, $user) {
            Booking::query()->create([
                ...$data,
                'user_id' => $user->id,
                'status' => 'pending',
            ]);

            $slot->decrement('quota');

            if ($slot->fresh()->quota <= 0) {
                $slot->update(['is_available' => false]);
            }
        });

        return redirect()->route('user.bookings.index')->with('success', 'Booking berhasil diajukan. Tim kami akan segera konfirmasi.');
    }

    public function invoice(Booking $booking): View
    {
        $user = auth()->user();
        abort_unless($booking->user_id === $user->id, 403);

        $booking->load('service');

        return view('user.bookings.invoice', [
            'user' => $user,
            'booking' => $booking,
        ]);
    }

    private function userMenus(string $active): array
    {
        $menus = [
            'search' => ['label' => 'Cari Layanan', 'icon' => 'search', 'href' => route('dashboard')],
            'booking' => ['label' => 'Booking', 'icon' => 'booking', 'href' => route('user.bookings.create')],
            'history' => ['label' => 'Riwayat', 'icon' => 'history', 'href' => route('user.bookings.index')],
        ];

        return collect($menus)
            ->map(fn ($menu, $key) => [...$menu, 'active' => $key === $active])
            ->values()
            ->all();
    }
}
