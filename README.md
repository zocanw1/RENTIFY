# TEAMS / WePinjam

Website peminjaman alat berbasis Laravel untuk siswa, admin, ketua jurusan, dan wali kelas.

## Isi Repo

- Source website hasil ekstrak sudah ada langsung di repo ini
- Dump database asli ada di `dbd_peminjaman_alat.sql`
- Seeder sekarang otomatis mengambil data `users` dan `settings` dari dump SQL
- Seeder juga menambahkan data alat, unit, peminjaman, dan activity log supaya fresh install langsung terisi

## Setup

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

## Database

Default `.env.example` sudah diarahkan ke MySQL lokal:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbd_peminjaman_alat
DB_USERNAME=root
DB_PASSWORD=
```

Kalau mau pakai data asli, cukup buat database `dbd_peminjaman_alat`, lalu jalankan:

```bash
php artisan migrate:fresh --seed
```

## Akun Default

- Admin: `admin@wepinjam.id` / `admin123`
- Ketua TJKT: `ketua.tjkt@wepinjam.id` / `ketua123`
- Ketua SIJA: `ketua.sija@wepinjam.id` / `ketua123`
- Wali Kelas: `wali.xi.tjkt.2@wepinjam.id` / `wali123`

## Verifikasi

```bash
php artisan test
```
