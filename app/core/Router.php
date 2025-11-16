<?php
/**
 * Router Class
 * Menangani routing aplikasi
 */
class Router {
    private $request;
    private $controller;
    private $method;
    private $params;
    
    public function __construct() {
        $this->parseRequest();
    }
    
    /**
     * Parse request dari URL
     */
    private function parseRequest() {
        // Default values
        $this->controller = 'Home';
        $this->method = 'index';
        $this->params = [];
        
        // Parse URL
        if (isset($_GET['controller'])) {
            $this->controller = ucfirst(strtolower($_GET['controller']));
        }
        
        if (isset($_GET['action'])) {
            $this->method = strtolower($_GET['action']);
        }
        
        // Additional parameters
        if (isset($_GET['id'])) {
            $this->params[] = $_GET['id'];
        }
    }
    
    /**
     * Route request ke controller
     */
    public function route() {
        $controllerPath = '../app/controllers/' . $this->controller . '.php';
        
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            
            $controllerClass = $this->controller . 'Controller';
            
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                
                if (method_exists($controller, $this->method)) {
                    if (!empty($this->params)) {
                        call_user_func_array([$controller, $this->method], $this->params);
                    } else {
                        $controller->{$this->method}();
                    }
                } else {
                    die("Method '{$this->method}' not found in {$controllerClass}");
                }
            } else {
                die("Class '{$controllerClass}' not found");
            }
        } else {
            die("Controller '{$this->controller}' not found");
        }
    }
    
    /**
     * Get controller name
     */
    public function getController() {
        return $this->controller;
    }
    
    /**
     * Get method name
     */
    public function getMethod() {
        return $this->method;
    }
}
?>
