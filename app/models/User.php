<?php
/**
 * User Model
 * Menangani data user/admin
 */
class User extends Model {
    protected $table = 'admin';
    
    /**
     * Find user by username dan password
     */
    public function findByCredentials($username, $password) {
        $hashedPassword = md5($password);
        $sql = "SELECT * FROM " . $this->table . " WHERE username = ? AND password = ?";
        return $this->db->getRow($sql, [$username, $hashedPassword]);
    }
    
    /**
     * Find user by username
     */
    public function findByUsername($username) {
        $sql = "SELECT * FROM " . $this->table . " WHERE username = ?";
        return $this->db->getRow($sql, [$username]);
    }
    
    /**
     * Get all users
     */
    public function getAllUsers() {
        return $this->getAll('id DESC');
    }
    
    /**
     * Create user baru
     */
    public function createUser($data) {
        $data['password'] = md5($data['password']);
        return $this->insert($data);
    }
    
    /**
     * Update password user
     */
    public function updatePassword($userId, $newPassword) {
        $hashedPassword = md5($newPassword);
        return $this->update(['password' => $hashedPassword], 'id', $userId);
    }
    
    /**
     * Check apakah username sudah ada
     */
    public function usernameExists($username) {
        $sql = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE username = ?";
        $result = $this->db->getRow($sql, [$username]);
        return $result['total'] > 0;
    }
}
?>
