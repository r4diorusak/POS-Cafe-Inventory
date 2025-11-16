<?php
/**
 * Base Model Class
 * Menyediakan fungsi dasar untuk semua model
 */
class Model {
    protected $db;
    protected $table;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Get all records
     */
    public function getAll($orderBy = null) {
        $sql = "SELECT * FROM " . $this->table;
        
        if ($orderBy) {
            $sql .= " ORDER BY " . $orderBy;
        }
        
        return $this->db->getRows($sql);
    }
    
    /**
     * Get record by ID
     */
    public function getById($id, $idColumn = 'id') {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $idColumn . " = ?";
        return $this->db->getRow($sql, [$id]);
    }
    
    /**
     * Count all records
     */
    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM " . $this->table;
        $result = $this->db->getRow($sql);
        return $result['total'];
    }
    
    /**
     * Insert data
     */
    public function insert($data) {
        $columns = array_keys($data);
        $values = array_values($data);
        $placeholders = implode(',', array_fill(0, count($columns), '?'));
        
        $sql = "INSERT INTO " . $this->table . " (" . implode(',', $columns) . ") VALUES (" . $placeholders . ")";
        
        $this->db->query($sql, $values);
        return $this->db->getLastInsertId();
    }
    
    /**
     * Update data
     */
    public function update($data, $whereColumn, $whereValue) {
        $sets = [];
        $values = [];
        
        foreach ($data as $column => $value) {
            $sets[] = $column . " = ?";
            $values[] = $value;
        }
        
        $values[] = $whereValue;
        
        $sql = "UPDATE " . $this->table . " SET " . implode(',', $sets) . " WHERE " . $whereColumn . " = ?";
        
        $this->db->query($sql, $values);
        return $this->db->getAffectedRows();
    }
    
    /**
     * Delete data
     */
    public function delete($whereColumn, $whereValue) {
        $sql = "DELETE FROM " . $this->table . " WHERE " . $whereColumn . " = ?";
        $this->db->query($sql, [$whereValue]);
        return $this->db->getAffectedRows();
    }
    
    /**
     * Get records with WHERE clause
     */
    public function getWhere($where = [], $orderBy = null) {
        $sql = "SELECT * FROM " . $this->table;
        $values = [];
        
        if (!empty($where)) {
            $whereConditions = [];
            foreach ($where as $column => $value) {
                $whereConditions[] = $column . " = ?";
                $values[] = $value;
            }
            $sql .= " WHERE " . implode(" AND ", $whereConditions);
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY " . $orderBy;
        }
        
        return $this->db->getRows($sql, $values);
    }
    
    /**
     * Count with WHERE clause
     */
    public function countWhere($where = []) {
        $sql = "SELECT COUNT(*) as total FROM " . $this->table;
        $values = [];
        
        if (!empty($where)) {
            $whereConditions = [];
            foreach ($where as $column => $value) {
                $whereConditions[] = $column . " = ?";
                $values[] = $value;
            }
            $sql .= " WHERE " . implode(" AND ", $whereConditions);
        }
        
        $result = $this->db->getRow($sql, $values);
        return $result['total'];
    }
}
?>
