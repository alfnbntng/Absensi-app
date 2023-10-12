<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    function getwhere($table,$data){
        return $this->db->get_where($table,$data);
    }

}
?>