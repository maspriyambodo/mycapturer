<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Wilayah extends CI_Model {

    public function Provinsi($data) {
        $exec = $this->db->query('CALL mt_will_prov("' . $data['param'] . '",' . $data['prov_id'] . ',"' . $data['nama_prov'] . '",' . $data['lat'] . ',' . $data['ltd'] . ',' . $data['user_login'] . ');');
        mysqli_next_result($this->db->conn_id);
        return $exec;
    }
    
}
