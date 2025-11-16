<?php
/**
 * Environment Configuration
 * File ini bisa dijadikan template untuk berbagai environment
 * Sesuaikan nilai-nilainya dengan environment Anda
 */

// ============================================
// ENVIRONMENT SETUP
// ============================================

// Development (0 = Production, 1 = Development)
define('DEVELOPMENT_MODE', 1);

// Error reporting
if (DEVELOPMENT_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// ============================================
// DATABASE CONFIGURATION
// ============================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'kedan_db');
define('DB_CHARSET', 'utf8mb4');

// ============================================
// APPLICATION CONFIGURATION
// ============================================

// Base URL (sesuaikan dengan URL aplikasi Anda)
define('BASE_URL', 'http://localhost/POS-Cafe-Inventory/public/');

// App name
define('APP_NAME', 'POS Cafe Inventory');
define('APP_VERSION', '1.0.0');

// Default timezone
date_default_timezone_set('Asia/Jakarta');

// ============================================
// SESSION CONFIGURATION
// ============================================

// Session timeout (dalam detik, default: 30 menit)
define('SESSION_TIMEOUT', 1800);

// Session cookie name
define('SESSION_NAME', 'pos_cafe_session');

// ============================================
// PAGINATION
// ============================================

// Items per page
define('ITEMS_PER_PAGE', 10);

// ============================================
// FILE UPLOAD
// ============================================

// Upload directory
define('UPLOAD_DIR', '../uploads/');

// Max file size (dalam bytes, default: 5MB)
define('MAX_FILE_SIZE', 5242880);

// Allowed extensions
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'pdf']);

// ============================================
// EMAIL CONFIGURATION (optional)
// ============================================

define('MAIL_FROM', 'noreply@pos-cafe.local');
define('MAIL_FROM_NAME', 'POS Cafe Inventory');

// ============================================
// SECURITY
// ============================================

// Enable HTTPS
define('FORCE_HTTPS', false); // Change to true in production

// CORS settings
define('ALLOWED_ORIGINS', ['http://localhost', 'http://localhost:8000']);

// ============================================
// LOGGING
// ============================================

define('LOG_DIR', '../logs/');
define('LOG_LEVEL', DEVELOPMENT_MODE ? 'DEBUG' : 'ERROR');

// ============================================
// PASSWORD HASHING (Future upgrade from MD5)
// ============================================

// Algorithm: 'md5', 'sha256', or 'bcrypt'
define('PASSWORD_ALGORITHM', 'md5'); // TODO: Change to 'bcrypt' in production

// Bcrypt cost (hanya jika algoritma adalah bcrypt)
define('BCRYPT_COST', 10);

// ============================================
// CUSTOM CONSTANTS
// ============================================

// User roles
define('ROLE_ADMIN', 'admin');
define('ROLE_KASIR', 'kasir');
define('ROLE_WAITER', 'waiter');

// Invoice status
define('INVOICE_STATUS_PENDING', 'pending');
define('INVOICE_STATUS_COMPLETED', 'selesai');
define('INVOICE_STATUS_CANCELLED', 'batal');

// Menu status
define('MENU_STATUS_ACTIVE', 'aktif');
define('MENU_STATUS_INACTIVE', 'tidak aktif');

// Table status
define('TABLE_STATUS_AVAILABLE', 'Kosong');
define('TABLE_STATUS_OCCUPIED', 'Terisi');

?>
