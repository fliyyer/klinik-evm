<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Kelola Booking - Klinik Eva Mulia</title>
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
                <h1 class="text-3xl font-bold text-slate-900">{{ $isEdit ? 'Edit Slot Booking' : 'Form Kelola Booking' }}</h1>
                <p class="mt-1 text-sm text-slate-500">Tentukan tanggal, jam, kuota, dan status ketersediaan slot booking.</p>

                @if ($errors->any())
                    <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <ul class="list-disc ps-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ $isEdit ? route('admin.bookings.update', $slot) : route('admin.bookings.store') }}" class="mt-6 space-y-5">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Booking</label>
                            <input type="date" name="booking_date" value="{{ old('booking_date', $slot->booking_date?->format('Y-m-d')) }}" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Jam Booking</label>
                            <input type="time" name="booking_time" value="{{ old('booking_time', $slot->booking_time ? \Carbon\Carbon::parse($slot->booking_time)->format('H:i') : '') }}" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Kuota Booking</label>
                            <input type="number" min="1" max="999" name="quota" value="{{ old('quota', $slot->quota) }}" placeholder="Masukkan kuota" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Status</label>
                            <select name="is_available" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500">
                                <option value="1" @selected(old('is_available', $slot->is_available ? '1' : '0') == '1')>Tersedia</option>
                                <option value="0" @selected(old('is_available', $slot->is_available ? '1' : '0') == '0')>Tidak Tersedia</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('admin.bookings.index') }}" class="rounded-lg border border-slate-300 px-5 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
                        <button type="submit" class="rounded-lg bg-violet-600 px-5 py-2 text-sm font-semibold text-white hover:bg-violet-700">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
