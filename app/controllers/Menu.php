<?php
/**
 * Menu Controller
 * Menangani CRUD data menu/produk
 */
class MenuController extends Controller {
    
    public function __construct() {
        session_start();
        $this->requireLogin();
    }
    
    /**
     * List semua menu
     */
    public function index() {
        $menuModel = $this->model('Menu');
        $data = [
            'menu' => $menuModel->getAllMenu()
        ];
        
        $this->view('menu/list', $data);
    }
    
    /**
     * Tampilkan form create
     */
    public function create() {
        $kategoriModel = $this->model('Kategori');
        $data = [
            'kategori' => $kategoriModel->getAllKategori()
        ];
        
        $this->view('menu/create', $data);
    }
    
    /**
     * Simpan menu baru
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=menu&action=index');
        }
        
        $data = [
            'nama_menu' => antiinjection($_POST['nama_menu'] ?? ''),
            'id_kategori' => antiinjection($_POST['id_kategori'] ?? ''),
            'harga' => antiinjection($_POST['harga'] ?? ''),
            'deskripsi' => antiinjection($_POST['deskripsi'] ?? ''),
            'status' => antiinjection($_POST['status'] ?? 'aktif')
        ];
        
        $menuModel = $this->model('Menu');
        $result = $menuModel->createMenu($data);
        
        if ($result) {
            $_SESSION['success'] = 'Menu berhasil ditambahkan';
            $this->redirect('../index.php?controller=menu&action=index');
        } else {
            $_SESSION['error'] = 'Gagal menambahkan menu';
            $this->redirect('../index.php?controller=menu&action=create');
        }
    }
    
    /**
     * Tampilkan form edit
     */
    public function edit($id) {
        $menuModel = $this->model('Menu');
        $kategoriModel = $this->model('Kategori');
        
        $data = [
            'menu' => $menuModel->getMenuById($id),
            'kategori' => $kategoriModel->getAllKategori()
        ];
        
        $this->view('menu/edit', $data);
    }
    
    /**
     * Update menu
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=menu&action=index');
        }
        
        $data = [
            'nama_menu' => antiinjection($_POST['nama_menu'] ?? ''),
            'id_kategori' => antiinjection($_POST['id_kategori'] ?? ''),
            'harga' => antiinjection($_POST['harga'] ?? ''),
            'deskripsi' => antiinjection($_POST['deskripsi'] ?? ''),
            'status' => antiinjection($_POST['status'] ?? 'aktif')
        ];
        
        $menuModel = $this->model('Menu');
        $result = $menuModel->updateMenu($id, $data);
        
        if ($result) {
            $_SESSION['success'] = 'Menu berhasil diupdate';
            $this->redirect('../index.php?controller=menu&action=index');
        } else {
            $_SESSION['error'] = 'Gagal mengupdate menu';
            $this->redirect('../index.php?controller=menu&action=edit&id=' . $id);
        }
    }
    
    /**
     * Delete menu
     */
    public function delete($id) {
        $menuModel = $this->model('Menu');
        $result = $menuModel->deleteMenu($id);
        
        if ($result) {
            $_SESSION['success'] = 'Menu berhasil dihapus';
        } else {
            $_SESSION['error'] = 'Gagal menghapus menu';
        }
        
        $this->redirect('../index.php?controller=menu&action=index');
    }
    
    /**
     * Search menu
     */
    public function search() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('../index.php?controller=menu&action=index');
        }
        
        $keyword = antiinjection($_POST['keyword'] ?? '');
        
        $menuModel = $this->model('Menu');
        $data = [
            'menu' => $menuModel->searchByNama($keyword),
            'keyword' => $keyword
        ];
        
        $this->view('menu/list', $data);
    }
}
?>
