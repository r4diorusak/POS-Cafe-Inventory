<?php
/**
 * Kategori Controller
 * Menangani CRUD kategori menu
 */
class KategoriController extends Controller {
    
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    /**
     * List semua kategori
     */
    public function index() {
        $kategoriModel = $this->model('Kategori');
        $data = [
            'kategori' => $kategoriModel->getAllKategori()
        ];
        
        $this->view('kategori/list', $data);
    }
    
    /**
     * Tampilkan form create
     */
    public function create() {
        $this->view('kategori/create');
    }
    
    /**
     * Simpan kategori baru
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=kategori&action=index');
        }
        
        $data = [
            'nama_kategori' => antiinjection($_POST['nama_kategori'] ?? ''),
            'deskripsi' => antiinjection($_POST['deskripsi'] ?? '')
        ];
        
        $kategoriModel = $this->model('Kategori');
        $result = $kategoriModel->createKategori($data);
        
        if ($result) {
            $_SESSION['success'] = 'Kategori berhasil ditambahkan';
            $this->redirect('../index.php?controller=kategori&action=index');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan kategori';
            $this->redirect('../index.php?controller=kategori&action=create');
        }
    }
    
    /**
     * Tampilkan form edit
     */
    public function edit($id) {
        $kategoriModel = $this->model('Kategori');
        $data = [
            'kategori' => $kategoriModel->getKategoriById($id)
        ];
        
        $this->view('kategori/edit', $data);
    }
    
    /**
     * Update kategori
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=kategori&action=index');
        }
        
        $data = [
            'nama_kategori' => antiinjection($_POST['nama_kategori'] ?? ''),
            'deskripsi' => antiinjection($_POST['deskripsi'] ?? '')
        ];
        
        $kategoriModel = $this->model('Kategori');
        $result = $kategoriModel->updateKategori($id, $data);
        
        if ($result) {
            $_SESSION['success'] = 'Kategori berhasil diupdate';
            $this->redirect('../index.php?controller=kategori&action=index');
        } else {
            $_SESSION['error'] = 'Gagal mengupdate kategori';
            $this->redirect('../index.php?controller=kategori&action=edit&id=' . $id);
        }
    }
    
    /**
     * Delete kategori
     */
    public function delete($id) {
        $kategoriModel = $this->model('Kategori');
        $result = $kategoriModel->deleteKategori($id);
        
        if ($result) {
            $_SESSION['success'] = 'Kategori berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus kategori';
        }
        
        $this->redirect('../index.php?controller=kategori&action=index');
    }
}
?>
