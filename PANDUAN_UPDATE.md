# 📋 Panduan Setup WePinjam

## ⚙️ Cara Install (Fresh)

```bash
# 1. Extract ZIP → buka di VSCode
# 2. Buka terminal (Ctrl + `)

composer install
composer require phpoffice/phpspreadsheet
cp .env.example .env
php artisan key:generate

# 3. Setting database di .env:
# DB_DATABASE=wepinjam
# DB_USERNAME=root
# DB_PASSWORD=

# 4. Buat database "wepinjam" di phpMyAdmin

php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

## ⏰ Atur Batas Jam Kembali

Setelah login sebagai admin, buka menu **⚙️** di navbar → atur jam batas pengembalian (default: 15:00 WIB).

Kalau siswa belum kembalikan alat setelah jam itu, otomatis muncul badge merah **"Terlambat"** di:
- Halaman Riwayat siswa (dengan countdown durasi terlambat)
- Dashboard admin (di tabel peminjaman aktif)
- Riwayat admin + PDF/Excel (ditandai merah)

## 📧 Setup Reset Password via Email

Edit file `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=isi_username
MAIL_PASSWORD=isi_password
MAIL_FROM_ADDRESS="noreply@wepinjam.id"
MAIL_FROM_NAME="WePinjam"
```

Untuk testing: pakai Mailtrap gratis di https://mailtrap.io
Untuk Gmail: host=smtp.gmail.com, port=587, encryption=tls, password=App Password

## 🔐 Akun Default (setelah seed)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@wepinjam.id | admin123 |
| Ketua TJKT | ketua.tjkt@wepinjam.id | ketua123 |
| Ketua SIJA | ketua.sija@wepinjam.id | ketua123 |
| Wali Kelas | wali.xi.sija.2@wepinjam.id | wali123 |

> Ganti semua password setelah pertama login!

## ✅ Fitur Lengkap

### Siswa
- Dashboard alat: live search + filter
- Detail unit per alat + foto
- Pinjam via detail alat atau scan QR
- Scan QR kamera langsung di browser
- Riwayat pinjam + badge TERLAMBAT otomatis jika lewat jam batas
- Modal kembalikan + komentar (wajib isi jika terlambat)
- Profil: foto, nama, email, NIS, no WA, password
- Lupa password via email

### Admin
- Dashboard: statistik, notif bell, peminjaman aktif + badge terlambat
- Konfirmasi pengembalian + balas komentar
- Kelola alat: tambah/edit/hapus + foto per unit
- Tombol per unit: Diperbaiki, Aman, Edit, Hapus
- QR Code: generate + print semua unit
- Manajemen siswa + foto profil + link ke riwayat siswa
- Riwayat semua peminjaman: filter + badge terlambat
- Riwayat per siswa: download PDF + Excel per siswa
- Laporan per alat: siapa saja pernah pinjam
- Statistik: 4 grafik + top alat + top siswa
- Export PDF laporan (filter bulan/tahun/semua)
- Export Excel laporan (dengan warna + badge terlambat)
- Log aktivitas: semua aksi admin tercatat
- ⚙️ Pengaturan: atur batas jam kembali + nama sekolah
- Dark mode

### Ketua Jurusan & Wali Kelas
- Dashboard: siswa sedang pinjam
- Data siswa + live search + filter kelas
- Foto profil tampil di tabel

### Teknis
- PWA: install di HP (Android & iOS)
- Background partikel animasi di semua halaman
- Dark mode tersimpan otomatis
- Semua halaman ada animasi masuk
