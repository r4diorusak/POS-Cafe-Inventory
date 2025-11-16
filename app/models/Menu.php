<?php
/**
 * Menu Model
 * Menangani data menu/produk
 */
class Menu extends Model {
    protected $table = 'menu';
    
    /**
     * Get all menu
     */
    public function getAllMenu($orderBy = 'id_menu DESC') {
        return $this->getAll($orderBy);
    }
    
    /**
     * Get menu by ID
     */
    public function getMenuById($id) {
        return $this->getById($id, 'id_menu');
    }
    
    /**
     * Create menu
     */
    public function createMenu($data) {
        return $this->insert($data);
    }
    
    /**
     * Update menu
     */
    public function updateMenu($id, $data) {
        return $this->update($data, 'id_menu', $id);
    }
    
    /**
     * Delete menu
     */
    public function deleteMenu($id) {
        return $this->delete('id_menu', $id);
    }
    
    /**
     * Get menu by kategori
     */
    public function getByKategori($idKategori) {
        return $this->getWhere(['id_kategori' => $idKategori]);
    }
    
    /**
     * Search menu by nama
     */
    public function searchByNama($nama) {
        $sql = "SELECT * FROM " . $this->table . " WHERE nama_menu LIKE ? ORDER BY id_menu DESC";
        return $this->db->getRows($sql, ['%' . $nama . '%']);
    }
    
    /**
     * Get menu by status
     */
    public function getByStatus($status) {
        return $this->getWhere(['status' => $status]);
    }
}
?>
