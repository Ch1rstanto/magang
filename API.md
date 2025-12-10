# API Endpoints & Quick Reference

## 🌐 Base URL

```
http://localhost/webmagang2
```

---

## 📋 Public Endpoints (Tidak perlu login)

### Landing Page

```
GET /index.php
- Purpose: Halaman utama / landing page
- Returns: HTML dengan info fitur
- Redirect:
  - Admin -> /admin/dashboard.php
  - Mahasiswa -> /mahasiswa/dashboard.php
```

### Login Page

```
GET /login.php
POST /login.php
- Purpose: Halaman login dan proses autentikasi
- Method: GET (show form), POST (process login)
- Parameters: email, password, role
- Returns: Form login / redirect after auth
- Success Redirect: /admin/dashboard.php atau /mahasiswa/dashboard.php
```

### Logout

```
GET /logout.php
- Purpose: Logout dan destroy session
- Method: GET
- Returns: Redirect ke /index.php
- Session: Destroyed
```

---

## 🔐 Admin Endpoints (Perlu login sebagai admin)

### Admin Dashboard

```
GET /admin/dashboard.php
- Purpose: Dashboard admin dengan statistik
- Authorization: admin only
- Query:
  - Count pengajuan
  - Count lowongan
  - Count mahasiswa
- Returns: HTML dashboard dengan card statistik
```

### Admin - Kelola Pengajuan

```
GET /admin/pengajuan.php
POST /admin/pengajuan.php
- Purpose: Lihat dan approve/reject pengajuan
- Authorization: admin only
- Method: GET (show list), POST (process action)
- Parameters: pengajuan_id, status (approved/rejected)
- Query: SELECT dengan JOIN users dan lowongan
- Returns: Table dengan data pengajuan
```

### Admin - Kelola Lowongan

```
GET /admin/lowongan.php
POST /admin/lowongan.php
GET /admin/lowongan.php?action=hapus&id=X
- Purpose: Tambah dan hapus lowongan
- Authorization: admin only
- Method: GET (show list), POST (add), GET with params (delete)
- POST Parameters:
  - action: tambah
  - nama_lowongan: string
  - deskripsi: text
  - kuota: integer
  - periode_mulai: date
  - periode_selesai: date
- Query Parameters: action=hapus, id=X
- Returns: Table dengan modal form
```

### Admin - Kelola User

```
GET /admin/users.php
POST /admin/users.php
GET /admin/users.php?action=hapus&id=X
- Purpose: Tambah dan hapus user
- Authorization: admin only
- Method: GET (show list), POST (add), GET with params (delete)
- POST Parameters:
  - action: tambah
  - nama: string
  - email: email
  - password: password
  - role: admin/mahasiswa
- Query Parameters: action=hapus, id=X
- Returns: Table dengan modal form
```

---

## 👨‍🎓 Mahasiswa Endpoints (Perlu login sebagai mahasiswa)

### Mahasiswa Dashboard

```
GET /mahasiswa/dashboard.php
- Purpose: Dashboard mahasiswa dengan info pengajuan
- Authorization: mahasiswa only
- Query:
  - Count pengajuan user
  - Count by status
  - List lowongan terbaru
- Returns: HTML dashboard dengan card statistik
```

### Mahasiswa - Riwayat Pengajuan

```
GET /mahasiswa/pengajuan.php
GET /mahasiswa/pengajuan.php?action=hapus&id=X
- Purpose: Lihat riwayat pengajuan dan hapus
- Authorization: mahasiswa only
- Method: GET (show list), GET with params (delete)
- Query Parameters: action=hapus, id=X
- Query: SELECT pengajuan WHERE mahasiswa_id = session user
- Returns: Table dengan data pengajuan user
```

### Mahasiswa - Buat Pengajuan

```
GET /mahasiswa/pengajuan_buat.php
GET /mahasiswa/pengajuan_buat.php?lowongan_id=X
POST /mahasiswa/pengajuan_buat.php
- Purpose: Form dan process membuat pengajuan baru
- Authorization: mahasiswa only
- Method: GET (show form), POST (process)
- Query Parameters: lowongan_id (optional, untuk pre-select)
- POST Parameters:
  - lowongan_id: integer
  - alasan: text
- Validation:
  - Check duplikasi pengajuan
  - Validate lowongan_id
- Returns: Form atau redirect ke /mahasiswa/pengajuan.php
```

### Mahasiswa - Edit Profil

```
GET /mahasiswa/profil.php
POST /mahasiswa/profil.php
- Purpose: Lihat dan edit profil mahasiswa
- Authorization: mahasiswa only
- Method: GET (show form), POST (update)
- POST Parameters:
  - nama: string
  - email: email
  - no_telepon: string (optional)
  - alamat: text (optional)
- Updates: users table WHERE id = session user
- Returns: Form dengan current data
```

---

## 🔌 Include Files (Utilities)

### db.php

```
- Session start
- Database connection
- Connection validation
- Charset UTF-8 setting
- Error handling
```

### header.php

```
- Check session (redirect if not logged in)
- Start HTML structure
- Include Bootstrap CSS
- Display navbar dengan user info
- Start sidebar structure
```

### footer.php

```
- Close sidebar structure
- Include Bootstrap JS
- End HTML
```

---

## 📊 Database Operations

### Query Pattern - GET (Read)

```php
$query = "SELECT * FROM table_name";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
```

### Query Pattern - INSERT (Create)

```php
$query = "INSERT INTO table_name (col1, col2) VALUES ('val1', 'val2')";
mysqli_query($conn, $query);
```

### Query Pattern - UPDATE (Update)

```php
$query = "UPDATE table_name SET col1='val1' WHERE id=1";
mysqli_query($conn, $query);
```

### Query Pattern - DELETE (Delete)

```php
$query = "DELETE FROM table_name WHERE id=1";
mysqli_query($conn, $query);
```

---

## 🛡️ Security Measures

### Input Protection

```php
$input = mysqli_real_escape_string($conn, $_POST['input']);
```

### Session Check

```php
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}
```

### Role Check

```php
if ($_SESSION['role'] != 'admin') {
    header("Location: /index.php");
    exit;
}
```

### Password Hashing

```php
// Hash
$hash = password_hash($password, PASSWORD_DEFAULT);

// Verify
password_verify($password, $hash);
```

---

## 📝 HTTP Methods Used

| Method | Purpose       | Typical Use           |
| ------ | ------------- | --------------------- |
| GET    | Retrieve data | Load page, show form  |
| POST   | Submit data   | Login, create, update |

---

## 🔄 Redirect Flows

### Landing Page Logic

```
/index.php
├─ If session exists
│  ├─ role = admin → /admin/dashboard.php
│  └─ role = mahasiswa → /mahasiswa/dashboard.php
└─ If no session → Show landing page
```

### Login Logic

```
/login.php (POST)
├─ If credentials valid
│  ├─ role = admin → /admin/dashboard.php
│  └─ role = mahasiswa → /mahasiswa/dashboard.php
└─ If credentials invalid → Show error & stay on /login.php
```

### Protected Pages Logic

```
/admin/* or /mahasiswa/*
├─ If session exists & role matches
│  └─ Show page
└─ If session not exists or role doesn't match
   └─ Redirect to /index.php
```

### Logout Logic

```
/logout.php
└─ Destroy session → /index.php
```

---

## 💾 Form Submissions

### Login Form

```html
<form method="POST" action="/login.php">
  - email (required) - password (required) - role (required): admin or mahasiswa
</form>
```

### Add Lowongan Form

```html
<form method="POST" action="/admin/lowongan.php">
  - action: "tambah" - nama_lowongan (required) - deskripsi (required) - kuota
  (required, integer) - periode_mulai (required, date) - periode_selesai
  (required, date)
</form>
```

### Add User Form

```html
<form method="POST" action="/admin/users.php">
  - action: "tambah" - nama (required) - email (required, email) - password
  (required) - role (required): admin or mahasiswa
</form>
```

### Approve/Reject Pengajuan Form

```html
<form method="POST" action="/admin/pengajuan.php">
  - pengajuan_id (hidden) - status (hidden): "approved" or "rejected"
</form>
```

### Create Pengajuan Form

```html
<form method="POST" action="/mahasiswa/pengajuan_buat.php">
  - lowongan_id (required, select) - alasan (required, textarea)
</form>
```

### Edit Profil Form

```html
<form method="POST" action="/mahasiswa/profil.php">
  - nama (required) - email (required, email) - no_telepon (optional) - alamat
  (optional, textarea)
</form>
```

---

## 📱 Response Types

### Success Response

```
HTTP/1.1 200 OK
Content-Type: text/html

[HTML Page]

+ Session cookie (PHPSESSID)
+ Success message (alert)
```

### Redirect Response

```
HTTP/1.1 302 Found
Location: /redirect/path

[Redirect to new URL]
```

### Error Response

```
HTTP/1.1 200 OK
Content-Type: text/html

[HTML Page with error message]
```

---

## ⏱️ Session Management

### Session Variables

```php
$_SESSION['user_id']   // User ID
$_SESSION['nama']      // User name
$_SESSION['email']     // User email
$_SESSION['role']      // User role (admin/mahasiswa)
```

### Session Lifetime

- Default PHP session timeout: 1440 seconds (24 minutes) dari last activity
- Dapat dikonfigurasi di php.ini

### Session Destroy

```php
session_start();
session_destroy();
header("Location: /index.php");
```

---

## 🧪 Testing URLs

```
Landing: http://localhost/webmagang2/index.php
Login: http://localhost/webmagang2/login.php

Admin Dashboard: http://localhost/webmagang2/admin/dashboard.php
Admin Pengajuan: http://localhost/webmagang2/admin/pengajuan.php
Admin Lowongan: http://localhost/webmagang2/admin/lowongan.php
Admin Users: http://localhost/webmagang2/admin/users.php

Mahasiswa Dashboard: http://localhost/webmagang2/mahasiswa/dashboard.php
Mahasiswa Pengajuan: http://localhost/webmagang2/mahasiswa/pengajuan.php
Mahasiswa Buat: http://localhost/webmagang2/mahasiswa/pengajuan_buat.php
Mahasiswa Profil: http://localhost/webmagang2/mahasiswa/profil.php

Logout: http://localhost/webmagang2/logout.php
```

---

**Last Updated:** Desember 2025
**Version:** 1.0.0
