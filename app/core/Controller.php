<?php
/**
 * Base Controller Class
 * Menyediakan fungsi dasar untuk semua controller
 */
class Controller {
    protected $model;
    
    /**
     * Load model
     */
    protected function model($modelName) {
        require_once '../app/models/' . $modelName . '.php';
        return new $modelName();
    }
    
    /**
     * Load view
     */
    protected function view($viewName, $data = []) {
        require_once '../app/views/' . $viewName . '.php';
    }
    
    /**
     * Render JSON response
     */
    protected function jsonResponse($status, $message, $data = null) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }
    
    /**
     * Redirect to URL
     */
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Check if user is logged in
     */
    protected function isLoggedIn() {
        return isset($_SESSION['namauser']);
    }
    
    /**
     * Require login
     */
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            $this->redirect('../index.php');
        }
    }
    
    /**
     * Check user level/role
     */
    protected function hasRole($role) {
        return isset($_SESSION['leveluser']) && $_SESSION['leveluser'] == $role;
    }
    
    /**
     * Get logged in user
     */
    protected function getUser() {
        return $_SESSION['namauser'] ?? null;
    }
    
    /**
     * Get user level
     */
    protected function getUserLevel() {
        return $_SESSION['leveluser'] ?? null;
    }
}
?>
