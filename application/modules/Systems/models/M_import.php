<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_import extends CI_Model {
    public function Insert($data) {
        $this->db->insert_batch('test_impor', $data);
    }
}
