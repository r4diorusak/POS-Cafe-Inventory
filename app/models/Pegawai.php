<?php
/**
 * Pegawai Model
 * Menangani data pegawai
 */
class Pegawai extends Model {
    protected $table = 'pegawai';
    
    /**
     * Get all pegawai
     */
    public function getAllPegawai($orderBy = 'id DESC') {
        return $this->getAll($orderBy);
    }
    
    /**
     * Get pegawai by ID
     */
    public function getPegawaiById($id) {
        return $this->getById($id, 'id');
    }
    
    /**
     * Create pegawai
     */
    public function createPegawai($data) {
        return $this->insert($data);
    }
    
    /**
     * Update pegawai
     */
    public function updatePegawai($id, $data) {
        return $this->update($data, 'id', $id);
    }
    
    /**
     * Delete pegawai
     */
    public function deletePegawai($id) {
        return $this->delete('id', $id);
    }
    
    /**
     * Search pegawai by nama
     */
    public function searchByNama($nama) {
        $sql = "SELECT * FROM " . $this->table . " WHERE nama LIKE ? ORDER BY id DESC";
        return $this->db->getRows($sql, ['%' . $nama . '%']);
    }
    
    /**
     * Get pegawai by status
     */
    public function getByStatus($status) {
        return $this->getWhere(['status' => $status]);
    }
}
?>
