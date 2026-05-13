<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Klinik Eva Mulia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-200">
    <div class="flex min-h-screen items-center justify-center px-6">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow">
            <h1 class="text-center text-2xl font-bold text-slate-900">Berhasil Login</h1>
            <p class="mt-3 text-center text-sm text-slate-600">{{ auth()->user()->name }} ({{ auth()->user()->role }})</p>

            <form method="POST" action="{{ route('logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="w-full rounded-md bg-violet-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-violet-700">
                    Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
