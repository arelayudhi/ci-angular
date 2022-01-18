<?php
class Upload extends CI_Model {
    public function tambah($table,$data)
    {
        return $this->db->insert($table,$data);
    }
}