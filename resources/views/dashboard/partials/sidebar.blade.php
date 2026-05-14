<aside class="fixed inset-y-0 left-0 z-30 w-72 overflow-y-auto border-r border-slate-200 bg-white">
    <div class="bg-gradient-to-r from-indigo-700 to-violet-600 px-6 py-5 text-white">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo.png') }}" alt="Logo Klinik Eva Mulia" class="h-16 w-auto" />
            <div>
                <h1 class="mt-0.5 text-3xl font-bold">EvaMulia</h1>
            </div>
        </div>
    </div>

    <div class="p-6">
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 20.25a7.5 7.5 0 0115 0" />
                </svg>
            </div>
            <p class="mt-3 text-sm text-slate-500">{{ $subtitle ?? 'Login sebagai' }}</p>
            <p class="text-lg font-semibold">{{ $title }}</p>
        </div>

        <nav class="mt-6 space-y-2 text-sm">
            @foreach ($menus as $menu)
                <a href="{{ $menu['href'] ?? '#' }}"
                    class="{{ ($menu['active'] ?? false) ? 'bg-indigo-50 font-medium text-indigo-700' : 'text-slate-700 hover:bg-slate-100' }} flex items-center rounded-lg px-3 py-2">
                    <span class="mr-2.5">
                        @switch($menu['icon'] ?? 'dashboard')
                            @case('dashboard')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 12l8.25-8.25L20.25 12M5.25 10.5v8.25h13.5V10.5" /></svg>
                                @break
                            @case('services')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.75 3.75h4.5v4.5h-4.5zM4.5 9.75h4.5v4.5H4.5zM15 9.75h4.5v4.5H15zM9.75 15.75h4.5v4.5h-4.5z" /></svg>
                                @break
                            @case('booking')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7.5 3.75v3M16.5 3.75v3M4.5 8.25h15M6 20.25h12a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0018 8.25H6a1.5 1.5 0 00-1.5 1.5v9A1.5 1.5 0 006 20.25z" /></svg>
                                @break
                            @case('transaction')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M6.75 3.75v6M17.25 14.25h-10.5M17.25 18.75h-10.5" /></svg>
                                @break
                            @case('report')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6.75 3.75h7.5l3 3v13.5H6.75zM9 12h6M9 15h6M9 18h4.5" /></svg>
                                @break
                            @case('search')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" /></svg>
                                @break
                            @case('history')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 12a8.25 8.25 0 101.61-4.9M3.75 3.75v4.5h4.5M12 7.5v4.5l3 1.5" /></svg>
                                @break
                            @default
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 12l8.25-8.25L20.25 12M5.25 10.5v8.25h13.5V10.5" /></svg>
                        @endswitch
                    </span>
                    {{ $menu['label'] }}
                </a>
            @endforeach
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="mt-8">
            @csrf
            <button type="submit" class="w-full rounded-lg border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                Logout
            </button>
        </form>
    </div>
</aside>
