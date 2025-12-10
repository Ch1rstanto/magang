# Sistem Pengelolaan Magang Mahasiswa

Sistem web untuk mengelola pengajuan magang berbasis web untuk mahasiswa. Sistem ini memungkinkan admin dan mahasiswa untuk mengelola pengajuan magang secara online dengan mudah dan efisien.

## 🎯 Fitur Utama

### Untuk Admin

- ✅ Dashboard dengan statistik (total pengajuan, lowongan, mahasiswa)
- ✅ Kelola pengajuan magang (approve/reject)
- ✅ Tambah dan hapus lowongan magang
- ✅ Kelola data user (tambah/hapus)
- ✅ Filter dan cari pengajuan

### Untuk Mahasiswa

- ✅ Dashboard dengan info pengajuan
- ✅ Buat pengajuan magang baru
- ✅ Lihat riwayat pengajuan
- ✅ Cek status pengajuan (pending/approved/rejected)
- ✅ Kelola profil (nama, email, telepon, alamat)
- ✅ Lihat lowongan magang terbaru

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi                |
| -------- | ------------------------ |
| Backend  | PHP Native (Procedural)  |
| Database | MySQL 5.7+               |
| Frontend | HTML5, CSS3, Bootstrap 5 |
| Server   | Apache (XAMPP)           |

## 📋 Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache dengan mod_rewrite
- Web Browser modern (Chrome, Firefox, Edge, Safari)

## 🚀 Cara Instalasi

### 1. Download & Setup

```bash
# File sudah berada di: c:\xampp\htdocs\webmagang2
# Pastikan XAMPP sudah berjalan
```

### 2. Setup Database

```bash
# Buka phpMyAdmin: http://localhost/phpmyadmin
# Import file database.sql untuk membuat tabel dan data default
```

### 3. Konfigurasi

Edit file `config.php` jika perlu:

```php
$host = 'localhost';    # Host MySQL
$user = 'root';         # User MySQL
$pass = '';             # Password MySQL
$db = 'magangpolmed';   # Nama database
```

### 4. Akses Aplikasi

```
URL: http://localhost/webmagang2
```

## 👤 Akun Default

### Admin

```
Email: admin@magang.local
Password: admin123
Role: admin
```

Setelah login, buat user mahasiswa melalui menu "Kelola User"

## 📁 Struktur Project

```
webmagang2/
│
├── 📄 index.php                    # Landing page
├── 📄 login.php                    # Halaman login
├── 📄 logout.php                   # Logout
├── 📄 config.php                   # Konfigurasi database
├── 📄 database.sql                 # Script SQL database
├── 📄 .htaccess                    # Konfigurasi Apache
├── 📄 readme.md                    # Dokumentasi ini
│
├── 📁 admin/                       # Admin Panel
│   ├── dashboard.php               # Dashboard admin
│   ├── pengajuan.php               # Kelola pengajuan magang
│   ├── lowongan.php                # Kelola lowongan magang
│   └── users.php                   # Kelola user
│
├── 📁 mahasiswa/                   # Mahasiswa Panel
│   ├── dashboard.php               # Dashboard mahasiswa
│   ├── pengajuan.php               # Riwayat pengajuan
│   ├── pengajuan_buat.php          # Buat pengajuan baru
│   └── profil.php                  # Edit profil
│
├── 📁 includes/                    # Include files
│   ├── db.php                      # Koneksi database
│   ├── header.php                  # Template header
│   └── footer.php                  # Template footer
│
└── 📁 assets/
    └── css/
        └── bootstrap.min.css       # Bootstrap 5 framework
```

## 📖 Dokumentasi Fitur

### Role Pengguna

#### Admin

Admin memiliki akses penuh untuk mengelola sistem:

1. **Dashboard** - Melihat statistik sistem

   - Total pengajuan
   - Total lowongan
   - Total mahasiswa

2. **Pengajuan Magang** - Kelola pengajuan mahasiswa

   - Lihat semua pengajuan
   - Approve pengajuan
   - Reject pengajuan
   - Lihat detail pengajuan dan profil mahasiswa

3. **Kelola Lowongan** - Tambah/hapus lowongan magang

   - Tambah lowongan baru (nama, deskripsi, kuota, periode)
   - Lihat daftar lowongan
   - Hapus lowongan

4. **Kelola User** - Tambah/hapus user sistem
   - Tambah user baru (admin/mahasiswa)
   - Lihat daftar user
   - Hapus user

#### Mahasiswa

Mahasiswa dapat melakukan:

1. **Dashboard** - Lihat overview pengajuan

   - Total pengajuan saya
   - Status pengajuan
   - Lowongan terbaru

2. **Pengajuan Magang** - Kelola pengajuan

   - Lihat riwayat pengajuan
   - Lihat status pengajuan (pending/approved/rejected)
   - Hapus pengajuan (hanya yang pending)
   - Buat pengajuan baru

3. **Profil** - Kelola profil pribadi
   - Edit nama
   - Edit email
   - Edit nomor telepon
   - Edit alamat

## 🔒 Keamanan

Fitur keamanan yang diterapkan:

1. **Authentication** - Sistem login dengan role
2. **Session Management** - Session-based authentication
3. **Password Hashing** - Password di-hash menggunakan bcrypt
4. **SQL Injection Prevention** - Menggunakan mysqli_real_escape_string
5. **Authorization** - Kontrol akses berdasarkan role
6. **CSRF Protection** - Validasi form

## 📊 Database Schema

### Tabel `users`

```
id          - INT PRIMARY KEY AUTO_INCREMENT
nama        - VARCHAR(255)
email       - VARCHAR(255) UNIQUE
password    - VARCHAR(255) Hashed dengan bcrypt
role        - ENUM('admin', 'mahasiswa')
no_telepon  - VARCHAR(20) Optional
alamat      - TEXT Optional
created_at  - TIMESTAMP
updated_at  - TIMESTAMP
```

### Tabel `lowongan`

```
id              - INT PRIMARY KEY AUTO_INCREMENT
nama_lowongan   - VARCHAR(255)
deskripsi       - TEXT
kuota           - INT
periode_mulai   - DATE
periode_selesai - DATE
created_at      - TIMESTAMP
updated_at      - TIMESTAMP
```

### Tabel `pengajuan`

```
id              - INT PRIMARY KEY AUTO_INCREMENT
mahasiswa_id    - INT FOREIGN KEY (users.id)
lowongan_id     - INT FOREIGN KEY (lowongan.id)
alasan          - TEXT
tanggal_pengajuan - DATETIME
status          - ENUM('pending', 'approved', 'rejected')
created_at      - TIMESTAMP
updated_at      - TIMESTAMP
```

## 🔄 Workflow Pengajuan

1. **Mahasiswa** membuat akun dan login
2. **Mahasiswa** melihat lowongan magang di dashboard
3. **Mahasiswa** mengajukan lowongan dengan alasan
4. **Admin** menerima notifikasi pengajuan baru
5. **Admin** mereview dan approve/reject pengajuan
6. **Mahasiswa** dapat melihat status pengajuan

## 💡 Tips Penggunaan

### Untuk Admin

- Selalu periksa pengajuan baru secara berkala
- Tambahkan lowongan magang sesuai kebutuhan
- Kelola user dengan bijak
- Backup database secara rutin

### Untuk Mahasiswa

- Lengkapi profil dengan data yang akurat
- Baca deskripsi lowongan sebelum mengajukan
- Alasan pengajuan harus jelas dan relevan
- Cek status pengajuan secara berkala

## 🐛 Troubleshooting

### Masalah: Koneksi Database Gagal

**Solusi:**

- Pastikan MySQL sudah running
- Cek username dan password di config.php
- Pastikan database magangpolmed sudah dibuat

### Masalah: Login Tidak Berhasil

**Solusi:**

- Periksa email dan password
- Pastikan role dipilih dengan benar
- Cek bahwa user sudah terdaftar

### Masalah: Session Terputus

**Solusi:**

- Clear cookies browser
- Login ulang
- Periksa pengaturan session PHP

### Masalah: File tidak dapat diakses

**Solusi:**

- Periksa permission folder
- Pastikan file sudah ter-upload dengan benar
- Cek konfigurasi .htaccess

## 📝 Fitur Tambahan (Rencana)

- [ ] Export data ke PDF/Excel
- [ ] Email notification untuk pengajuan
- [ ] Multiple role untuk koordinator
- [ ] Rating/review lowongan
- [ ] Attachment untuk pengajuan
- [ ] Approved letter generator

## 👨‍💻 Developer

Dikembangkan sebagai sistem pengelolaan magang untuk Politeknik Negeri Medan.

## 📞 Support

Untuk bantuan atau pertanyaan, hubungi admin sistem.

## 📄 License

Proprietary - Untuk penggunaan internal.

---

**Last Updated:** Desember 2025
**Version:** 1.0.0
