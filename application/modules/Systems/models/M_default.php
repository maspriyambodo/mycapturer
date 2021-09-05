<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_default extends CI_Model {

    public function Sys() {
        $exec = $this->db->query('CALL sys_app_select();')->row();
        mysqli_next_result($this->db->conn_id);
//        print_r($exec->favico);die;
        return $exec;
    }

    public function Menu() {
        if ($this->session->userdata('id_user')) {
            $exec = $this->db->query('CALL sys_menu_select(' . $this->bodo->Dec($this->session->userdata('role_id')) . ');');
            mysqli_next_result($this->db->conn_id);
        } else {
            redirect(base_url('Auth/index/'));
        }
        return $exec;
    }

    public function Group_menu() {
        $exec = $this->db->query('CALL group_menu();')->result();
        foreach ($exec as $key => $value) {
            $item[$key] = $value->link;
        }
        mysqli_next_result($this->db->conn_id);
        return $item;
    }

    public function Roles2($param) {// ini function original
        $exec = $this->db->query('CALL sys_roles_select("' . $param . '");');
        mysqli_next_result($this->db->conn_id);
        return $exec;
    }

    public function Roles($param) {// ini function modifan
        $role_id = $this->bodo->Dec($this->session->userdata('role_id'));
        if (!$role_id or empty($role_id)) {
            $exec = redirect(base_url('Signin'), $this->session->set_flashdata('err_msg', 'you need signin to access the system'));
        } elseif ($param == 0 and $role_id == 1) {
            $exec = $this->db->query('CALL sys_roles_select("' . $param . '");');
            mysqli_next_result($this->db->conn_id);
        } elseif ($param == 0 and $role_id != 1) {
            $exec = $this->db->select()
                    ->from('sys_roles_select')
                    ->where([
                        '`sys_roles_select`.`status_grup`' => 1 + false,
                        '`sys_roles_select`.`parent_id`' => $role_id + false
                    ])
                    ->or_where('`sys_roles_select`.`status_grup`', 1, false)
                    ->where('`sys_roles_select`.`id_grup`', $role_id, false)
                    ->get();
        } else {
            $exec = $this->db->query('CALL sys_roles_select("' . $param . '");');
            mysqli_next_result($this->db->conn_id);
        }
        return $exec;
    }

    public function Permission($id) {
        $exec = $this->db->query('CALL sys_permission_select("' . $id . '");');
        mysqli_next_result($this->db->conn_id);
        return $exec;
    }

}
