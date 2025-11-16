<?php
/**
 * Kategori Model
 * Menangani data kategori menu
 */
class Kategori extends Model {
    protected $table = 'kategori';
    
    /**
     * Get all kategori
     */
    public function getAllKategori($orderBy = 'id_kategori DESC') {
        return $this->getAll($orderBy);
    }
    
    /**
     * Get kategori by ID
     */
    public function getKategoriById($id) {
        return $this->getById($id, 'id_kategori');
    }
    
    /**
     * Create kategori
     */
    public function createKategori($data) {
        return $this->insert($data);
    }
    
    /**
     * Update kategori
     */
    public function updateKategori($id, $data) {
        return $this->update($data, 'id_kategori', $id);
    }
    
    /**
     * Delete kategori
     */
    public function deleteKategori($id) {
        return $this->delete('id_kategori', $id);
    }
    
    /**
     * Search kategori by nama
     */
    public function searchByNama($nama) {
        $sql = "SELECT * FROM " . $this->table . " WHERE nama_kategori LIKE ? ORDER BY id_kategori DESC";
        return $this->db->getRows($sql, ['%' . $nama . '%']);
    }
}
?>
