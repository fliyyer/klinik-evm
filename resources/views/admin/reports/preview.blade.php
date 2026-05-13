<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview Laporan - Klinik Eva Mulia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            body { background: #fff !important; }
            .no-print { display: none !important; }
            .print-sheet { box-shadow: none !important; border: 0 !important; max-width: 100% !important; }
            .print-sheet table { font-size: 11px !important; }
        }
    </style>
</head>
<body class="bg-slate-100 py-8 text-slate-900">
    <div class="mx-auto w-full max-w-6xl px-4">
        <div class="no-print mb-4 flex items-center justify-between">
            <a href="{{ route('admin.reports.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali ke Filter</a>
            <button type="button" onclick="window.print()" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">Print Laporan</button>
        </div>

        <div class="print-sheet rounded-lg border border-slate-200 bg-white p-6 shadow">
            <div class="border-b border-slate-300 pb-4">
                <div class="flex items-center justify-center gap-4">
                    <img src="{{ asset('logo.png') }}" alt="Logo Klinik Eva Mulia" class="h-12 w-auto" />
                    <div class="text-center">
                        <h1 class="text-3xl font-semibold leading-none">LAPORAN</h1>
                        <p class="text-sm text-slate-600">Klinik Eva Mulia</p>
                    </div>
                </div>
                <p class="mt-3 text-center text-sm text-slate-600">Periode {{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }}</p>
            </div>

            <h2 class="mt-6 text-xl font-semibold text-slate-800">Data Transaksi</h2>
            <div class="mt-3 overflow-hidden rounded-xl border border-slate-200">
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($transactions as $trx)
                            @php
                                $statusMap = [
                                    'pending' => ['dipesan', 'bg-amber-50 text-amber-700 ring-amber-200'],
                                    'confirmed' => ['confirmed', 'bg-blue-50 text-blue-700 ring-blue-200'],
                                    'completed' => ['selesai', 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
                                    'cancelled' => ['cancel', 'bg-rose-50 text-rose-700 ring-rose-200'],
                                ];
                                [$label, $style] = $statusMap[$trx->status] ?? ['unknown', 'bg-slate-100 text-slate-600 ring-slate-200'];
                            @endphp
                            <tr>
                                <td class="px-4 py-3">{{ $trx->user->name }}</td>
                                <td class="px-4 py-3">-</td>
                                <td class="px-4 py-3">{{ $trx->user->email }}</td>
                                <td class="px-4 py-3">{{ $trx->service->name }}</td>
                                <td class="px-4 py-3">{{ $trx->booking_date->format('d/m/y') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($trx->booking_time)->format('H:i') }}</td>
                                <td class="px-4 py-3">{{ number_format($trx->service->price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ring-1 {{ $style }}">{{ $label }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-slate-500">Tidak ada transaksi pada filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
