<?php
class User_model extends CI_Model {

    public function get_user($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', $password); // Contraseña sin hash
        return $this->db->get('users')->row();
    }

    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }
}

?>
