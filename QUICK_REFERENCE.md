# 🚀 QUICK REFERENCE CARD

## 📍 Location

```
C:\xampp\htdocs\webmagang2
```

## ⏱️ Time to Setup

```
1. Import database.sql: 1 minute
2. Verify config.php: 1 minute
3. Test login: 1 minute
Total: ~3 minutes
```

---

## 🔑 Default Credentials

### Admin Account

```
Email: admin@magang.local
Password: admin123
Role: admin
```

### Test Student (Create via Admin Panel)

```
Example:
- Email: student@email.com
- Password: anypassword
- Role: mahasiswa
```

---

## 🌐 Quick URLs

| Page              | URL                                                   |
| ----------------- | ----------------------------------------------------- |
| Home              | `http://localhost/webmagang2`                         |
| Login             | `http://localhost/webmagang2/login.php`               |
| Admin Dashboard   | `http://localhost/webmagang2/admin/dashboard.php`     |
| Student Dashboard | `http://localhost/webmagang2/mahasiswa/dashboard.php` |

---

## 📊 Database Info

| Name           | Tables | Default Data |
| -------------- | ------ | ------------ |
| `magangpolmed` | 3      | 1 admin user |

### Tables

1. `users` - Users & profiles
2. `lowongan` - Job postings
3. `pengajuan` - Applications

---

## 🔐 Login Workflow

```
1. Go to /index.php
2. Click "Masuk Sistem"
3. Enter email & password
4. Select role (admin/mahasiswa)
5. Submit
6. Redirect to dashboard
```

---

## 📋 Admin Workflow

```
Admin Dashboard
├─ Add Job Posting
│  ├─ Kelola Lowongan
│  ├─ Click "Tambah Lowongan"
│  └─ Fill form & submit
├─ Manage Applications
│  ├─ Pengajuan Magang
│  ├─ View list
│  └─ Approve/Reject
├─ Manage Users
│  ├─ Kelola User
│  ├─ Click "Tambah User"
│  └─ Fill form & submit
└─ View Stats
   └─ On dashboard
```

---

## 👨‍🎓 Student Workflow

```
Student Dashboard
├─ View Latest Jobs
│  ├─ See on dashboard
│  └─ Or go to Pengajuan Magang
├─ Apply for Job
│  ├─ Click "Ajukan"
│  ├─ Select lowongan
│  ├─ Write reason
│  └─ Submit
├─ Check Status
│  ├─ Pengajuan Magang
│  └─ See pending/approved/rejected
└─ Edit Profile
   ├─ Profil
   ├─ Update info
   └─ Save
```

---

## 🛠️ File Structure

```
webmagang2/
├── 📄 Core Files
│   ├── config.php         → Database config
│   ├── index.php          → Landing page
│   ├── login.php          → Login page
│   └── logout.php         → Logout
├── 📁 admin/              → Admin pages (4 files)
├── 📁 mahasiswa/          → Student pages (4 files)
├── 📁 includes/           → Templates (3 files)
├── 📁 assets/             → CSS & JS
└── 📄 Docs
    ├── readme.md          → Main docs
    ├── INSTALL.md         → Install guide
    ├── API.md             → API reference
    └── CONFIG.md          → Configuration
```

---

## ⚙️ Configuration

### Database (config.php)

```php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'magangpolmed';
```

### PHP

```ini
; php.ini
display_errors = Off
session.gc_maxlifetime = 1440
```

---

## 🧪 Test Checklist

- [ ] Can access landing page
- [ ] Can login as admin
- [ ] Can access admin dashboard
- [ ] Can view applications
- [ ] Can create job posting
- [ ] Can create student user
- [ ] Can login as student
- [ ] Can access student dashboard
- [ ] Can create application
- [ ] Can see status change after approval
- [ ] Can edit student profile
- [ ] Can logout

---

## 🐛 Common Issues

| Issue              | Solution                      |
| ------------------ | ----------------------------- |
| Database not found | Import database.sql           |
| Login fails        | Check credentials & database  |
| Blank page         | Check error log & PHP version |
| Access denied      | Check role authorization      |
| Session issues     | Clear cookies                 |

---

## 📚 Key Files

### To Modify Database

```
database.sql
```

### To Change DB Credentials

```
config.php
```

### To Add Features

```
admin/*.php
mahasiswa/*.php
```

### To Change Styling

```
includes/header.php
includes/footer.php
assets/css/bootstrap.min.css
```

---

## 🔍 Key Features

✅ User authentication  
✅ Role-based access  
✅ Admin panel  
✅ Student panel  
✅ Job posting management  
✅ Application workflow  
✅ Profile management  
✅ Dashboard statistics  
✅ Responsive design  
✅ Secure passwords

---

## 📖 Important Functions

### Authentication

```php
$_SESSION['user_id']
$_SESSION['role']
password_hash()
password_verify()
```

### Database

```php
mysqli_query()
mysqli_fetch_assoc()
mysqli_real_escape_string()
```

### Redirect

```php
header("Location: /path");
```

---

## 🚀 Production Checklist

- [ ] Backup database
- [ ] Test on staging
- [ ] Update config.php
- [ ] Set up SSL
- [ ] Configure backups
- [ ] Set up monitoring
- [ ] Test all features
- [ ] Performance test
- [ ] Security audit
- [ ] User training

---

## 📞 Support Resources

| Topic           | File                        |
| --------------- | --------------------------- |
| Installation    | INSTALL.md                  |
| Testing         | TESTING.md                  |
| Configuration   | CONFIG.md                   |
| API Reference   | API.md                      |
| Troubleshooting | CONFIG.md → Troubleshooting |

---

## 💾 Quick Commands

### MySQL

```sql
-- Import database
mysql -u root -p magangpolmed < database.sql

-- Check tables
SHOW TABLES IN magangpolmed;

-- Count users
SELECT COUNT(*) FROM users;
```

### Windows PowerShell

```powershell
# Check files
dir c:\xampp\htdocs\webmagang2 -Recurse

# Start XAMPP services
C:\xampp\xampp_start.exe
```

---

## 🎯 Next Actions

1. **Setup** (1-2 minutes)

   - [ ] Import database.sql
   - [ ] Verify config.php

2. **Test** (5-10 minutes)

   - [ ] Test admin login
   - [ ] Create job posting
   - [ ] Create student
   - [ ] Test student flow

3. **Deploy** (as needed)
   - [ ] Move to production server
   - [ ] Update config.php
   - [ ] Setup backup strategy
   - [ ] Monitor system

---

**Print this card or save as bookmark for quick reference!**

**Version:** 1.0.0 | **Date:** Desember 2025
