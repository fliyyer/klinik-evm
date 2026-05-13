<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Booking - Klinik Eva Mulia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900">
    <div class="min-h-screen flex">
        @include('dashboard.partials.sidebar', [
            'user' => $user,
            'subtitle' => 'User aktif',
            'title' => $user->name,
            'menus' => $menus,
        ])

        <main class="flex-1 p-8">
            @include('dashboard.partials.topbar', ['user' => $user])

            <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <h1 class="text-3xl font-bold text-slate-900">Riwayat Booking</h1>
                </div>

                <div class="overflow-hidden rounded-xl mt-5 border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium">No</th>
                                <th class="px-4 py-3 text-left font-medium">Jenis Layanan</th>
                                <th class="px-4 py-3 text-left font-medium">Tgl Booking</th>
                                <th class="px-4 py-3 text-left font-medium">Jam Booking</th>
                                <th class="px-4 py-3 text-left font-medium">Harga</th>
                                <th class="px-4 py-3 text-left font-medium">Status</th>
                                <th class="px-4 py-3 text-left font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}.</td>
                                    <td class="px-4 py-3">{{ $booking->service->name }}</td>
                                    <td class="px-4 py-3">{{ $booking->booking_date->format('d M Y') }}</td>
                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusMap = [
                                                'pending' => ['Dipesan', 'bg-amber-50 text-amber-700 ring-amber-200'],
                                                'confirmed' => ['Dikonfirmasi', 'bg-blue-50 text-blue-700 ring-blue-200'],
                                                'completed' => ['Selesai', 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
                                                'cancelled' => ['Cancel', 'bg-rose-50 text-rose-700 ring-rose-200'],
                                            ];
                                            [$label, $style] = $statusMap[$booking->status] ?? ['Unknown', 'bg-slate-100 text-slate-600 ring-slate-200'];
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 {{ $style }}">{{ $label }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('user.bookings.invoice', $booking) }}" class="inline-flex rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">Cetak Invoice</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-slate-500">Belum ada booking.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
