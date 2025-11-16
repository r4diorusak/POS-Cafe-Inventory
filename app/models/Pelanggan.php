<?php
/**
 * Pelanggan Model
 * Menangani data pelanggan
 */
class Pelanggan extends Model {
    protected $table = 'pelanggan';
    
    /**
     * Get all pelanggan
     */
    public function getAllPelanggan($orderBy = 'id_pelanggan DESC') {
        return $this->getAll($orderBy);
    }
    
    /**
     * Get pelanggan by ID
     */
    public function getPelangganById($id) {
        return $this->getById($id, 'id_pelanggan');
    }
    
    /**
     * Create pelanggan
     */
    public function createPelanggan($data) {
        return $this->insert($data);
    }
    
    /**
     * Update pelanggan
     */
    public function updatePelanggan($id, $data) {
        return $this->update($data, 'id_pelanggan', $id);
    }
    
    /**
     * Delete pelanggan
     */
    public function deletePelanggan($id) {
        return $this->delete('id_pelanggan', $id);
    }
    
    /**
     * Search pelanggan by nama
     */
    public function searchByNama($nama) {
        $sql = "SELECT * FROM " . $this->table . " WHERE nama_lengkap LIKE ? ORDER BY id_pelanggan DESC";
        return $this->db->getRows($sql, ['%' . $nama . '%']);
    }
    
    /**
     * Get pelanggan by nomor telepon
     */
    public function getByNoTelepon($noTelepon) {
        return $this->getWhere(['no_telp' => $noTelepon]);
    }
}
?>
