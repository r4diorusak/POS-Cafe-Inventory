<?php
/**
 * Meja Controller
 * Menangani CRUD meja restoran
 */
class MejaController extends Controller {
    
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    /**
     * List semua meja
     */
    public function index() {
        $mejaModel = $this->model('Meja');
        $data = [
            'meja' => $mejaModel->getAllMeja()
        ];
        
        $this->view('meja/list', $data);
    }
    
    /**
     * Tampilkan form create
     */
    public function create() {
        $this->view('meja/create');
    }
    
    /**
     * Simpan meja baru
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=meja&action=index');
        }
        
        $data = [
            'nomor_meja' => antiinjection($_POST['nomor_meja'] ?? ''),
            'kapasitas' => antiinjection($_POST['kapasitas'] ?? 0),
            'status' => 'Kosong'
        ];
        
        $mejaModel = $this->model('Meja');
        $result = $mejaModel->createMeja($data);
        
        if ($result) {
            $_SESSION['success'] = 'Meja berhasil ditambahkan';
            $this->redirect('../index.php?controller=meja&action=index');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan meja';
            $this->redirect('../index.php?controller=meja&action=create');
        }
    }
    
    /**
     * Tampilkan form edit
     */
    public function edit($id) {
        $mejaModel = $this->model('Meja');
        $data = [
            'meja' => $mejaModel->getMejaById($id)
        ];
        
        $this->view('meja/edit', $data);
    }
    
    /**
     * Update meja
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=meja&action=index');
        }
        
        $data = [
            'nomor_meja' => antiinjection($_POST['nomor_meja'] ?? ''),
            'kapasitas' => antiinjection($_POST['kapasitas'] ?? 0),
            'status' => antiinjection($_POST['status'] ?? 'Kosong')
        ];
        
        $mejaModel = $this->model('Meja');
        $result = $mejaModel->updateMeja($id, $data);
        
        if ($result) {
            $_SESSION['success'] = 'Meja berhasil diupdate';
            $this->redirect('../index.php?controller=meja&action=index');
        } else {
            $_SESSION['error'] = 'Gagal mengupdate meja';
            $this->redirect('../index.php?controller=meja&action=edit&id=' . $id);
        }
    }
    
    /**
     * Delete meja
     */
    public function delete($id) {
        $mejaModel = $this->model('Meja');
        $result = $mejaModel->deleteMeja($id);
        
        if ($result) {
            $_SESSION['success'] = 'Meja berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus meja';
        }
        
        $this->redirect('../index.php?controller=meja&action=index');
    }
    
    /**
     * Get meja by status
     */
    public function byStatus() {
        $status = antiinjection($_GET['status'] ?? 'Kosong');
        
        $mejaModel = $this->model('Meja');
        $data = [
            'meja' => $mejaModel->getByStatus($status),
            'status' => $status
        ];
        
        $this->view('meja/list', $data);
    }
}
?>
