# Testing & Quick Start Guide

## ⚡ Quick Start

### 1. Persiapan Awal

```
1. Pastikan XAMPP sudah running (Apache + MySQL)
2. Buka browser: http://localhost/phpmyadmin
3. Import file database.sql
4. Akses: http://localhost/webmagang2
```

### 2. Test Login Admin

```
Email: admin@magang.local
Password: admin123
```

### 3. Test Flow

#### Flow Admin:

1. Login dengan akun admin
2. Buat lowongan baru (Admin > Kelola Lowongan > Tambah Lowongan)
3. Tambah user mahasiswa (Admin > Kelola User > Tambah User)
4. Logout

#### Flow Mahasiswa:

1. Login dengan akun mahasiswa yang baru dibuat
2. Lihat dashboard
3. Buat pengajuan (Pengajuan Magang > Buat Pengajuan Baru)
4. Logout

#### Flow Admin Approve:

1. Login dengan admin
2. Lihat pengajuan yang masuk (Pengajuan Magang)
3. Approve atau Reject pengajuan
4. Logout

#### Flow Mahasiswa Check Status:

1. Login dengan mahasiswa
2. Buka menu Pengajuan Magang
3. Lihat status pengajuan (Approved/Rejected)

## 📝 Script Testing

### Buat User Mahasiswa Melalui Direct SQL (Optional)

```sql
INSERT INTO users (nama, email, password, role) VALUES
('Budi Santoso', 'budi@student.local', '$2y$10$ZIvf5KGNLqVtqPLs0Lmcxu68MNnO.UL3z6gqZQqVOoTiKBq.cNWYG', 'mahasiswa'),
('Siti Nurhaliza', 'siti@student.local', '$2y$10$ZIvf5KGNLqVtqPLs0Lmcxu68MNnO.UL3z6gqZQqVOoTiKBq.cNWYG', 'mahasiswa');
-- Password: admin123
```

### Buat Lowongan Melalui Direct SQL (Optional)

```sql
INSERT INTO lowongan (nama_lowongan, deskripsi, kuota, periode_mulai, periode_selesai) VALUES
('Programmer PHP', 'Dibutuhkan programmer PHP berpengalaman untuk proyek web', 5, '2025-01-01', '2025-06-30'),
('UI/UX Designer', 'Designer UI/UX untuk aplikasi mobile dan web', 3, '2025-01-15', '2025-07-15'),
('Data Analyst', 'Analis data untuk business intelligence', 2, '2025-02-01', '2025-08-01');
```

## 🔍 Endpoint Testing

### Public Pages

- **Landing Page:** `http://localhost/webmagang2/index.php`
- **Login Page:** `http://localhost/webmagang2/login.php`

### Admin Pages (Harus Login)

- **Dashboard:** `http://localhost/webmagang2/admin/dashboard.php`
- **Pengajuan:** `http://localhost/webmagang2/admin/pengajuan.php`
- **Lowongan:** `http://localhost/webmagang2/admin/lowongan.php`
- **User:** `http://localhost/webmagang2/admin/users.php`

### Mahasiswa Pages (Harus Login)

- **Dashboard:** `http://localhost/webmagang2/mahasiswa/dashboard.php`
- **Pengajuan:** `http://localhost/webmagang2/mahasiswa/pengajuan.php`
- **Buat Pengajuan:** `http://localhost/webmagang2/mahasiswa/pengajuan_buat.php`
- **Profil:** `http://localhost/webmagang2/mahasiswa/profil.php`

### Other

- **Logout:** `http://localhost/webmagang2/logout.php`

## ✅ Checklist Fungsionalitas

### Authentication

- [ ] Login page berfungsi
- [ ] Password validation bekerja
- [ ] Role selection bekerja
- [ ] Session management bekerja
- [ ] Logout berfungsi
- [ ] Redirect after login sesuai role

### Admin Features

- [ ] Dashboard menampilkan statistik
- [ ] Dapat lihat semua pengajuan
- [ ] Dapat approve pengajuan
- [ ] Dapat reject pengajuan
- [ ] Dapat tambah lowongan
- [ ] Dapat hapus lowongan
- [ ] Dapat tambah user
- [ ] Dapat hapus user
- [ ] Dapat logout

### Mahasiswa Features

- [ ] Dashboard menampilkan info
- [ ] Dapat melihat lowongan
- [ ] Dapat buat pengajuan
- [ ] Dapat lihat riwayat pengajuan
- [ ] Dapat lihat status pengajuan
- [ ] Dapat edit profil
- [ ] Dapat logout

### Security

- [ ] Non-admin tidak bisa akses admin page
- [ ] Non-mahasiswa tidak bisa akses mahasiswa page
- [ ] Session timeout bekerja
- [ ] Password di-hash
- [ ] SQL injection prevention

## 🐛 Debug Tips

### Jika Error Koneksi Database

```php
// Buka config.php dan cek:
// 1. $host, $user, $pass, $db
// 2. Database sudah dibuat
// 3. MySQL sudah running
// 4. User MySQL punya privilege
```

### Jika Login Gagal

```php
// Debug:
// 1. Cek tabel users di database
// 2. Cek password hash benar
// 3. Cek email dan role sesuai
// 4. Cek session berjalan
```

### Jika Session Terputus

```php
// Solusi:
// 1. Clear browser cookies
// 2. Clear browser cache
// 3. Buka file baru/incognito
// 4. Cek php.ini session settings
```

## 📊 Database Query Testing

### Test Koneksi

```sql
SELECT * FROM users;
SELECT * FROM lowongan;
SELECT * FROM pengajuan;
```

### Test Admin User

```sql
SELECT * FROM users WHERE role = 'admin';
```

### Test Mahasiswa User

```sql
SELECT * FROM users WHERE role = 'mahasiswa';
```

### Test Pengajuan

```sql
SELECT p.*, u.nama, l.nama_lowongan
FROM pengajuan p
JOIN users u ON p.mahasiswa_id = u.id
JOIN lowongan l ON p.lowongan_id = l.id;
```

## 💻 Browser Developer Tools

Gunakan F12 untuk membuka Developer Tools:

### Network Tab

- Monitor request/response
- Check status code (200, 302, 404, 500)
- Lihat request headers dan response

### Console Tab

- Check JavaScript errors
- Lihat console.log messages

### Application Tab

- Check cookies (PHPSESSID)
- Check localStorage
- Verify session cookies

## 🚀 Performance Testing

### Recommended Tools

- Browser DevTools (built-in)
- Postman (API testing)
- LoadRunner (load testing)

### Metrics to Check

- Page load time
- Database query time
- Session timeout
- Memory usage

## 📝 Log Checking

### Error Log Location

```
XAMPP/php/php_error.log
XAMPP/apache/logs/error.log
```

### Check Logs

```bash
# Windows PowerShell
Get-Content "C:\xampp\php\php_error.log" -Tail 20
Get-Content "C:\xampp\apache\logs\error.log" -Tail 20
```

## 🎯 Acceptance Criteria

### Must Have

- [x] Login/Logout berfungsi
- [x] Admin dapat manage pengajuan
- [x] Admin dapat manage lowongan
- [x] Mahasiswa dapat buat pengajuan
- [x] Mahasiswa dapat edit profil
- [x] Database terstruktur dengan baik

### Nice to Have

- [ ] Email notifications
- [ ] Export to PDF
- [ ] Advanced search
- [ ] Pagination
- [ ] API documentation

---

**Last Updated:** Desember 2025
