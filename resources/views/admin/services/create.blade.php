<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Kelola Layanan - Klinik Eva Mulia</title>
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
                <h1 class="text-3xl font-bold text-slate-900">{{ $isEdit ? 'Edit Layanan' : 'Form Kelola Layanan' }}</h1>
                <p class="mt-1 text-sm text-slate-500">Tambahkan atau perbarui informasi layanan treatment.</p>

                @if ($errors->any())
                    <div class="mt-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <ul class="list-disc ps-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" enctype="multipart/form-data" action="{{ $isEdit ? route('admin.services.update', $service) : route('admin.services.store') }}" class="mt-6 space-y-5">
                    @csrf
                    @if ($isEdit)
                        @method('PUT')
                    @endif

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Nama Layanan</label>
                            <input type="text" name="name" value="{{ old('name', $service->name) }}" placeholder="Masukkan nama layanan" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Status</label>
                            <select name="is_active" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500">
                                <option value="1" @selected(old('is_active', $service->is_active ? '1' : '0') == '1')>Aktif</option>
                                <option value="0" @selected(old('is_active', $service->is_active ? '1' : '0') == '0')>Nonaktif</option>
                            </select>
                        </div>

                        <div x-data="{
                            rawPrice: @js((string) old('price', $service->price)),
                            formattedPrice: '',
                            syncPrice() {
                                this.rawPrice = String(this.rawPrice ?? '').replace(/\D/g, '');
                                this.formattedPrice = this.rawPrice
                                    ? 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(this.rawPrice))
                                    : '';
                            }
                        }" x-init="syncPrice()">
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Harga</label>
                            <input type="text"
                                inputmode="numeric"
                                :value="formattedPrice"
                                @input="rawPrice = $event.target.value; syncPrice(); $event.target.value = formattedPrice"
                                placeholder="Masukkan nominal harga"
                                class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500" />
                            <input type="hidden" name="price" :value="rawPrice" />
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">Gambar</label>
                            <input type="file" name="image" class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-violet-50 file:px-3 file:py-2 file:text-violet-700" />
                            @if ($isEdit && $service->image_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($service->image_path) }}" alt="{{ $service->name }}" class="mt-2 h-20 w-32 rounded-md object-cover ring-1 ring-slate-200" />
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-slate-700">Deskripsi</label>
                        <textarea name="description" rows="6" placeholder="Masukkan deskripsi layanan" class="block w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-violet-500 focus:ring-violet-500">{{ old('description', $service->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <a href="{{ route('admin.services.index') }}" class="rounded-lg border border-slate-300 px-5 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Kembali</a>
                        <button type="submit" class="rounded-lg bg-violet-600 px-5 py-2 text-sm font-semibold text-white hover:bg-violet-700">
                            {{ $isEdit ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </section>
        </main>
    </div>
</body>
</html>
