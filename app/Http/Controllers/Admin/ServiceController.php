<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        return view('admin.services.index', [
            'user' => $user,
            'menus' => $this->adminMenus('services'),
            'services' => Service::query()->latest()->get(),
        ]);
    }

    public function create(): View
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        return view('admin.services.create', [
            'user' => $user,
            'menus' => $this->adminMenus('services'),
            'service' => new Service(),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        Service::query()->create($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service): View
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        return view('admin.services.create', [
            'user' => $user,
            'menus' => $this->adminMenus('services'),
            'service' => $service,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($service->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }

    public function toggle(Service $service): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->role === 'admin', 403);

        $service->update([
            'is_active' => ! $service->is_active,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Status layanan berhasil diubah.');
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
