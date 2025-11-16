<?php
/**
 * Database Class
 * Menangani koneksi MySQLi dan query dengan prepared statements
 */
class Database {
    private static $instance = null;
    private $connection;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'kedan_db';
    
    private function __construct() {
        $this->connect();
    }
    
    /**
     * Singleton pattern untuk database connection
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Koneksi ke database
     */
    private function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->connection->connect_error) {
            die('Connection failed: ' . $this->connection->connect_error);
        }
        
        // Set charset ke UTF-8
        $this->connection->set_charset('utf8mb4');
    }
    
    /**
     * Get connection
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Execute query dengan prepared statement
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new Exception('Prepare failed: ' . $this->connection->error);
            }
            
            if (!empty($params)) {
                $types = '';
                $values = [];
                
                foreach ($params as $param) {
                    if (is_int($param)) {
                        $types .= 'i';
                    } elseif (is_float($param)) {
                        $types .= 'd';
                    } else {
                        $types .= 's';
                    }
                    $values[] = $param;
                }
                
                $stmt->bind_param($types, ...$values);
            }
            
            if (!$stmt->execute()) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }
            
            return $stmt;
        } catch (Exception $e) {
            error_log('Database Query Error: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get single row result
     */
    public function getRow($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    /**
     * Get all rows result
     */
    public function getRows($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        $result = $stmt->get_result();
        $rows = [];
        
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        
        return $rows;
    }
    
    /**
     * Count rows
     */
    public function countRows($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->num_rows;
    }
    
    /**
     * Get last insert ID
     */
    public function getLastInsertId() {
        return $this->connection->insert_id;
    }
    
    /**
     * Get affected rows
     */
    public function getAffectedRows() {
        return $this->connection->affected_rows;
    }
    
    /**
     * Close connection
     */
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>
