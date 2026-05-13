# Klinik Eva Mulia - Laravel

Aplikasi manajemen klinik berbasis Laravel untuk 2 peran utama:
- `admin`: kelola layanan, slot booking, transaksi, dan laporan
- `user`: cari layanan, booking treatment, lihat riwayat, cetak invoice

Stack utama:
- Laravel 13
- PHP 8.3+
- MySQL
- Tailwind CSS + Vite
- Breeze Auth (custom login pakai `username`)

## 1. Clone Project

```bash
git clone https://github.com/fliyyer/klinik-evm.git
cd klinik-evm
```

## 2. Install Dependency

```bash
composer install
npm install
```

## 3. Setup Environment (`.env`)

Copy file env:

```bash
cp .env.example .env
```

Generate app key:

```bash
php artisan key:generate
```

Ubah konfigurasi database di `.env`:

```env
APP_NAME="Klinik Eva Mulia"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=klinik-evamulia
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan MySQL lokal kamu.

## 4. Buat Database MySQL

Masuk ke MySQL lalu jalankan:

```sql
CREATE DATABASE `klinik-evamulia` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 5. Migrasi & Seeder

Jalankan migrasi + data awal:

```bash
php artisan migrate --seed
```

Jika butuh symlink storage:

```bash
php artisan storage:link
```

## 6. Jalankan Project

Terminal 1 (Laravel):

```bash
php artisan serve
```

Terminal 2 (Vite):

```bash
npm run dev
```

Buka:
- `http://127.0.0.1:8000`

## 7. Akun Default Seeder

Setelah `php artisan migrate --seed`, akun default:

- Admin
  - username: `admin`
  - password: `password`
- User
  - username: `user`
  - password: `password`

## 8. Alur Fitur Singkat

### Admin
- Dashboard
- Kelola layanan (CRUD + toggle aktif/nonaktif)
- Kelola slot booking (CRUD)
- Lihat transaksi booking
- Laporan transaksi berdasarkan rentang tanggal + halaman preview/print

### User
- Dashboard layanan + pencarian
- Buat booking treatment
- Riwayat booking
- Cetak invoice booking

## 9. Daftar Route Utama

## Auth
- `GET /login` -> `login`
- `POST /login`
- `GET /register` -> `register`
- `POST /register`
- `POST /logout` -> `logout`

## General
- `GET /` -> `home` (redirect ke dashboard, wajib login)
- `GET /dashboard` -> `dashboard`

## Admin - Services
- `GET /admin/services` -> `admin.services.index`
- `GET /admin/services/create` -> `admin.services.create`
- `POST /admin/services` -> `admin.services.store`
- `GET /admin/services/{service}/edit` -> `admin.services.edit`
- `PUT /admin/services/{service}` -> `admin.services.update`
- `PATCH /admin/services/{service}/toggle` -> `admin.services.toggle`
- `DELETE /admin/services/{service}` -> `admin.services.destroy`

## Admin - Booking Slots
- `GET /admin/bookings` -> `admin.bookings.index`
- `GET /admin/bookings/create` -> `admin.bookings.create`
- `POST /admin/bookings` -> `admin.bookings.store`
- `GET /admin/bookings/{booking}/edit` -> `admin.bookings.edit`
- `PUT /admin/bookings/{booking}` -> `admin.bookings.update`
- `DELETE /admin/bookings/{booking}` -> `admin.bookings.destroy`

## Admin - Transactions & Reports
- `GET /admin/transactions` -> `admin.transactions.index`
- `GET /admin/reports` -> `admin.reports.index`
- `GET /admin/reports/preview` -> `admin.reports.preview`

## User - Bookings
- `GET /user/bookings` -> `user.bookings.index` (riwayat)
- `GET /user/bookings/create` -> `user.bookings.create`
- `POST /user/bookings` -> `user.bookings.store`
- `GET /user/bookings/{booking}/invoice` -> `user.bookings.invoice`

## 10. Build untuk Production

```bash
npm run build
php artisan optimize
```

## 11. Troubleshooting

### `Vite manifest not found`
Jalankan:

```bash
npm install
npm run dev
```

atau untuk production:

```bash
npm run build
```

### `Table ... doesn't exist`
Jalankan migrasi:

```bash
php artisan migrate --seed
```

### Route terbaru belum terbaca

```bash
php artisan optimize:clear
```

## 12. Catatan

- Semua route bisnis di atas berada dalam middleware `auth`.
- Pembatasan role (`admin` / `user`) ditangani di controller masing-masing.
- Jika menambah fitur baru, update bagian **Daftar Route Utama** di README ini agar dokumentasi tetap sinkron.
