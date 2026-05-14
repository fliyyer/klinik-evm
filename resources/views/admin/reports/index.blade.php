<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan - Klinik Eva Mulia</title>
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
                <div class="flex items-center gap-2">
                    <svg class="h-8 w-8 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6.75 3.75h7.5l3 3v13.5H6.75zM9 12h6M9 15h6M9 18h4.5" />
                    </svg>
                    <h1 class="text-3xl font-bold text-slate-900">Laporan</h1>
                </div>

                <h2 class="mt-5 text-2xl font-semibold text-slate-800">Filter laporan transaksi</h2>
                <form method="GET" action="{{ route('admin.reports.preview') }}" class="mt-4 grid gap-4 rounded-xl border border-slate-200 bg-slate-50 p-4 md:grid-cols-4">
                    <div>
                        <label for="from_date" class="mb-1 block text-sm font-medium text-slate-700">Dari tanggal</label>
                        <input id="from_date" name="from_date" type="date" value="{{ $fromDate }}" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                    </div>
                    <div>
                        <label for="to_date" class="mb-1 block text-sm font-medium text-slate-700">Sampai tanggal</label>
                        <input id="to_date" name="to_date" type="date" value="{{ $toDate }}" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="q" class="mb-1 block text-sm font-medium text-slate-700">Search</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3 text-slate-400">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" />
                                </svg>
                            </span>
                            <input id="q" name="q" type="text" value="{{ $searchQuery }}" placeholder="Nama customer / layanan / email"
                                class="block w-full rounded-lg border-slate-300 py-2 ps-9 pe-3 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        </div>
                    </div>
                    <div class="md:col-span-4 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 12h16.5M12 3.75v16.5" />
                            </svg>
                            Tampilkan data
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
