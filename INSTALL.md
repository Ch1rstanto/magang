# Panduan Instalasi & Setup Sistem Pengelolaan Magang

## Persyaratan

- PHP 7.4+
- MySQL 5.7+
- Apache (dari XAMPP)

## Langkah-Langkah Instalasi

### 1. Setup Database

```bash
# Buka phpMyAdmin di http://localhost/phpmyadmin
# Import file database.sql
# Atau jalankan query SQL di dalam database.sql
```

### 2. Konfigurasi Database

Edit file `config.php`:

```php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'magangpolmed';
```

### 3. Jalankan Aplikasi

Akses di browser: `http://localhost/webmagang2`

## Fitur Sistem

### Role Admin

- Dashboard dengan statistik
- Kelola pengajuan magang (approve/reject)
- Tambah/hapus lowongan magang
- Kelola data user

### Role Mahasiswa

- Dashboard dengan info pengajuan
- Buat pengajuan magang baru
- Lihat daftar lowongan terbaru
- Kelola profil

## Akun Default

**Admin:**

- Email: `admin@magang.local`
- Password: `admin123`
- Role: admin

## Struktur Database

### Tabel users

```sql
- id (PRIMARY KEY)
- nama
- email (UNIQUE)
- password (hashed)
- role (admin/mahasiswa)
- no_telepon
- alamat
```

### Tabel lowongan

```sql
- id (PRIMARY KEY)
- nama_lowongan
- deskripsi
- kuota
- periode_mulai
- periode_selesai
```

### Tabel pengajuan

```sql
- id (PRIMARY KEY)
- mahasiswa_id (FOREIGN KEY)
- lowongan_id (FOREIGN KEY)
- alasan
- tanggal_pengajuan
- status (pending/approved/rejected)
```

## Navigasi Aplikasi

### Landing Page

- URL: `/index.php`
- Menampilkan informasi sistem dan tombol login

### Login

- URL: `/login.php`
- Input: Email, Password, Role

### Admin Dashboard

- URL: `/admin/dashboard.php`
- Statistik: Total pengajuan, lowongan, mahasiswa

### Admin - Pengajuan Magang

- URL: `/admin/pengajuan.php`
- Fungsi: Approve/Reject pengajuan

### Admin - Kelola Lowongan

- URL: `/admin/lowongan.php`
- Fungsi: Tambah/Hapus lowongan

### Admin - Kelola User

- URL: `/admin/users.php`
- Fungsi: Tambah/Hapus user

### Mahasiswa Dashboard

- URL: `/mahasiswa/dashboard.php`
- Statistik pengajuan dan lowongan terbaru

### Mahasiswa - Pengajuan

- URL: `/mahasiswa/pengajuan.php`
- Fungsi: Lihat riwayat pengajuan

### Mahasiswa - Buat Pengajuan

- URL: `/mahasiswa/pengajuan_buat.php`
- Fungsi: Ajukan lowongan baru

### Mahasiswa - Profil

- URL: `/mahasiswa/profil.php`
- Fungsi: Edit data profil

## File Struktur

```
webmagang2/
├── index.php                 # Landing page
├── login.php                 # Halaman login
├── logout.php                # Logout
├── config.php                # Konfigurasi database
├── database.sql              # Script database
├── readme.md                 # Dokumentasi project
├── admin/
│   ├── dashboard.php         # Dashboard admin
│   ├── pengajuan.php         # Kelola pengajuan
│   ├── lowongan.php          # Kelola lowongan
│   └── users.php             # Kelola user
├── mahasiswa/
│   ├── dashboard.php         # Dashboard mahasiswa
│   ├── pengajuan.php         # Riwayat pengajuan
│   ├── pengajuan_buat.php    # Buat pengajuan baru
│   └── profil.php            # Edit profil
├── includes/
│   ├── db.php                # Koneksi database
│   ├── header.php            # Template header
│   └── footer.php            # Template footer
└── assets/
    └── css/
        └── bootstrap.min.css # Bootstrap 5 CSS
```

## Tips Keamanan

1. Ubah password admin default
2. Gunakan HTTPS di production
3. Validasi input user
4. Update PHP & MySQL ke versi terbaru
5. Setup proper user permissions di database

## Troubleshooting

### Koneksi Database Gagal

- Pastikan MySQL running
- Periksa konfigurasi di `config.php`
- Pastikan database `magangpolmed` sudah dibuat

### Login Tidak Berhasil

- Periksa email dan password
- Pastikan role dipilih dengan benar
- Cek tabel users sudah ada data

### Session Expired

- Hapus cookies browser
- Clear session di PHP
- Login ulang

## Kontak & Support

Hubungi admin untuk bantuan lebih lanjut.
