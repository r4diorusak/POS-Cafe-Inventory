# Quick Reference - POS Cafe Inventory MVC

## 🚀 Quick Start

### 1. Setup Database Credentials
Edit: `app/core/Database.php` (lines 8-11)
```php
private $host = 'localhost';
private $username = 'root';
private $password = '';
private $database = 'kedan_db';
```

### 2. Start Web Server
```bash
cd public
php -S localhost:8000
```
Or configure Apache/Nginx to point to `public/` folder.

### 3. Access Application
```
http://localhost:8000/index.php?controller=auth&action=index
```

---

## 📚 File Structure Quick Map

```
app/core/           # Framework core
  └─ Database.php   # MySQLi connection
  └─ Model.php      # Base model class
  └─ Controller.php  # Base controller class
  └─ Router.php     # URL routing
  └─ helpers.php    # Utility functions

app/models/         # Data models (one per table)
  └─ User.php
  └─ Pelanggan.php
  └─ Invoice.php
  └─ Menu.php
  ... (add more as needed)

app/controllers/    # Business logic
  └─ Auth.php
  └─ Home.php
  └─ Pelanggan.php
  ... (add more as needed)

app/views/          # HTML templates
  └─ auth/
  └─ pelanggan/
  └─ dashboard.php
  ... (add more as needed)

public/index.php    # Entry point
```

---

## 🔌 URL Routing Pattern

```
public/index.php?controller=NAME&action=METHOD&id=VALUE
```

### Examples:
```
Login page:          ?controller=auth&action=index
List pelanggan:      ?controller=pelanggan&action=index
Create pelanggan:    ?controller=pelanggan&action=create
Edit pelanggan ID 5: ?controller=pelanggan&action=edit&id=5
Delete ID 5:         ?controller=pelanggan&action=delete&id=5
```

---

## 📝 Creating New Module (Template)

### Step 1: Create Model
**File:** `app/models/NamaTable.php`
```php
<?php
class NamaTable extends Model {
    protected $table = 'nama_table';
    
    public function getAllRecords() {
        return $this->getAll();
    }
}
?>
```

### Step 2: Create Controller
**File:** `app/controllers/NamaTable.php`
```php
<?php
class NamaTableController extends Controller {
    
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    public function index() {
        $model = $this->model('NamaTable');
        $data = ['records' => $model->getAllRecords()];
        $this->view('nametable/list', $data);
    }
    
    public function create() {
        $this->view('nametable/create');
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=nametable&action=index');
        }
        
        $data = [
            'kolom1' => antiinjection($_POST['kolom1'] ?? ''),
            'kolom2' => antiinjection($_POST['kolom2'] ?? '')
        ];
        
        $model = $this->model('NamaTable');
        if ($model->insert($data)) {
            $_SESSION['success'] = 'Success message';
            $this->redirect('../index.php?controller=nametable&action=index');
        } else {
            $_SESSION['error'] = 'Error message';
            $this->redirect('../index.php?controller=nametable&action=create');
        }
    }
}
?>
```

### Step 3: Create View
**File:** `app/views/nametable/list.php`
```html
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Item</title>
    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="margin-top: 20px;">
        <h1>Daftar Item</h1>
        
        <a href="../../index.php?controller=nametable&action=create" class="btn btn-primary">
            Tambah Item
        </a>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kolom 1</th>
                    <th>Kolom 2</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($data['records'] as $row):
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['kolom1']; ?></td>
                    <td><?php echo $row['kolom2']; ?></td>
                    <td>
                        <a href="../../index.php?controller=nametable&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="../../index.php?controller=nametable&action=delete&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script src="../../../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
```

---

## 🎯 Model Methods Cheat Sheet

### Read Data
```php
$model = $this->model('Pelanggan');

// Get all
$all = $model->getAll();

// Get by ID
$item = $model->getById($id, 'id_column');

// Get with WHERE
$results = $model->getWhere(['status' => 'aktif']);

// Get by condition
$results = $model->getWhere(['status' => 'aktif', 'type' => 'premium']);

// Count all
$total = $model->countAll();

// Count with WHERE
$total = $model->countWhere(['status' => 'aktif']);
```

### Create Data
```php
$data = [
    'nama' => 'John',
    'email' => 'john@example.com'
];
$newId = $model->insert($data);
```

### Update Data
```php
$data = [
    'nama' => 'Jane',
    'email' => 'jane@example.com'
];
$affected = $model->update($data, 'id', $id);
```

### Delete Data
```php
$affected = $model->delete('id', $id);
```

---

## 🛡️ Security Quick Tips

### SQL Injection Prevention
```php
// ✅ SAFE - Prepared statements
$user = $db->getRow("SELECT * FROM users WHERE id = ?", [$id]);

// ❌ UNSAFE - String interpolation
$user = $db->query("SELECT * FROM users WHERE id = '$id'");
```

### XSS Prevention
```php
// ✅ SAFE - Escape output
<?php echo htmlspecialchars($data); ?>

// ❌ UNSAFE - Raw output
<?php echo $data; ?>
```

### Input Validation
```php
// ✅ SAFE - Clean input
$name = antiinjection($_POST['name']);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

// ❌ UNSAFE - Unvalidated input
$name = $_POST['name'];
```

---

## 🔍 Debugging Tools

### View Variable
```php
dd($variable); // Display and exit
var_dump($variable); // Display structure
print_r($variable); // Print readable format
```

### Check Database
```php
$db = Database::getInstance();
$result = $db->getRow("SELECT 1 as test");
var_dump($result); // Should show: array(1) { ["test"] => 1 }
```

### View PHP Info
```php
phpinfo();
```

---

## 📋 Helper Functions Quick Ref

```php
// Format
format_rupiah(50000);           // Rp 50.000
tgl_indo('2024-01-15');         // 15 Januari 2024

// Validation
antiinjection($_POST['data']);  // Clean input
is_valid_email($email);         // Check email

// Request
isPost();                       // Check POST
isGet();                        // Check GET
getPost('key', 'default');      // Get POST value
getGet('key', 'default');       // Get GET value

// Navigation
redirect($url);                 // Redirect
baseUrl();                      // Get base URL
currentUrl();                   // Get current URL

// Utilities
generate_slug('Hello World');   // hello-world
truncate($text, 50);            // Truncate text
```

---

## 🔐 Session Handling

### Check Login
```php
// In controller constructor
$this->requireLogin(); // Redirect if not logged in

// In view
<?php if ($this->isLoggedIn()): ?>
    Welcome, <?php echo $_SESSION['namauser']; ?>
<?php endif; ?>
```

### Get User Data
```php
// Username
$user = $this->getUser();

// User level/role
$level = $this->getUserLevel();

// Check role
if ($this->hasRole('admin')) {
    // Admin only
}
```

### Set Session Data
```php
$_SESSION['namauser'] = 'john';
$_SESSION['leveluser'] = 'admin';
```

---

## 🎨 View Data Passing

### Controller to View
```php
// Controller
$data = [
    'users' => $userModel->getAll(),
    'total' => count($users),
    'title' => 'User List'
];
$this->view('user/list', $data);

// View (automatic variable access)
<?php
foreach ($data['users'] as $user) {
    echo $user['name'];
}
?>
```

---

## 📁 Folder Naming Convention

- **Controllers:** `PascalCase` + Controller (e.g., `PelangganController`)
- **Models:** `PascalCase` (e.g., `Pelanggan`)
- **Views:** `snake_case` (e.g., `pelanggan/list.php`)
- **Methods:** `camelCase` (e.g., `getPelangganById()`)
- **Variables:** `snake_case` (e.g., `$user_name`)

---

## 🚨 Common Errors & Fixes

| Error | Cause | Fix |
|-------|-------|-----|
| "Method not found" | Controller method missing | Check method exists in controller |
| "Undefined variable" | Variable not passed from controller | Check $this->view() data param |
| "Class not found" | Model/Controller file missing | Check file exists with correct name |
| "Database error" | Wrong connection credentials | Update Database.php |
| "Session not working" | session_start() not called | Call session_start() first |
| "Blank page" | Error reporting off | Enable display_errors |

---

## 📞 Documentation Links

- **Full Guide:** `MVC_GUIDE.md`
- **Setup & Installation:** `README.md`
- **Implementation Summary:** `IMPLEMENTATION_SUMMARY.md`
- **Testing & Troubleshooting:** `TESTING_GUIDE.md`
- **API Documentation:** `API_DOCUMENTATION.html`

---

## 🎓 Learning Path

1. **Beginner:** Read `README.md` → Try login
2. **Intermediate:** Read `MVC_GUIDE.md` → Create new module
3. **Advanced:** Implement API endpoints → Add caching → Optimize queries

---

**Quick Reference v1.0**  
*Last Updated: November 16, 2025*
