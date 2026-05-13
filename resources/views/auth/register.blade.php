<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center bg-slate-200 px-6 py-10">
        <div class="w-full max-w-md rounded-xl bg-white px-8 py-8 shadow">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-neutral-500 text-2xl font-semibold text-white">
                em
            </div>
            <h1 class="mt-4 text-center text-4xl font-bold text-slate-900">Daftar Akun Baru</h1>
            <p class="mt-2 text-center text-sm text-slate-700">Buat akun untuk booking treatment</p>

            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4 rounded-lg border border-slate-200 p-5">
                @csrf

                <div>
                    <label for="name" class="mb-1 block text-sm text-slate-700">Nama lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        class="block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                </div>

                <div>
                    <label for="username" class="mb-1 block text-sm text-slate-700">Username</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username"
                        class="block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                    <x-input-error :messages="$errors->get('username')" class="mt-1.5" />
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="block w-full rounded-md border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                <div x-data="{ show: false }">
                    <label for="password" class="mb-1 block text-sm text-slate-700">Password</label>
                    <div class="relative">
                        <input id="password" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password"
                            class="block w-full rounded-md border-slate-300 pr-10 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        <button type="button" x-on:click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                <circle cx="12" cy="12" r="3" stroke-width="1.8" />
                            </svg>
                            <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.58 10.58a2 2 0 102.83 2.83" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.88 5.09A10.94 10.94 0 0112 4.5c6 0 9.75 7.5 9.75 7.5a18.6 18.6 0 01-3.18 4.13M6.61 6.61C4.12 8.27 2.75 12 2.75 12s3.75 7.5 9.75 7.5a10.7 10.7 0 005.02-1.2" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>

                <div x-data="{ showConfirm: false }">
                    <label for="password_confirmation" class="mb-1 block text-sm text-slate-700">Konfirmasi Password</label>
                    <div class="relative">
                        <input id="password_confirmation" x-bind:type="showConfirm ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                            class="block w-full rounded-md border-slate-300 pr-10 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        <button type="button" x-on:click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-700">
                            <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12s-3.75 7.5-9.75 7.5S2.25 12 2.25 12z" />
                                <circle cx="12" cy="12" r="3" stroke-width="1.8" />
                            </svg>
                            <svg x-show="showConfirm" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.58 10.58a2 2 0 102.83 2.83" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.88 5.09A10.94 10.94 0 0112 4.5c6 0 9.75 7.5 9.75 7.5a18.6 18.6 0 01-3.18 4.13M6.61 6.61C4.12 8.27 2.75 12 2.75 12s3.75 7.5 9.75 7.5a10.7 10.7 0 005.02-1.2" />
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
                </div>

                <button type="submit" class="w-full rounded-md bg-violet-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-violet-700">
                    Daftar sekarang
                </button>

                <p class="text-center text-sm text-slate-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:underline">Login di sini</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
