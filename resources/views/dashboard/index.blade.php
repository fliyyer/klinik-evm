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
    <div class="min-h-screen flex">
        @include('dashboard.partials.sidebar', [
            'user' => $user,
            'subtitle' => $sidebarSubtitle,
            'title' => $sidebarTitle,
            'menus' => $menus,
        ])

        <main class="flex-1 p-8">
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
                    <h2 class="text-3xl font-bold text-slate-900">Selamat Datang User</h2>
                    <p class="mt-1 text-sm text-slate-500">Cari layanan treatment yang tersedia dan lakukan booking.</p>

                    <div class="mt-6">
                        <label for="search" class="sr-only">Cari layanan</label>
                        <input id="search" type="text" placeholder="Cari layanan treatment"
                            class="block w-full rounded-lg border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                    </div>

                    <div class="mt-5 space-y-4">
                        <article class="rounded-xl border border-slate-200 p-4 transition hover:shadow-md">
                            <div class="flex flex-col gap-4 sm:flex-row">
                                <div class="h-24 w-full rounded-lg bg-slate-200 sm:w-32"></div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold">Acne Treatment with Jet Oxy</h3>
                                    <p class="text-sm font-medium text-slate-600">IDR 210.000</p>
                                    <p class="mt-2 text-sm text-slate-500">Perawatan acne untuk membantu kulit tampak lebih bersih dan segar dengan proses treatment ringan.</p>
                                    <button class="mt-3 rounded-md bg-violet-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-violet-700">Booking</button>
                                </div>
                            </div>
                        </article>

                        <article class="rounded-xl border border-slate-200 p-4 transition hover:shadow-md">
                            <div class="flex flex-col gap-4 sm:flex-row">
                                <div class="h-24 w-full rounded-lg bg-slate-200 sm:w-32"></div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold">Acne Treatment with Jet Ozone</h3>
                                    <p class="text-sm font-medium text-slate-600">IDR 230.000</p>
                                    <p class="mt-2 text-sm text-slate-500">Perawatan menggunakan teknologi jet ozone yang membantu menenangkan kulit berjerawat dan meredakan kemerahan.</p>
                                    <button class="mt-3 rounded-md bg-violet-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-violet-700">Booking</button>
                                </div>
                            </div>
                        </article>

                        <article class="rounded-xl border border-slate-200 p-4 transition hover:shadow-md">
                            <div class="flex flex-col gap-4 sm:flex-row">
                                <div class="h-24 w-full rounded-lg bg-slate-200 sm:w-32"></div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold">Advance Acne Treatment with IPL</h3>
                                    <p class="text-sm font-medium text-slate-600">IDR 450.000</p>
                                    <p class="mt-2 text-sm text-slate-500">Perawatan intensif menggunakan energi IPL untuk membantu mengurangi bekas jerawat dan menyeimbangkan kondisi kulit.</p>
                                    <button class="mt-3 rounded-md bg-violet-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-violet-700">Booking</button>
                                </div>
                            </div>
                        </article>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
