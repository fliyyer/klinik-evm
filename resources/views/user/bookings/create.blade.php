<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Treatment - Klinik Eva Mulia</title>
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
                <h1 class="text-3xl font-bold text-slate-900">Form Booking Treatment</h1>
                <p class="mt-1 text-sm text-slate-500">Lengkapi data booking, lalu tunggu konfirmasi dari admin klinik.</p>

                @if ($errors->any())
                    <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <ul class="list-disc ps-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('user.bookings.store') }}" class="mt-6 space-y-5"
                    x-data="{
                        selectedDate: @js(old('booking_date', '')),
                        selectedTime: @js(old('booking_time', '')),
                        slots: @js($slots->map(fn($slot) => [
                            'date' => $slot->booking_date->format('Y-m-d'),
                            'time' => \Carbon\Carbon::parse($slot->booking_time)->format('H:i'),
                            'quota' => $slot->quota,
                        ])),
                        get times() {
                            if (!this.selectedDate) return [];
                            return this.slots.filter(s => s.date === this.selectedDate);
                        }
                    }">
                    @csrf

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Preferred Date</label>
                            <input type="date" name="booking_date" x-model="selectedDate" value="{{ old('booking_date') }}" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Time</label>
                            <select name="booking_time" x-model="selectedTime" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500">
                                <option value="">Pilih waktu tersedia</option>
                                <template x-for="timeSlot in times" :key="timeSlot.time">
                                    <option :value="timeSlot.time" x-text="`${timeSlot.time} (kuota ${timeSlot.quota})`"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">List layanan treatment</label>
                            <div class="space-y-2 rounded-lg border border-slate-200 p-3">
                                @foreach ($services as $service)
                                    <label class="flex cursor-pointer items-center gap-2 rounded-md px-2 py-1.5 hover:bg-slate-50">
                                        <input type="radio" name="service_id" value="{{ $service->id }}" @checked(old('service_id', $selectedServiceId) == $service->id) class="border-slate-300 text-violet-600 focus:ring-violet-500" />
                                        <span class="text-sm text-slate-700">{{ $service->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Catatan</label>
                            <textarea name="notes" rows="5" placeholder="Contoh: Saya ingin treatment sore hari" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('dashboard') }}" class="rounded-lg border border-slate-300 px-5 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
                        <button type="submit" class="rounded-lg bg-violet-600 px-5 py-2 text-sm font-semibold text-white hover:bg-violet-700">Simpan</button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
