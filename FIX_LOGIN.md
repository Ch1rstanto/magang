# 🚨 FIX LOGIN ISSUE - Panduan Cepat

## Masalah

Anda login dengan email `admin@magang.local` dan password `admin123` tapi mendapat error "Password salah!"

## Solusi Cepat (3 Langkah)

### Langkah 1: Buka Setup Page

Akses URL ini di browser:

```
http://localhost/webmagang2/setup_login.php
```

### Langkah 2: Klik Tombol Setup

- Klik tombol **"Jalankan Setup Database"**
- Tunggu sampai selesai
- Lihat output yang muncul

### Langkah 3: Jalankan Debug

- Klik tombol **"Jalankan Debug Login"**
- Script akan otomatis memperbaiki password jika ada masalah

### Langkah 4: Login

- Buka `http://localhost/webmagang2/login.php`
- Masukkan:
  - Email: `admin@magang.local`
  - Password: `admin123`
  - Role: `admin`
- Klik Login

---

## Apa yang Dilakukan Script

### setup.php

- ✅ Membuat database `magangpolmed`
- ✅ Membuat 3 tabel (users, lowongan, pengajuan)
- ✅ Membuat admin user dengan password terenkripsi
- ✅ Membuat indexes untuk performa

### debug_login.php

- ✅ Mengecek koneksi database
- ✅ Mengecek keberadaan tabel users
- ✅ Memverifikasi password hash
- ✅ **Otomatis memperbaiki** jika password tidak cocok

---

## Troubleshooting

### Jika masih error setelah Step 1-3:

**Q: "Koneksi database gagal"**

```
A: 1. Pastikan XAMPP running (Apache + MySQL)
   2. Cek di taskbar atau http://localhost/xampp
   3. Jalankan lagi setup.php
```

**Q: "User tidak ditemukan"**

```
A: Berarti database kosong
   1. Jalankan setup.php
   2. Pastikan tidak ada error saat setup
   3. Cek di phpMyAdmin
```

**Q: "Password salah"**

```
A: Password hash tidak cocok
   1. Jalankan debug_login.php
   2. Script akan otomatis perbaiki
   3. Coba login lagi
```

---

## Verifikasi Manual di phpMyAdmin

Jika ingin cek secara manual:

1. Buka `http://localhost/phpmyadmin`
2. Di sidebar kiri, cari database `magangpolmed`
3. Klik untuk membuka
4. Di bagian tengah, klik tab "users"
5. Seharusnya ada 1 row dengan:
   - email: `admin@magang.local`
   - role: `admin`

---

## File yang Dibuat

- **setup_login.php** - Halaman bantuan (ini)
- **setup.php** - Script setup database
- **debug_login.php** - Script diagnosa & perbaikan

Akses: `http://localhost/webmagang2/setup_login.php`

---

## Password Sudah Benar?

Jika debug_login.php mengatakan "Password is CORRECT!", berarti:

- ✅ Database OK
- ✅ Admin user OK
- ✅ Password OK

Maka coba:

1. **Clear browser cache** (Ctrl+Shift+Del)
2. **Buka incognito window** (Ctrl+Shift+N)
3. Login lagi

---

**Dibuat:** Desember 2025  
**Versi:** 1.0.0
