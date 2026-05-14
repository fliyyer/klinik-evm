<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi - Klinik Eva Mulia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900">
    <div class="min-h-screen bg-slate-100">
        @include('dashboard.partials.sidebar', [
            'user' => $user,
            'subtitle' => 'Login sebagai',
            'title' => 'Administrator',
            'menus' => $menus,
        ])

        <main class="ml-72 h-screen overflow-y-auto px-8 pb-8 pt-28">
            @include('dashboard.partials.topbar', ['user' => $user])

            <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                @if (session('status'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <h1 class="text-3xl font-bold text-slate-900">Data Transaksi</h1>

                    <form method="GET" action="{{ route('admin.transactions.index') }}" class="w-full max-w-xs">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3 text-slate-400">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                                </svg>
                            </span>
                            <input id="search" name="q" type="text" value="{{ $searchQuery }}" placeholder="Search"
                                class="block w-full rounded-lg border-slate-300 py-2 ps-9 pe-3 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        </div>
                    </form>
                </div>

                <div class="mt-6 overflow-hidden rounded-xl border border-slate-200">
                    <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-medium">Nama</th>
                                <th class="px-4 py-3 text-left font-medium">No.telp</th>
                                <th class="px-4 py-3 text-left font-medium">E-mail</th>
                                <th class="px-4 py-3 text-left font-medium">Jenis layanan</th>
                                <th class="px-4 py-3 text-left font-medium">Tgl.booking</th>
                                <th class="px-4 py-3 text-left font-medium">Jam booking</th>
                                <th class="px-4 py-3 text-left font-medium">Harga</th>
                                <th class="px-4 py-3 text-left font-medium">Status</th>
                                <th class="px-4 py-3 text-left font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($transactions as $trx)
                                @php
                                    $statusMap = [
                                        'pending' => ['Dipesan', 'bg-amber-50 text-amber-700 ring-amber-200'],
                                        'confirmed' => ['Dikonfirmasi', 'bg-blue-50 text-blue-700 ring-blue-200'],
                                        'completed' => ['Selesai', 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
                                        'cancelled' => ['Cancel', 'bg-rose-50 text-rose-700 ring-rose-200'],
                                    ];
                                    [$label, $style] = $statusMap[$trx->status] ?? ['Unknown', 'bg-slate-100 text-slate-600 ring-slate-200'];
                                @endphp
                                <tr>
                                    <td class="px-4 py-3">{{ $trx->user->name }}</td>
                                    <td class="px-4 py-3">-</td>
                                    <td class="px-4 py-3">{{ $trx->user->email }}</td>
                                    <td class="px-4 py-3">{{ $trx->service->name }}</td>
                                    <td class="px-4 py-3">{{ $trx->booking_date->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($trx->booking_time)->format('H:i') }}</td>
                                    <td class="px-4 py-3">{{ number_format($trx->service->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 {{ $style }}">{{ $label }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <form method="POST" action="{{ route('admin.transactions.status', $trx) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="q" value="{{ $searchQuery }}">
                                            <select name="status" class="rounded-lg border-slate-300 py-1.5 text-xs focus:border-violet-500 focus:ring-violet-500">
                                                <option value="pending" @selected($trx->status === 'pending')>Dipesan</option>
                                                <option value="confirmed" @selected($trx->status === 'confirmed')>Dikonfirmasi</option>
                                                <option value="completed" @selected($trx->status === 'completed')>Selesai</option>
                                                <option value="cancelled" @selected($trx->status === 'cancelled')>Cancel</option>
                                            </select>
                                            <button type="submit" class="rounded-lg bg-violet-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-violet-700">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-10 text-center text-slate-500">Belum ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
