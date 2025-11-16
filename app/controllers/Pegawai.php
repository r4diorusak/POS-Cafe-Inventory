<?php
/**
 * Pegawai Controller
 * Menangani CRUD data pegawai
 */
class PegawaiController extends Controller {
    
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    /**
     * List semua pegawai
     */
    public function index() {
        $pegawaiModel = $this->model('Pegawai');
        $data = [
            'pegawai' => $pegawaiModel->getAllPegawai()
        ];
        
        $this->view('pegawai/list', $data);
    }
    
    /**
     * Tampilkan form create
     */
    public function create() {
        $this->view('pegawai/create');
    }
    
    /**
     * Simpan pegawai baru
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=pegawai&action=index');
        }
        
        $data = [
            'nama' => antiinjection($_POST['nama'] ?? ''),
            'jabatan' => antiinjection($_POST['jabatan'] ?? ''),
            'alamat' => antiinjection($_POST['alamat'] ?? ''),
            'no_telp' => antiinjection($_POST['no_telp'] ?? ''),
            'status' => antiinjection($_POST['status'] ?? 'aktif')
        ];
        
        $pegawaiModel = $this->model('Pegawai');
        $result = $pegawaiModel->createPegawai($data);
        
        if ($result) {
            $_SESSION['success'] = 'Pegawai berhasil ditambahkan';
            $this->redirect('../index.php?controller=pegawai&action=index');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan pegawai';
            $this->redirect('../index.php?controller=pegawai&action=create');
        }
    }
    
    /**
     * Tampilkan form edit
     */
    public function edit($id) {
        $pegawaiModel = $this->model('Pegawai');
        $data = [
            'pegawai' => $pegawaiModel->getPegawaiById($id)
        ];
        
        $this->view('pegawai/edit', $data);
    }
    
    /**
     * Update pegawai
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=pegawai&action=index');
        }
        
        $data = [
            'nama' => antiinjection($_POST['nama'] ?? ''),
            'jabatan' => antiinjection($_POST['jabatan'] ?? ''),
            'alamat' => antiinjection($_POST['alamat'] ?? ''),
            'no_telp' => antiinjection($_POST['no_telp'] ?? ''),
            'status' => antiinjection($_POST['status'] ?? 'aktif')
        ];
        
        $pegawaiModel = $this->model('Pegawai');
        $result = $pegawaiModel->updatePegawai($id, $data);
        
        if ($result) {
            $_SESSION['success'] = 'Pegawai berhasil diupdate';
            $this->redirect('../index.php?controller=pegawai&action=index');
        } else {
            $_SESSION['error'] = 'Gagal mengupdate pegawai';
            $this->redirect('../index.php?controller=pegawai&action=edit&id=' . $id);
        }
    }
    
    /**
     * Delete pegawai
     */
    public function delete($id) {
        $pegawaiModel = $this->model('Pegawai');
        $result = $pegawaiModel->deletePegawai($id);
        
        if ($result) {
            $_SESSION['success'] = 'Pegawai berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus pegawai';
        }
        
        $this->redirect('../index.php?controller=pegawai&action=index');
    }
    
    /**
     * Search pegawai
     */
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=pegawai&action=index');
        }
        
        $keyword = antiinjection($_POST['keyword'] ?? '');
        
        $pegawaiModel = $this->model('Pegawai');
        $data = [
            'pegawai' => $pegawaiModel->searchByNama($keyword),
            'keyword' => $keyword
        ];
        
        $this->view('pegawai/list', $data);
    }
}
?>
