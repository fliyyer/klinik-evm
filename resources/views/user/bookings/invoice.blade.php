<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Booking</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-100 py-10">
    <div class="mx-auto w-full max-w-xl rounded bg-white p-8 shadow">
        <div class="flex items-center gap-4 border-b border-slate-300 pb-4">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-14 w-auto" />
            <div>
                <h1 class="text-4xl font-semibold leading-tight">Invoice</h1>
                <p class="text-xl text-slate-700">Klinik Eva Mulia</p>
            </div>
        </div>

        <div class="mt-4 space-y-1 text-sm text-slate-800">
            <p><span class="inline-block w-36">No Invoice</span>: EM{{ str_pad((string) $booking->id, 4, '0', STR_PAD_LEFT) }}-{{ $booking->created_at->format('dmY') }}</p>
            <p><span class="inline-block w-36">Tanggal</span>: {{ $booking->created_at->format('d M Y') }}</p>
        </div>

        <div class="mt-5 space-y-1 text-sm text-slate-800">
            <p><span class="inline-block w-36">Nama Customer</span>: {{ $booking->user->name }}</p>
            <p><span class="inline-block w-36">Jenis Layanan</span>: {{ $booking->service->name }}</p>
            <p><span class="inline-block w-36">Tanggal Booking</span>: {{ $booking->booking_date->format('d M Y') }}</p>
            <p><span class="inline-block w-36">Jam Booking</span>: {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</p>
            <p><span class="inline-block w-36">Durasi</span>: 60 Menit</p>
            <p><span class="inline-block w-36">Keluhan</span>: {{ $booking->notes ?: '-' }}</p>
            <p><span class="inline-block w-36">Total Harga</span>: Rp {{ number_format($booking->service->price, 0, ',', '.') }}</p>
            <p><span class="inline-block w-36">Status Pembayaran</span>: Lunas</p>
        </div>

        <div class="mt-8 flex gap-2">
            <a href="{{ route('user.bookings.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
            <button onclick="window.print()" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">Print</button>
        </div>
    </div>
</body>
</html>
