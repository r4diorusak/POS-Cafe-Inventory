<?php
/**
 * Helper Functions
 * Fungsi-fungsi utility untuk aplikasi
 */

/**
 * Convert tanggal ke format Indonesia
 */
function tgl_indo($tanggal) {
    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    
    $split = explode('-', $tanggal);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

/**
 * Format rupiah
 */
function format_rupiah($nominal) {
    return 'Rp ' . number_format($nominal, 0, ',', '.');
}

/**
 * Anti injection
 */
function antiinjection($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Generate slug dari string
 */
function generate_slug($str) {
    $str = strtolower(trim($str));
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', '-', $str);
    return trim($str, '-');
}

/**
 * Check apakah string adalah email valid
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Truncate string dengan ellipsis
 */
function truncate($str, $length = 50) {
    if (strlen($str) > $length) {
        return substr($str, 0, $length) . '...';
    }
    return $str;
}

/**
 * Alert message
 */
function alert($message, $type = 'info') {
    $alertClass = [
        'info' => 'alert-info',
        'success' => 'alert-success',
        'warning' => 'alert-warning',
        'danger' => 'alert-danger'
    ];
    
    $class = $alertClass[$type] ?? 'alert-info';
    echo "<div class='alert {$class}' role='alert'>{$message}</div>";
}

/**
 * Check apakah form method POST
 */
function isPost() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Check apakah form method GET
 */
function isGet() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Get POST data dengan default value
 */
function getPost($key, $default = '') {
    return $_POST[$key] ?? $default;
}

/**
 * Get GET data dengan default value
 */
function getGet($key, $default = '') {
    return $_GET[$key] ?? $default;
}

/**
 * Redirect ke URL
 */
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

/**
 * Dump variable (untuk debugging)
 */
function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    exit;
}

/**
 * Get current URL
 */
function currentUrl() {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Get base URL
 */
function baseUrl() {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    return $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
}
?>
