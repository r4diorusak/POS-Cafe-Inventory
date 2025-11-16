<?php
/**
 * Invoice Model
 * Menangani data invoice/penjualan
 */
class Invoice extends Model {
    protected $table = 'invoice';
    
    /**
     * Get all invoice
     */
    public function getAllInvoice($orderBy = 'id_invoice DESC') {
        return $this->getAll($orderBy);
    }
    
    /**
     * Get invoice by ID
     */
    public function getInvoiceById($id) {
        return $this->getById($id, 'id_invoice');
    }
    
    /**
     * Create invoice
     */
    public function createInvoice($data) {
        return $this->insert($data);
    }
    
    /**
     * Update invoice
     */
    public function updateInvoice($id, $data) {
        return $this->update($data, 'id_invoice', $id);
    }
    
    /**
     * Delete invoice
     */
    public function deleteInvoice($id) {
        return $this->delete('id_invoice', $id);
    }
    
    /**
     * Get invoice by tanggal
     */
    public function getInvoiceByDate($tanggal) {
        return $this->getWhere(['tanggal_invoice' => $tanggal]);
    }
    
    /**
     * Get invoice by tanggal range
     */
    public function getInvoiceByDateRange($startDate, $endDate) {
        $sql = "SELECT * FROM " . $this->table . " WHERE tanggal_invoice BETWEEN ? AND ? ORDER BY id_invoice DESC";
        return $this->db->getRows($sql, [$startDate, $endDate]);
    }
    
    /**
     * Get invoice hari ini
     */
    public function getTodayInvoice() {
        $today = date('Y-m-d');
        return $this->getInvoiceByDate($today);
    }
    
    /**
     * Get total penjualan by tanggal
     */
    public function getTotalByDate($tanggal) {
        $sql = "SELECT SUM(total) as total FROM " . $this->table . " WHERE tanggal_invoice = ?";
        $result = $this->db->getRow($sql, [$tanggal]);
        return $result['total'] ?? 0;
    }
    
    /**
     * Get total penjualan hari ini
     */
    public function getTotalToday() {
        $today = date('Y-m-d');
        return $this->getTotalByDate($today);
    }
}
?>
