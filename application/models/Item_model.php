<?php
class Item_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_items() {
        $query = $this->db->get('items');
        return $query->result_array();
    }

    public function get_item($id) {
        $query = $this->db->get_where('items', array('id' => $id));
        return $query->row_array();
    }

    public function create_item($data) {
        return $this->db->insert('items', $data);
    }

    public function update_item($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('items', $data);
    }

    public function delete_item($id) {
        $this->db->where('id', $id);
        return $this->db->delete('items');
    }
}
