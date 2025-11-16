# README - POS Cafe Inventory MVC

## 🎯 Deskripsi Proyek
Refactoring proyek POS Cafe Inventory menggunakan pola arsitektur MVC (Model-View-Controller) dengan MySQLi Object-Oriented untuk keamanan dan maintainability yang lebih baik.

## 📦 Teknologi yang Digunakan
- **PHP 7.x+** (dengan MySQLi extension)
- **MySQL/MariaDB**
- **Bootstrap** untuk UI
- **Font Awesome** untuk icons
- **jQuery** untuk interaktif

## 🚀 Cara Setup

### 1. Clone/Extract Proyek
```bash
cd path/to/POS-Cafe-Inventory
```

### 2. Konfigurasi Database
Edit file `app/core/Database.php` (baris 8-11):
```php
private $host = 'localhost';
private $username = 'root';
private $password = '';
private $database = 'kedan_db';
```

### 3. Setup Web Server

#### Opsi A: Apache
- Set document root ke folder `public/`
- Pastikan mod_rewrite diaktifkan

#### Opsi B: PHP Built-in Server (untuk development)
```bash
cd public
php -S localhost:8000
```

Akses: `http://localhost:8000/index.php?controller=auth&action=index`

#### Opsi C: XAMPP/WAMP
- Copy folder ke `htdocs/` (XAMPP) atau `www/` (WAMP)
- Update vhost atau akses via `localhost/POS-Cafe-Inventory/public/`

### 4. Setup Database
Pastikan database `kedan_db` sudah ada dan tabel-tabel sudah dibuat sesuai struktur lama.

### 5. Mulai Akses
Buka browser dan akses:
```
http://localhost/POS-Cafe-Inventory/public/index.php?controller=auth&action=index
```

## 📂 Struktur Folder MVC

```
app/
├── core/           # Inti aplikasi
│   ├── Database.php    # Koneksi MySQLi
│   ├── Model.php       # Base model
│   ├── Controller.php   # Base controller
│   ├── Router.php      # URL routing
│   └── helpers.php     # Fungsi bantuan
├── models/         # Model classes
├── controllers/    # Controller classes
└── views/          # Template HTML
```

## 🔌 Routing URL
Sistem routing menggunakan query string:
```
public/index.php?controller=ControllerName&action=methodName&id=id_value
```

**Contoh:**
- `/public/index.php?controller=pelanggan&action=index` → List pelanggan
- `/public/index.php?controller=pelanggan&action=create` → Form create
- `/public/index.php?controller=pelanggan&action=store` → Save data
- `/public/index.php?controller=pelanggan&action=edit&id=1` → Edit ID 1
- `/public/index.php?controller=pelanggan&action=delete&id=1` → Delete ID 1

## 👤 User Test
Gunakan kredensial dari database:
- **Username:** (sesuai di tabel `admin` atau `users`)
- **Password:** (sesuai password yang sudah di-hash MD5)

## 📚 Dokumentasi Lengkap
Baca file `MVC_GUIDE.md` untuk panduan lengkap implementasi MVC.

## ✨ Fitur yang Sudah Diimplementasikan

### Core MVC
- ✅ Database singleton pattern dengan MySQLi
- ✅ Base Model dengan CRUD operations
- ✅ Base Controller dengan utility methods
- ✅ URL Router dengan query string
- ✅ Helper functions (format_rupiah, tgl_indo, dll)

### Models (Sudah Dibuat)
- ✅ User (admin)
- ✅ UserKasir (users)
- ✅ Pelanggan
- ✅ Pegawai
- ✅ Invoice
- ✅ Menu
- ✅ Kategori
- ✅ Meja

### Controllers (Sudah Dibuat)
- ✅ Auth (login, logout, register)
- ✅ Home (dashboard)
- ✅ Pelanggan (CRUD)

### Views (Sudah Dibuat)
- ✅ Auth (login, register)
- ✅ Dashboard
- ✅ Pelanggan (list, create, edit)

## 🔄 Migrasi Controller Tambahan

Untuk migrasi controller lainnya dari legacy code:

### Langkah-langkah:
1. **Buat Model** di `app/models/` untuk setiap tabel
2. **Buat Controller** di `app/controllers/` dengan nama `NamaController`
3. **Buat View** di `app/views/NamaController/`
4. **Update routing** link dari view lama

### Template Controller:
```php
<?php
class NamaController extends Controller {
    
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    public function index() {
        $model = $this->model('Nama');
        $data = ['records' => $model->getAll()];
        $this->view('nama/list', $data);
    }
}
?>
```

## 🔒 Security Notes

1. **Prepared Statements**: Semua query menggunakan prepared statements
2. **Input Validation**: Gunakan `antiinjection()` untuk membersihkan input
3. **Session Handling**: Check login dengan `$this->requireLogin()`
4. **Password Hashing**: Password di-hash dengan MD5 (rekomendasi: upgrade ke bcrypt)

## ⚠️ Known Issues & Migrasi

### Legacy Code yang Masih Ada:
- File lama di folder `modul/` masih bisa digunakan untuk transisi
- File `config/koneksi.php` masih ada tapi sudah tidak dipakai
- File `cek_login.php` masih ada tapi sudah digantikan oleh AuthController

### Rekomendasi:
- Secara bertahap migrasi semua module ke MVC structure
- Hapus file legacy setelah testing

## 📋 Checklist Development

- [ ] Database setup & credentials OK
- [ ] Web server configurasi selesai
- [ ] Bisa akses login page
- [ ] Login/logout berfungsi
- [ ] Bisa akses protected pages setelah login
- [ ] Model, Controller, View untuk semua modul dibuat
- [ ] Input validation & error handling
- [ ] Test semua CRUD operations
- [ ] Security check (prepared statements, input validation)

## 🐛 Troubleshooting

### Blank page / Error 500
- Check PHP error log
- Verify database connection credentials
- Ensure MySQLi extension is enabled

### Page not found
- Check if web server document root points to `public/` folder
- Verify URL format: `?controller=...&action=...`

### Session tidak berfungsi
- Ensure `session_start()` dipanggil di controller
- Check PHP session configuration di php.ini

### Database connection error
- Verify MySQL running
- Check credentials di `Database.php`
- Test koneksi manual dengan MySQL client

## 📞 Support & Kontribusi

Untuk pertanyaan atau bug reports, silakan buka issue atau hubungi tim development.

---

## 👨‍💻 **KREDIT**

**Developer:** Khairul Adha  
**Email:** r4dioz.88@gmail.com  
**Website:** www.rainbowcodec.com

---

**Happy Coding! 🚀**
