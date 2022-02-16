<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Model {

    public function index() {
        $exec = $this->db->query('CALL sys_menu_dir();');
        mysqli_next_result($this->db->conn_id);
        return $exec;
    }

    public function name_group() {
        $exec = $this->db->query('CALL sys_menu_group_select();')->result();
        mysqli_next_result($this->db->conn_id);
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

    public function Save($data) {
        $exec = $this->db->query('CALL sys_menu_insert(' . $data['parent'] . ',"' . $data['nama_menu'] . '","' . $data['link_menu'] . '",' . $data['order_no'] . ',' . $data['gr_menu'] . ',"' . $data['ico_menu'] . '","' . $data['description'] . '",' . $data['user_login'] . ');');
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            log_message('error', APPPATH . 'modules/Systems/models/M_menu -> function Save ' . 'error ketika insert_menu');
            $result = [
                'status' => false,
                'pesan' => 'error while saving new menu!'
            ];
        } else {
            mysqli_next_result($this->db->conn_id);
            $result['status'] = true;
        }
        return $result;
    }

    public function Delete($data) {
        $exec = $this->db->query('CALL sys_menu_delete(' . $data['id'] . ',' . $data['user_login'] . ');');
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            log_message('error', APPPATH . 'modules/Systems/models/M_menu -> function Save ' . 'error ketika insert_menu');
            $result = [
                'status' => false,
                'pesan' => 'error while delete menu!'
            ];
        } else {
            mysqli_next_result($this->db->conn_id);
            $result['status'] = true;
            $result['menu_nama'] = $exec->row()->menu_nama;
        }
        return $result;
    }

    public function Edit($id) {
        $exec = $this->db->select()
                ->from('sys_menu_select')
                ->where([
                    '`sys_menu_select`.`id_menu`' => $id + false,
                ])
                ->get()
                ->result();
        return $exec;
    }

    public function Update($data) {
        $exec = $this->db->query('CALL sys_menu_update(' . $data['parent'] . ',"' . $data['menu'] . '","' . $data['location'] . '",' . $data['nomor_order'] . ',' . $data['grup'] . ',"' . $data['icon_menu'] . '",' . $data['user_login'] . ',' . $data['id_menu'] . ',"' . $data['description'] . '",@menu_nama);');
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            log_message('error', APPPATH . 'modules/Systems/models/M_menu -> function Update ' . 'error ketika update_menu');
            $result = [
                'status' => false,
                'pesan' => 'error while update menu!'
            ];
        } else {
            mysqli_next_result($this->db->conn_id);
            $result['status'] = true;
            $result['menu_nama'] = $exec->row()->menu_nama;
        }
        return $result;
    }

    public function Set_active($data) {
        $exec = $this->db->query('CALL sys_menu_active(' . $data['id'] . ',' . $data['user_login'] . ');');
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            log_message('error', APPPATH . 'modules/Systems/models/M_menu -> function Save ' . 'error ketika insert_menu');
            $result = [
                'status' => false,
                'pesan' => 'error while activating menu!'
            ];
        } else {
            mysqli_next_result($this->db->conn_id);
            $result['status'] = true;
            $result['menu_nama'] = $exec->row()->menu_nama;
        }
        return $result;
    }

    public function Get_order($param) {
        $role_id = $this->bodo->Dec($this->session->userdata('role_id'));
        $exec = $this->db->query('CALL sys_menu_getorder(' . $role_id . ',' . $param . ');');
        mysqli_next_result($this->db->conn_id);
        return $exec;
    }

    public function Get_detail($data) {
        if (empty($data['menu_parent'])) {
            $menu_parent = '`sys_menu`.`menu_parent` IS NULL';
        } else {
            $menu_parent = ['`sys_menu`.`menu_parent`' => $data['menu_parent'] + false];
        }
        $exec = $this->db->select('sys_menu.id,sys_menu.nama,sys_menu.order_no,sys_menu.group_menu,sys_menu.stat ')
                ->from('sys_menu')
                ->where('`sys_menu`.`group_menu`', $data['group_id'], false)
                ->where('`sys_menu`.`stat`', 1, false)
                ->where('`sys_menu`.`id` !=', $data['id_menu'], false)
                ->where($menu_parent)
                ->get()
                ->result();
        return $exec;
    }

    public function Change_order($data) {
        $exec = $this->db->query('CALL sys_menu_order(' . $data['old_id'] . ',' . $data['old_order'] . ',' . $data['new_id'] . ',' . $data['new_order'] . ')');
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            log_message('error', APPPATH . 'modules/Systems/models/M_menu -> function Change_order ' . 'error ketika swap order number');
            $result = redirect(base_url('Systems/Menu/index/'), $this->session->set_flashdata('err_msg', 'error while swap order number'));
        } else {
            mysqli_next_result($this->db->conn_id);
            $result = redirect(base_url('Systems/Menu/index/'), $this->session->set_flashdata('succ_msg', 'success swap number order'));
        }
        return $result;
    }

    public function groupMenu($id_menu) {
        $exec = $this->db->select('group_menu,order_no')
                ->from('sys_menu')
                ->where('`sys_menu`.`id`', $id_menu, false)
                ->limit(1)
                ->get()
                ->result();
        return $exec;
    }

    public function New_order($param) {
        $exec = $this->db->select('Max( sys_menu.order_no ) AS order_no')
                ->from('sys_menu')
                ->where('`sys_menu`.`group_menu`', $param, false)
                ->get()
                ->result();
        log_message('error', $this->db->last_query());
        return $exec;
    }

}
