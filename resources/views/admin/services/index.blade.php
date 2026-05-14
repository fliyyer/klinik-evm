<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Layanan - Klinik Eva Mulia</title>
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
                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900">Kelola Layanan</h1>
                        <p class="mt-1 text-sm text-slate-500">Atur daftar layanan treatment yang tersedia untuk customer.</p>
                    </div>

                    <a href="{{ route('admin.services.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" /></svg>
                        Tambah Layanan
                    </a>
                </div>

                <div class="mt-6 space-y-4">
                    @forelse ($services as $service)
                        <article class="rounded-xl border border-slate-200 p-4 transition hover:shadow-md">
                            <div class="flex flex-col gap-4 sm:flex-row">
                                <div class="h-24 w-full overflow-hidden rounded-lg bg-gradient-to-br from-slate-100 to-slate-200 sm:w-36">
                                    @if ($service->image_path)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($service->image_path) }}" alt="{{ $service->name }}" class="h-full w-full object-cover" />
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <div class="flex flex-wrap items-start justify-between gap-3">
                                        <div>
                                            <h3 class="text-xl font-semibold text-slate-900">{{ $service->name }}</h3>
                                            <p class="text-sm font-medium text-slate-600">IDR {{ number_format($service->price, 0, ',', '.') }}</p>
                                        </div>

                                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium {{ $service->is_active ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' }}">
                                            {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>

                                    <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $service->description ?: '-' }}</p>

                                    <div class="mt-4 flex items-center gap-2">
                                        <form method="POST" action="{{ route('admin.services.toggle', $service) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="group inline-flex items-center gap-2 rounded-full border px-2 py-1 text-xs font-semibold transition {{ $service->is_active ? 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' : 'border-slate-300 bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                                <span class="relative h-5 w-9 rounded-full transition {{ $service->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}">
                                                    <span class="absolute top-0.5 h-4 w-4 rounded-full bg-white shadow transition {{ $service->is_active ? 'left-4' : 'left-0.5' }}"></span>
                                                </span>
                                                {{ $service->is_active ? 'ON' : 'OFF' }}
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.services.edit', $service) }}" class="inline-flex items-center gap-1 rounded-md border border-indigo-200 px-3 py-1.5 text-xs font-medium text-indigo-700 hover:bg-indigo-50">
                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.862 4.487a2.1 2.1 0 112.97 2.97L8.25 19.04 4.5 19.5l.46-3.75z" /></svg>
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Hapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-md border border-rose-200 px-3 py-1.5 text-xs font-medium text-rose-600 hover:bg-rose-50">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6.75 7.5h10.5M9.75 7.5V6a2.25 2.25 0 012.25-2.25h0A2.25 2.25 0 0114.25 6v1.5m-6.75 0l.6 10.2a2.25 2.25 0 002.25 2.1h3.3a2.25 2.25 0 002.25-2.1l.6-10.2" /></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-10 text-center text-sm text-slate-500">
                            Belum ada layanan. Klik <strong>Tambah Layanan</strong> untuk membuat data baru.
                        </div>
                    @endforelse
                </div>
            </section>
        </main>
    </div>
</body>
</html>
