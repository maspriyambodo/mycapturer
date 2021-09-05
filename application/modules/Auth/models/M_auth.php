<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    public function Signin($data) {
        $exec = $this->db->query('CALL sys_auth("' . $data['uname'] . '");')->row();
        mysqli_next_result($this->db->conn_id);
        return $exec;
    }

    public function Penalty($data) {
        $this->db->trans_begin();
        $this->db->set([
                    'sys_users.login_attempt' => $data['attempt'],
                    'sys_users.ip_address' => $this->input->ip_address(),
                    'sys_users.last_login' => date('Y-m-d H:i:s')
                ])
                ->where('sys_users.uname', $data['uname'])
                ->update('sys_users');
        if ($this->db->trans_status() === false) {
            $result = $this->db->trans_rollback();
        } else {
            $result = $this->db->trans_commit();
        }
        return $result;
    }

    public function Remove_penalty($data) {
        $this->db->trans_begin();
        $this->db->set([
                    '`sys_users`.`login_attempt`' => 0 + false,
                    'sys_users.ip_address' => $this->input->ip_address(),
                    'sys_users.last_login' => date('Y-m-d H:i:s')
                ])
                ->where('sys_users.uname', $data['uname'])
                ->update('sys_users');
        if ($this->db->trans_status() === false) {
            $result = $this->db->trans_rollback();
        } else {
            $result = $this->db->trans_commit();
        }
        return $result;
    }

}
