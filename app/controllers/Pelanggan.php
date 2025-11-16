<?php
/**
 * Pelanggan Controller
 * Menangani CRUD data pelanggan
 */
class PelangganController extends Controller {
    
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    /**
     * List semua pelanggan
     */
    public function index() {
        $pelangganModel = $this->model('Pelanggan');
        $data = [
            'pelanggan' => $pelangganModel->getAllPelanggan()
        ];
        
        $this->view('pelanggan/list', $data);
    }
    
    /**
     * Tampilkan form create
     */
    public function create() {
        $this->view('pelanggan/create');
    }
    
    /**
     * Simpan pelanggan baru
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=pelanggan&action=index');
        }
        
        $data = [
            'nama_lengkap' => antiinjection($_POST['nama'] ?? ''),
            'alamat' => antiinjection($_POST['alamat'] ?? ''),
            'no_telp' => antiinjection($_POST['telepon'] ?? '')
        ];
        
        $pelangganModel = $this->model('Pelanggan');
        $result = $pelangganModel->createPelanggan($data);
        
        if ($result) {
            $_SESSION['success'] = 'Pelanggan berhasil ditambahkan';
            $this->redirect('../index.php?controller=pelanggan&action=index');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan pelanggan';
            $this->redirect('../index.php?controller=pelanggan&action=create');
        }
    }
    
    /**
     * Tampilkan form edit
     */
    public function edit($id) {
        $pelangganModel = $this->model('Pelanggan');
        $data = [
            'pelanggan' => $pelangganModel->getPelangganById($id)
        ];
        
        $this->view('pelanggan/edit', $data);
    }
    
    /**
     * Update pelanggan
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=pelanggan&action=index');
        }
        
        $data = [
            'nama_lengkap' => antiinjection($_POST['nama'] ?? ''),
            'alamat' => antiinjection($_POST['alamat'] ?? ''),
            'no_telp' => antiinjection($_POST['telepon'] ?? '')
        ];
        
        $pelangganModel = $this->model('Pelanggan');
        $result = $pelangganModel->updatePelanggan($id, $data);
        
        if ($result) {
            $_SESSION['success'] = 'Pelanggan berhasil diupdate';
            $this->redirect('../index.php?controller=pelanggan&action=index');
        } else {
            $_SESSION['error'] = 'Gagal mengupdate pelanggan';
            $this->redirect('../index.php?controller=pelanggan&action=edit&id=' . $id);
        }
    }
    
    /**
     * Delete pelanggan
     */
    public function delete($id) {
        $pelangganModel = $this->model('Pelanggan');
        $result = $pelangganModel->deletePelanggan($id);
        
        if ($result) {
            $_SESSION['success'] = 'Pelanggan berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus pelanggan';
        }
        
        $this->redirect('../index.php?controller=pelanggan&action=index');
    }
    
    /**
     * Search pelanggan
     */
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=pelanggan&action=index');
        }
        
        $keyword = antiinjection($_POST['keyword'] ?? '');
        
        $pelangganModel = $this->model('Pelanggan');
        $data = [
            'pelanggan' => $pelangganModel->searchByNama($keyword),
            'keyword' => $keyword
        ];
        
        $this->view('pelanggan/list', $data);
    }
}
?>
