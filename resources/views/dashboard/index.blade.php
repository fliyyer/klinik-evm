<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Klinik Eva Mulia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900">
    <div class="min-h-screen bg-slate-100">
        @include('dashboard.partials.sidebar', [
            'user' => $user,
            'subtitle' => $sidebarSubtitle,
            'title' => $sidebarTitle,
            'menus' => $menus,
        ])

        <main class="ml-72 h-screen overflow-y-auto px-8 pb-8 pt-28">
            @include('dashboard.partials.topbar', ['user' => $user])

            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                @if ($isAdmin)
                    <h2 class="text-3xl font-bold text-slate-900">Selamat Datang Admin</h2>
                    <p class="mt-1 text-sm text-slate-500">Halo, {{ $user->name }}. Berikut ringkasan operasional hari ini.</p>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2 2xl:grid-cols-4">
                        <div class="rounded-xl bg-indigo-600 p-4 text-white">
                            <p class="text-sm text-indigo-100">Total Customer</p>
                            <p class="mt-2 text-3xl font-bold">0</p>
                        </div>
                        <div class="rounded-xl bg-violet-600 p-4 text-white">
                            <p class="text-sm text-violet-100">Total Layanan</p>
                            <p class="mt-2 text-3xl font-bold">0</p>
                        </div>
                        <div class="rounded-xl bg-blue-600 p-4 text-white">
                            <p class="text-sm text-blue-100">Booking Hari Ini</p>
                            <p class="mt-2 text-3xl font-bold">0</p>
                        </div>
                        <div class="rounded-xl bg-slate-800 p-4 text-white">
                            <p class="text-sm text-slate-300">Total Pendapatan</p>
                            <p class="mt-2 text-3xl font-bold">Rp 0</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-slate-800">Booking Terbaru</h3>
                            <span class="text-sm text-slate-500">Belum ada data</span>
                        </div>

                        <div class="mt-3 overflow-hidden rounded-xl border border-slate-200">
                            <table class="min-w-full divide-y divide-slate-200 text-sm">
                                <thead class="bg-slate-50 text-slate-600">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-medium">Customer</th>
                                        <th class="px-4 py-3 text-left font-medium">Layanan</th>
                                        <th class="px-4 py-3 text-left font-medium">Tanggal</th>
                                        <th class="px-4 py-3 text-left font-medium">Status</th>
                                        <th class="px-4 py-3 text-left font-medium">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-slate-400">Data booking akan tampil di sini.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    @if (session('success'))
                        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="text-3xl font-bold text-slate-900">Selamat Datang User</h2>
                    <p class="mt-1 text-sm text-slate-500">Cari layanan treatment yang tersedia dan lakukan booking.</p>

                    <form method="GET" action="{{ route('dashboard') }}" class="mt-6">
                        <label for="search" class="sr-only">Cari layanan</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3 text-slate-400">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                                </svg>
                            </span>
                            <input id="search" name="q" type="text" value="{{ $searchQuery ?? '' }}" placeholder="Cari layanan treatment"
                                class="block w-full rounded-lg border-slate-300 py-2.5 ps-9 pe-3 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        </div>
                    </form>

                    <div class="mt-5 space-y-4">
                        @forelse ($services as $service)
                            <article class="rounded-xl border border-slate-200 p-4 transition hover:shadow-md">
                                <div class="flex flex-col gap-4 sm:flex-row">
                                    <div class="h-24 w-full overflow-hidden rounded-lg bg-slate-200 sm:w-32">
                                        @if ($service->image_path)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($service->image_path) }}" alt="{{ $service->name }}" class="h-full w-full object-cover" />
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold">{{ $service->name }}</h3>
                                        <p class="text-sm font-medium text-slate-600">IDR {{ number_format($service->price, 0, ',', '.') }}</p>
                                        <p class="mt-2 text-sm text-slate-500">{{ $service->description ?: '-' }}</p>
                                        <a href="{{ route('user.bookings.create', ['service_id' => $service->id]) }}" class="mt-3 inline-block rounded-md bg-violet-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-violet-700">Booking</a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center text-sm text-slate-500">
                                {{ ($searchQuery ?? '') !== '' ? 'Layanan tidak ditemukan untuk kata kunci tersebut.' : 'Layanan belum tersedia.' }}
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
