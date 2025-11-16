<?php
/**
 * Home Controller
 * Menangani halaman utama/dashboard
 */
class HomeController extends Controller {
    
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    /**
     * Index/Dashboard
     */
    public function index() {
        $invoiceModel = $this->model('Invoice');
        
        $data = [
            'totalInvoiceHari' => count($invoiceModel->getTodayInvoice()),
            'totalPenjualanHari' => $invoiceModel->getTotalToday(),
            'leveluser' => $this->getUserLevel()
        ];
        
        $this->view('dashboard', $data);
    }
    
    /**
     * Dashboard untuk kasir
     */
    public function kasir() {
        if (!$this->hasRole('kasir') && !$this->hasRole('admin')) {
            $this->redirect('../index.php');
        }
        
        $invoiceModel = $this->model('Invoice');
        $mejaModel = $this->model('Meja');
        
        $data = [
            'totalInvoiceHari' => count($invoiceModel->getTodayInvoice()),
            'totalPenjualanHari' => $invoiceModel->getTotalToday(),
            'mejaAvailable' => count($mejaModel->getByStatus('Kosong')),
            'leveluser' => $this->getUserLevel()
        ];
        
        $this->view('kasir/dashboard', $data);
    }
    
    /**
     * Dashboard untuk waiter
     */
    public function waiter() {
        if (!$this->hasRole('waiter')) {
            $this->redirect('../index.php');
        }
        
        $mejaModel = $this->model('Meja');
        
        $data = [
            'mejaData' => $mejaModel->getAllMeja(),
            'leveluser' => $this->getUserLevel()
        ];
        
        $this->view('waiter/dashboard', $data);
    }
}
?>
