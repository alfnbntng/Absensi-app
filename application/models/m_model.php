<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    function getwhere($table,$data){
        return $this->db->get_where($table,$data);
    }
    public function userExists($field, $value) {
        // Memeriksa apakah nilai yang diberikan sudah ada dalam kolom tertentu (misalnya, email atau username)
        $this->db->where($field, $value);
        $query = $this->db->get('user'); // Gantilah 'user' dengan nama tabel yang sesuai
        return $query->num_rows() > 0;
    }

}
?>