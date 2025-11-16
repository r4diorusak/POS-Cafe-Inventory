# Testing & Troubleshooting Guide

## 🧪 Testing Checklist

### 1. Environment Setup
- [ ] PHP 7.x+ terinstall
- [ ] MySQL/MariaDB running
- [ ] MySQLi extension enabled
- [ ] Database `kedan_db` sudah dibuat
- [ ] Database credentials updated di `app/core/Database.php`

### 2. Web Server Configuration
- [ ] Web server document root menunjuk ke `public/` folder
- [ ] mod_rewrite enabled (untuk Apache)
- [ ] File permissions correct (644 untuk files, 755 untuk folders)

### 3. Core Functionality Testing

#### Test 1: Access Login Page
```
URL: http://localhost/public/index.php?controller=auth&action=index
Expected: Login form terbuka
Status: ✓ Pass / ✗ Fail
```

#### Test 2: Database Connection
```php
// Test di file terpisah
require_once 'app/core/Database.php';
$db = Database::getInstance();
$result = $db->getRow("SELECT 1 as test");
echo $result ? 'Connected!' : 'Failed!';
```

#### Test 3: Model CRUD
```php
// Test User Model
require_once 'app/core/Database.php';
require_once 'app/core/Model.php';
require_once 'app/models/User.php';

$userModel = new User();
$users = $userModel->getAllUsers();
var_dump($users);
```

#### Test 4: Session Management
```php
// Test session
session_start();
$_SESSION['test'] = 'hello';
echo $_SESSION['test']; // Should output: hello
```

#### Test 5: Helper Functions
```php
require_once 'app/core/helpers.php';

// Test format_rupiah
echo format_rupiah(50000); // Output: Rp 50.000

// Test tgl_indo
echo tgl_indo('2024-01-15'); // Output: 15 Januari 2024

// Test antiinjection
echo antiinjection('<script>alert("XSS")</script>'); // Clean output
```

### 4. Login Testing

#### Valid User Test
```
Username: admin (dari database)
Password: (sesuai password di database yang sudah di-hash)
Expected: Redirect ke dashboard
Status: ✓ Pass / ✗ Fail
```

#### Invalid User Test
```
Username: wronguser
Password: wrongpass
Expected: Error message
Status: ✓ Pass / ✗ Fail
```

#### Session Test
```
1. Login dengan user valid
2. Buka halaman protected tanpa login (new tab/browser)
3. Expected: Redirect ke login page
Status: ✓ Pass / ✗ Fail
```

### 5. CRUD Operations

#### Pelanggan Module
- [ ] List pelanggan: `?controller=pelanggan&action=index`
- [ ] Create form: `?controller=pelanggan&action=create`
- [ ] Create submit: POST ke `?controller=pelanggan&action=store`
- [ ] Edit form: `?controller=pelanggan&action=edit&id=1`
- [ ] Edit submit: POST ke `?controller=pelanggan&action=update&id=1`
- [ ] Delete: `?controller=pelanggan&action=delete&id=1`
- [ ] Search: POST ke `?controller=pelanggan&action=search`

#### Menu Module
- [ ] List menu: `?controller=menu&action=index`
- [ ] Create menu
- [ ] Update menu
- [ ] Delete menu

#### Invoice Module
- [ ] List invoice: `?controller=invoice&action=index`
- [ ] Today invoice: `?controller=invoice&action=today`
- [ ] Report: `?controller=invoice&action=report`

### 6. Security Testing

#### SQL Injection Test
```
Input: ' OR '1'='1
Expected: Input di-escape dan tidak ada SQL injection
Status: ✓ Pass / ✗ Fail
```

#### XSS Test
```
Input: <script>alert('XSS')</script>
Expected: Script tidak dijalankan, input di-escape
Status: ✓ Pass / ✗ Fail
```

#### Session Hijacking Test
```
1. Login dengan user A
2. Copy session ID
3. Coba akses dengan session ID yang sama di browser lain
Expected: Session tidak bisa digunakan di browser lain (tergantung config)
Status: ✓ Pass / ✗ Fail
```

---

## 🔧 Troubleshooting

### Problem 1: Blank Page / White Screen

**Symptoms:**
- Halaman kosong tanpa error message
- Browser menampilkan blank page

**Solutions:**
1. Check PHP error log
   ```bash
   # Linux
   tail -f /var/log/apache2/error.log
   
   # Windows (XAMPP)
   C:\xampp\apache\logs\error.log
   ```

2. Enable display_errors temporarily (development only)
   ```php
   // Tambah di public/index.php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

3. Check database connection
   ```php
   require_once 'app/core/Database.php';
   try {
       $db = Database::getInstance();
       echo "Connected!";
   } catch (Exception $e) {
       echo "Error: " . $e->getMessage();
   }
   ```

---

### Problem 2: Database Connection Error

**Symptoms:**
```
Connection failed: ...
```

**Solutions:**
1. Verify MySQL running
   ```bash
   # Linux
   sudo service mysql status
   
   # Windows
   # Check Services atau use XAMPP control panel
   ```

2. Check credentials in `app/core/Database.php`
   ```php
   private $host = 'localhost';      // Correct?
   private $username = 'root';       // Correct?
   private $password = '';           // Correct?
   private $database = 'kedan_db';   // Database exists?
   ```

3. Test MySQL connection
   ```bash
   mysql -h localhost -u root -p kedan_db
   ```

4. Check MySQLi extension enabled
   ```php
   phpinfo();
   // Look for "mysqli" section
   ```

---

### Problem 3: Page Not Found / 404

**Symptoms:**
- "Page not found" error
- 404 error

**Solutions:**
1. Check URL format
   ```
   Correct: public/index.php?controller=auth&action=index
   Wrong: public/index.php?controller=Auth&action=Index (case-sensitive)
   ```

2. Verify controller file exists
   ```
   app/controllers/Auth.php (file exists?)
   app/controllers/Home.php (file exists?)
   ```

3. Check routing in Router.php
   ```php
   // Router.php line 34
   $this->controller = ucfirst(strtolower($_GET['controller']));
   ```

4. Verify document root
   ```
   Web server document root harus menunjuk ke "public/" folder
   ```

---

### Problem 4: Session Not Working

**Symptoms:**
- Session data tidak tersimpan
- $_SESSION['namauser'] undefined

**Solutions:**
1. Check session_start()
   ```php
   // Must be called BEFORE any output
   session_start(); // Jangan ada echo/output sebelumnya
   ```

2. Verify session directory writable
   ```bash
   # Linux - check /tmp directory
   ls -la /tmp
   
   # Windows - check temp folder permissions
   ```

3. Check session configuration in php.ini
   ```ini
   session.save_path = "/tmp"  ; atau path lainnya yang writable
   session.use_cookies = 1
   session.cookie_lifetime = 0
   ```

4. Debug session
   ```php
   session_start();
   var_dump($_SESSION); // See all session data
   ```

---

### Problem 5: CSRF / Security Issues

**Symptoms:**
- Form submission fails
- Unexpected redirects

**Solutions:**
1. Implement CSRF token
   ```php
   // Generate token
   $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
   
   // In form
   <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
   
   // Verify
   if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
       die('CSRF token mismatch');
   }
   ```

2. Use HTTPS in production
   ```php
   define('FORCE_HTTPS', true);
   ```

3. Set secure cookie flags
   ```php
   ini_set('session.cookie_secure', 1);      // HTTPS only
   ini_set('session.cookie_httponly', 1);    // No JavaScript access
   ini_set('session.cookie_samesite', 'Strict');
   ```

---

### Problem 6: File Upload Issues

**Symptoms:**
- Upload fails
- File not saved

**Solutions:**
1. Check upload directory exists and writable
   ```bash
   mkdir -p uploads
   chmod 755 uploads
   ```

2. Check file size limits in php.ini
   ```ini
   upload_max_filesize = 50M
   post_max_size = 50M
   ```

3. Verify MIME types allowed
   ```php
   $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
   ```

---

### Problem 7: Prepared Statement Issues

**Symptoms:**
- "Prepare failed" error
- Query not working

**Solutions:**
1. Check query syntax
   ```php
   // Correct
   $sql = "SELECT * FROM users WHERE id = ? AND status = ?";
   $result = $db->query($sql, [$id, 'active']);
   
   // Wrong
   $sql = "SELECT * FROM users WHERE id = '$id' AND status = '$status'";
   ```

2. Verify parameter count
   ```php
   // Wrong - 2 placeholders tapi 3 parameters
   $sql = "SELECT * FROM users WHERE id = ? AND status = ?";
   $result = $db->query($sql, [$id, $status, $extra]);
   
   // Correct
   $sql = "SELECT * FROM users WHERE id = ? AND status = ? AND name = ?";
   $result = $db->query($sql, [$id, $status, $name]);
   ```

3. Check parameter types
   ```php
   // Integer
   $id = 1;
   
   // String
   $name = "John";
   
   // Float
   $price = 99.99;
   ```

---

## 📊 Debug Tools

### 1. Using dd() Function
```php
require_once 'app/core/helpers.php';

dd($variable); // Display and exit
```

### 2. Using var_dump()
```php
var_dump($data);
```

### 3. Using print_r()
```php
print_r($data);
```

### 4. File Logging
```php
// Simple logging
$log = "Error: " . date('Y-m-d H:i:s') . " - " . $message . "\n";
file_put_contents('logs/error.log', $log, FILE_APPEND);
```

---

## 📋 Performance Optimization

### 1. Database Queries
```php
// Bad - N+1 query problem
foreach ($users as $user) {
    $profile = $db->getRow("SELECT * FROM profiles WHERE user_id = ?", [$user['id']]);
}

// Better - Single query with JOIN
$sql = "SELECT u.*, p.* FROM users u LEFT JOIN profiles p ON u.id = p.user_id";
$results = $db->getRows($sql);
```

### 2. Caching
```php
// Simple caching
$cacheFile = 'cache/users.json';
if (file_exists($cacheFile) && time() - filemtime($cacheFile) < 3600) {
    $data = json_decode(file_get_contents($cacheFile), true);
} else {
    $data = $userModel->getAll();
    file_put_contents($cacheFile, json_encode($data));
}
```

### 3. Pagination
```php
// Implement pagination
$page = getGet('page', 1);
$limit = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM users LIMIT ? OFFSET ?";
$users = $db->getRows($sql, [$limit, $offset]);
```

---

## ✅ Pre-Deployment Checklist

- [ ] All error reporting disabled in production
- [ ] Database credentials not exposed
- [ ] HTTPS enabled
- [ ] Security headers set
- [ ] CSRF protection implemented
- [ ] Input validation on all forms
- [ ] SQL injection prevention (prepared statements)
- [ ] XSS prevention (output escaping)
- [ ] Rate limiting implemented
- [ ] Logging configured
- [ ] Backup strategy in place
- [ ] Update PHP to latest version
- [ ] Remove debug tools (dd(), var_dump())
- [ ] Test all CRUD operations
- [ ] Test all security features
- [ ] Performance testing done
- [ ] Load testing done

---

## 📞 Getting Help

1. Check error logs
2. Review documentation
3. Test step by step
4. Use debugging tools
5. Ask community forums

---

**Last Updated:** November 16, 2025

**Developer:** Khairul Adha  
**Email:** r4dioz.88@gmail.com  
**Website:** www.rainbowcodec.com
