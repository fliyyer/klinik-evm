<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Booking - Klinik Eva Mulia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900">
    <div class="min-h-screen flex">
        @include('dashboard.partials.sidebar', [
            'user' => $user,
            'subtitle' => 'Login sebagai',
            'title' => 'Administrator',
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

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900">Kelola Booking</h1>
                        <p class="mt-1 text-sm text-slate-500">Kelola slot booking agar user hanya memilih jadwal yang tersedia.</p>
                    </div>

                    <a href="{{ route('admin.bookings.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" /></svg>
                        Tambah Slot Booking
                    </a>
                </div>

                <div class="mt-6 overflow-hidden rounded-xl border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium">No</th>
                                <th class="px-4 py-3 text-left font-medium">Hari</th>
                                <th class="px-4 py-3 text-left font-medium">Tgl Booking</th>
                                <th class="px-4 py-3 text-left font-medium">Jam Booking</th>
                                <th class="px-4 py-3 text-left font-medium">Kuota</th>
                                <th class="px-4 py-3 text-left font-medium">Status</th>
                                <th class="px-4 py-3 text-left font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($slots as $slot)
                                @php
                                    $dayMap = [
                                        'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis',
                                        'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu',
                                    ];
                                    $dayName = $dayMap[$slot->booking_date->format('l')] ?? $slot->booking_date->format('l');
                                @endphp
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $dayName }}</td>
                                    <td class="px-4 py-3">{{ $slot->booking_date->format('d M Y') }}</td>
                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($slot->booking_time)->format('H:i') }}</td>
                                    <td class="px-4 py-3">{{ $slot->quota }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $slot->is_available ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' }}">
                                            {{ $slot->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.bookings.edit', $slot) }}" class="inline-flex items-center rounded-md border border-indigo-200 px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-50">Edit</a>
                                            <form method="POST" action="{{ route('admin.bookings.destroy', $slot) }}" onsubmit="return confirm('Hapus slot ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center rounded-md border border-rose-200 px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-slate-500">Belum ada slot booking.</td>
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
