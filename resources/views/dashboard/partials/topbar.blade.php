<header class="fixed left-72 right-0 top-0 z-20 flex h-20 items-center justify-between border-b border-slate-200 bg-white px-8">
    <div>
        <p class="text-sm text-slate-500">Dashboard</p>
        <h2 class="text-lg font-semibold text-slate-900">Klinik Eva Mulia</h2>
    </div>

    <div class="relative" x-data="{ open: false }">
        <button type="button" @click="open = !open" class="flex items-center gap-3 rounded-lg border border-slate-200 px-3 py-2 hover:bg-slate-50">
            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 6.75a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.5 20.25a7.5 7.5 0 0115 0" />
                </svg>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                <p class="text-xs text-slate-500">{{ ucfirst($user->role) }}</p>
            </div>
            <svg class="h-4 w-4 text-slate-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
            </svg>
        </button>

        <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 z-20 mt-2 w-44 rounded-lg border border-slate-200 bg-white py-1 shadow-lg">
            <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-rose-600 hover:bg-rose-50">Logout</button>
            </form>
        </div>
    </div>
</header>
