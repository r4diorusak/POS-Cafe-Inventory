<?php
/**
 * Invoice Controller
 * Menangani CRUD dan reporting invoice/penjualan
 */
class InvoiceController extends Controller {
    
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    /**
     * List semua invoice
     */
    public function index() {
        $invoiceModel = $this->model('Invoice');
        $data = [
            'invoice' => $invoiceModel->getAllInvoice()
        ];
        
        $this->view('invoice/list', $data);
    }
    
    /**
     * Show detail invoice
     */
    public function show($id) {
        $invoiceModel = $this->model('Invoice');
        $data = [
            'invoice' => $invoiceModel->getInvoiceById($id)
        ];
        
        $this->view('invoice/show', $data);
    }
    
    /**
     * Tampilkan form create
     */
    public function create() {
        $pelangganModel = $this->model('Pelanggan');
        $mejaModel = $this->model('Meja');
        $menuModel = $this->model('Menu');
        
        $data = [
            'pelanggan' => $pelangganModel->getAllPelanggan(),
            'meja' => $mejaModel->getAllMeja(),
            'menu' => $menuModel->getAllMenu()
        ];
        
        $this->view('invoice/create', $data);
    }
    
    /**
     * Simpan invoice baru
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=invoice&action=index');
        }
        
        $data = [
            'id_pelanggan' => antiinjection($_POST['id_pelanggan'] ?? null),
            'id_meja' => antiinjection($_POST['id_meja'] ?? null),
            'tanggal_invoice' => date('Y-m-d'),
            'jam_invoice' => date('H:i:s'),
            'total' => antiinjection($_POST['total'] ?? 0),
            'diskon' => antiinjection($_POST['diskon'] ?? 0),
            'grand_total' => antiinjection($_POST['grand_total'] ?? 0),
            'status' => 'selesai'
        ];
        
        $invoiceModel = $this->model('Invoice');
        $result = $invoiceModel->createInvoice($data);
        
        if ($result) {
            $_SESSION['success'] = 'Invoice berhasil dibuat';
            $_SESSION['invoice_id'] = $result;
            $this->redirect('../index.php?controller=invoice&action=show&id=' . $result);
        } else {
            $_SESSION['error'] = 'Gagal membuat invoice';
            $this->redirect('../index.php?controller=invoice&action=create');
        }
    }
    
    /**
     * Delete invoice
     */
    public function delete($id) {
        $invoiceModel = $this->model('Invoice');
        $result = $invoiceModel->deleteInvoice($id);
        
        if ($result) {
            $_SESSION['success'] = 'Invoice berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus invoice';
        }
        
        $this->redirect('../index.php?controller=invoice&action=index');
    }
    
    /**
     * Get invoice hari ini
     */
    public function today() {
        $invoiceModel = $this->model('Invoice');
        $data = [
            'invoice' => $invoiceModel->getTodayInvoice(),
            'total' => $invoiceModel->getTotalToday()
        ];
        
        $this->view('invoice/today', $data);
    }
    
    /**
     * Get invoice by tanggal
     */
    public function byDate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=invoice&action=index');
        }
        
        $tanggal = antiinjection($_POST['tanggal'] ?? date('Y-m-d'));
        
        $invoiceModel = $this->model('Invoice');
        $data = [
            'invoice' => $invoiceModel->getInvoiceByDate($tanggal),
            'tanggal' => $tanggal,
            'total' => $invoiceModel->getTotalByDate($tanggal)
        ];
        
        $this->view('invoice/bydate', $data);
    }
    
    /**
     * Report invoice by date range
     */
    public function report() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->view('invoice/report');
            return;
        }
        
        $startDate = antiinjection($_POST['start_date'] ?? date('Y-m-d'));
        $endDate = antiinjection($_POST['end_date'] ?? date('Y-m-d'));
        
        $invoiceModel = $this->model('Invoice');
        $invoices = $invoiceModel->getInvoiceByDateRange($startDate, $endDate);
        
        $total = 0;
        foreach ($invoices as $inv) {
            $total += $inv['grand_total'];
        }
        
        $data = [
            'invoice' => $invoices,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total' => $total
        ];
        
        $this->view('invoice/report_result', $data);
    }
}
?>
