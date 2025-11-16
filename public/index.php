<?php
/**
 * Front Controller
 * Entry point aplikasi
 */

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path
define('BASE_PATH', dirname(__FILE__));
define('APP_PATH', BASE_PATH . '/app');

// Auto loader
spl_autoload_register(function($class) {
    // Check di core folder
    $corePath = APP_PATH . '/core/' . $class . '.php';
    if (file_exists($corePath)) {
        require_once $corePath;
        return;
    }
    
    // Check di models folder
    $modelPath = APP_PATH . '/models/' . $class . '.php';
    if (file_exists($modelPath)) {
        require_once $modelPath;
        return;
    }
    
    // Check di controllers folder
    $controllerPath = APP_PATH . '/controllers/' . $class . '.php';
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
        return;
    }
});

// Load core classes
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/Router.php';
require_once APP_PATH . '/core/helpers.php';

// Start session
session_start();

// Route request
$router = new Router();
$router->route();
?>
