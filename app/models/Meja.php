<?php
/**
 * Meja Model
 * Menangani data meja restoran
 */
class Meja extends Model {
    protected $table = 'meja';
    
    /**
     * Get all meja
     */
    public function getAllMeja($orderBy = 'id_meja DESC') {
        return $this->getAll($orderBy);
    }
    
    /**
     * Get meja by ID
     */
    public function getMejaById($id) {
        return $this->getById($id, 'id_meja');
    }
    
    /**
     * Create meja
     */
    public function createMeja($data) {
        return $this->insert($data);
    }
    
    /**
     * Update meja
     */
    public function updateMeja($id, $data) {
        return $this->update($data, 'id_meja', $id);
    }
    
    /**
     * Delete meja
     */
    public function deleteMeja($id) {
        return $this->delete('id_meja', $id);
    }
    
    /**
     * Get meja by status
     */
    public function getByStatus($status) {
        return $this->getWhere(['status' => $status]);
    }
}
?>
