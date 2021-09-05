<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_menugrup extends CI_Model {

    public function sys_menu_group($data) {
        $exec = $this->db->query('CALL sys_menu_group("' . $data['param'] . '",' . $data['id_grup'] . ',"' . $data['nama_group'] . '","' . $data['deskripsi'] . '",' . $data['order'] . ',' . $data['user_login'] . ');');
        mysqli_next_result($this->db->conn_id);
        return $exec;
    }

    public function Group_dir() {
        $exec = $this->db->select('sys_menu_group.order_no,sys_menu_group.nama')
                ->from('sys_menu_group')
                ->where('`sys_menu_group`.`stat`', 1, false)
                ->where('`sys_menu_group`.`order_no` !=', 999, false)
                ->order_by('sys_menu_group.order_no ASC')
                ->get()
                ->result();
        return $exec;
    }

    public function Get_id($id) {
        $exec = $this->db->select('sys_menu_group.id, sys_menu_group.nama, sys_menu_group.order_no')
                ->from('sys_menu_group')
                ->where('`sys_menu_group`.`order_no` !=', $id, false)
                ->where('`sys_menu_group`.`order_no` !=', 999, false)
                ->where('`sys_menu_group`.`stat` =', 1, false)
                ->get()
                ->result();
        return $exec;
    }

    public function Change_order($data) {
        $exec = $this->db->query('CALL sys_menu_group_reorder(' . $data['old_id'] . ',' . $data['old_order'] . ',' . $data['new_id'] . ',' . $data['new_order'] . ')');
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            log_message('error', APPPATH . 'modules/Systems/models/M_menugrup -> function Change_order ' . 'error ketika swap order number');
            $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('err_msg', 'error while swap order number'));
        } else {
            mysqli_next_result($this->db->conn_id);
            $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('succ_msg', 'success swap number order'));
        }
        return $result;
    }

}
