# Implementasi MVC dengan MySQLi - Panduan Lengkap

## 📋 Daftar Isi
1. [Struktur Proyek](#struktur-proyek)
2. [Komponen MVC](#komponen-mvc)
3. [Setup dan Konfigurasi](#setup-dan-konfigurasi)
4. [Menggunakan Sistem](#menggunakan-sistem)
5. [Best Practices](#best-practices)

---

## 🗂️ Struktur Proyek

```
POS-Cafe-Inventory/
├── app/
│   ├── core/              # File inti aplikasi
│   │   ├── Database.php   # MySQLi database handler (Singleton pattern)
│   │   ├── Model.php      # Base Model class
│   │   ├── Controller.php # Base Controller class
│   │   ├── Router.php     # URL routing system
│   │   └── helpers.php    # Utility functions
│   ├── models/            # Data models
│   │   ├── User.php
│   │   ├── UserKasir.php
│   │   ├── Pelanggan.php
│   │   ├── Pegawai.php
│   │   ├── Invoice.php
│   │   ├── Menu.php
│   │   ├── Kategori.php
│   │   └── Meja.php
│   ├── controllers/       # Business logic controllers
│   │   ├── Auth.php
│   │   ├── Home.php
│   │   └── Pelanggan.php
│   └── views/             # View templates
│       ├── auth/
│       │   ├── login.php
│       │   └── register.php
│       ├── pelanggan/
│       │   ├── list.php
│       │   ├── create.php
│       │   └── edit.php
│       └── dashboard.php
├── public/
│   └── index.php          # Front Controller (entry point)
├── config/
│   ├── koneksi.php        # (Legacy - dapat dihapus)
│   └── library.php
├── assets/
├── plugins/
└── modul/                 # (Legacy - sedang dalam migrasi)
```

---

## 🏗️ Komponen MVC

### 1. **Database Layer (Model Support)**
**File:** `app/core/Database.php`

Fitur:
- MySQLi Object-Oriented Connection
- Singleton Pattern untuk single instance
- Prepared Statements untuk security
- Query methods: `query()`, `getRow()`, `getRows()`, `countRows()`

```php
// Menggunakan Database
$db = Database::getInstance();
$result = $db->getRow("SELECT * FROM pelanggan WHERE id_pelanggan = ?", [$id]);
```

### 2. **Model (Base Class)**
**File:** `app/core/Model.php`

Fitur:
- CRUD operations (Create, Read, Update, Delete)
- Query builders
- Methods: `getAll()`, `getById()`, `insert()`, `update()`, `delete()`, `getWhere()`

```php
// Extends dari Model class
class Pelanggan extends Model {
    protected $table = 'pelanggan';
    
    public function getPelangganById($id) {
        return $this->getById($id, 'id_pelanggan');
    }
}
```

### 3. **Controller (Base Class)**
**File:** `app/core/Controller.php`

Fitur:
- Load model dan view
- Session management
- User authentication checking
- JSON response methods

```php
class PelangganController extends Controller {
    public function index() {
        $model = $this->model('Pelanggan');
        $data = ['pelanggan' => $model->getAll()];
        $this->view('pelanggan/list', $data);
    }
}
```

### 4. **Router**
**File:** `app/core/Router.php`

Sistem URL: `index.php?controller=ControllerName&action=methodName&id=value`

Contoh:
- `public/index.php?controller=pelanggan&action=index` → List semua pelanggan
- `public/index.php?controller=pelanggan&action=edit&id=1` → Edit pelanggan ID 1
- `public/index.php?controller=auth&action=logout` → Logout

---

## ⚙️ Setup dan Konfigurasi

### Step 1: Konfigurasi Database
Edit `app/core/Database.php` baris 8-11:

```php
private $host = 'localhost';
private $username = 'root';
private $password = '';
private $database = 'kedan_db';
```

### Step 2: Update Web Server
Arahkan web server ke folder `public/` sebagai document root.

**Apache (.htaccess di public/):**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [L]
</IfModule>
```

### Step 3: Testing
Akses: `http://localhost/public/index.php?controller=auth&action=index`

---

## 🚀 Menggunakan Sistem

### Membuat Model Baru

**File:** `app/models/Order.php`
```php
<?php
class Order extends Model {
    protected $table = 'order';
    
    public function getOrderByStatus($status) {
        return $this->getWhere(['status' => $status]);
    }
    
    public function getTotalByDate($tanggal) {
        $sql = "SELECT SUM(total) as total FROM " . $this->table . " WHERE tanggal = ?";
        $result = $this->db->getRow($sql, [$tanggal]);
        return $result['total'] ?? 0;
    }
}
?>
```

### Membuat Controller Baru

**File:** `app/controllers/Order.php`
```php
<?php
class OrderController extends Controller {
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    public function index() {
        $orderModel = $this->model('Order');
        $data = ['orders' => $orderModel->getAll()];
        $this->view('order/list', $data);
    }
    
    public function create() {
        // Show create form
        $this->view('order/create');
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?controller=order&action=index');
        }
        
        $data = [
            'nomor_order' => antiinjection($_POST['nomor_order'] ?? ''),
            'tanggal' => date('Y-m-d'),
            'status' => 'pending'
        ];
        
        $orderModel = $this->model('Order');
        $result = $orderModel->insert($data);
        
        if ($result) {
            $_SESSION['success'] = 'Order berhasil ditambahkan';
        } else {
            $_SESSION['error'] = 'Gagal menambahkan order';
        }
        
        $this->redirect('index.php?controller=order&action=index');
    }
}
?>
```

### Membuat View Baru

**File:** `app/views/order/list.php`
```php
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Order</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="margin-top: 20px;">
        <h1>Daftar Order</h1>
        
        <a href="../../index.php?controller=order&action=create" class="btn btn-primary">
            Tambah Order
        </a>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Order</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($data['orders'] as $order):
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $order['nomor_order']; ?></td>
                    <td><?php echo $order['tanggal']; ?></td>
                    <td><?php echo $order['status']; ?></td>
                    <td>
                        <a href="../../index.php?controller=order&action=edit&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="../../index.php?controller=order&action=delete&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
```

---

## 📚 Helper Functions

**File:** `app/core/helpers.php` menyediakan fungsi-fungsi utility:

```php
// Format tanggal ke bahasa Indonesia
tgl_indo('2024-01-15'); // Output: 15 Januari 2024

// Format uang ke Rupiah
format_rupiah(50000); // Output: Rp 50.000

// Anti injection
antiinjection($_POST['nama']); // Clean input

// Redirect
redirect('index.php?controller=home&action=index');

// Get POST data dengan default
getPost('nama', ''); 

// Check request method
isPost(); // true/false
isGet();  // true/false

// Base URL
baseUrl(); // http://localhost/cafe-pos

// Debug variable
dd($variable); // Display and exit
```

---

## 🔐 Security Features

### 1. **Prepared Statements**
Semua query menggunakan prepared statements untuk prevent SQL injection:

```php
// ✅ Safe - menggunakan prepared statement
$db->getRow("SELECT * FROM users WHERE username = ? AND password = ?", [$username, $password]);

// ❌ Unsafe - string interpolation (jangan gunakan)
$db->query("SELECT * FROM users WHERE username = '$username'");
```

### 2. **Input Validation**
Gunakan helper `antiinjection()`:

```php
$nama = antiinjection($_POST['nama']);
$email = antiinjection($_POST['email']);
```

### 3. **Session Management**
Controller base class menyediakan:

```php
$this->requireLogin();    // Check login
$this->isLoggedIn();      // Return boolean
$this->hasRole('admin');  // Check user role
$this->getUser();         // Get username
$this->getUserLevel();    // Get role
```

---

## 📝 Best Practices

### 1. **Model**
- Satu Model untuk satu tabel database
- Gunakan method names yang descriptive
- Implement custom queries di Model (bukan di Controller)

```php
class Invoice extends Model {
    // ✅ Good - business logic di Model
    public function getTotalByDateRange($start, $end) {
        $sql = "SELECT SUM(total) as total FROM invoice WHERE tanggal BETWEEN ? AND ?";
        $result = $this->db->getRow($sql, [$start, $end]);
        return $result['total'] ?? 0;
    }
}
```

### 2. **Controller**
- Jangan lakukan query langsung, gunakan Model
- Keep controller methods singkat dan focused
- Validasi input di Controller

```php
class InvoiceController extends Controller {
    // ✅ Good
    public function show($id) {
        $model = $this->model('Invoice');
        $invoice = $model->getById($id, 'id_invoice');
        $this->view('invoice/show', ['invoice' => $invoice]);
    }
    
    // ❌ Bad - query di controller
    public function show($id) {
        $result = mysql_query("SELECT * FROM invoice WHERE id = $id");
    }
}
```

### 3. **View**
- Hanya display data, tidak boleh ada business logic
- Gunakan conditional statements untuk display
- Escape output untuk security

```php
<?php 
// ✅ Good - hanya display
echo htmlspecialchars($data['nama']);
?>

<?php 
// ❌ Bad - business logic di view
$total = 0;
foreach ($invoices as $inv) {
    $total += $inv['amount'];
}
?>
```

### 4. **Naming Conventions**
- **Controllers:** PascalCase + "Controller" (e.g., `PelangganController`)
- **Models:** PascalCase (e.g., `Pelanggan`)
- **Views:** snake_case (e.g., `pelanggan/list.php`)
- **Methods:** camelCase (e.g., `getPelangganById()`)
- **Database tables:** snake_case (e.g., `pelanggan`, `id_pelanggan`)

### 5. **File Organization**
Tetap dalam struktur folder yang konsisten:
```
app/
├── models/
│   ├── User.php
│   ├── Pelanggan.php
│   └── Invoice.php
├── controllers/
│   ├── Auth.php
│   ├── Home.php
│   └── Pelanggan.php
└── views/
    ├── auth/
    ├── pelanggan/
    └── dashboard.php
```

---

## 🔄 Migrasi dari Legacy Code

### Langkah-langkah Migrasi:

1. **Identifikasi query di file lama**
   - Cari `mysql_query()` atau `mysqli_query()`
   - Pindahkan ke Model class

2. **Buat Model sesuai table**
   - Satu Model untuk satu tabel
   - Implement methods untuk setiap query

3. **Buat Controller**
   - Load Model menggunakan `$this->model('NamaModel')`
   - Move business logic dari view ke Controller

4. **Buat View baru**
   - Copy HTML dari file lama
   - Replace query dengan Model calls
   - Update links ke routing baru

5. **Test**
   - Test setiap fitur
   - Verify session handling
   - Check security

---

## ✅ Checklist Implementasi

- [ ] Database credentials sudah di-update di `Database.php`
- [ ] Web server document root menunjuk ke `public/` folder
- [ ] Session berfungsi dengan baik
- [ ] Login/Logout bekerja
- [ ] Model dan Controller untuk semua entitas sudah dibuat
- [ ] Views sudah diupdate dengan MVC pattern
- [ ] Prepared statements digunakan di semua queries
- [ ] Input validation diterapkan
- [ ] Error handling sudah diimplementasikan

---

## 📞 Support

Untuk pertanyaan atau issues, silakan check dokumentasi atau lihat contoh implementasi di controller dan model yang sudah ada.

Happy coding! 🎉
