<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_group extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['M_menugrup', 'M_menu']);
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'data' => $this->M_menu->name_group(),
            'group_dir' => $this->M_menugrup->Group_dir(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Systems/Menu_group/index/',
            'privilege' => $this->bodo->Check_previlege('Systems/Menu_group/index/'),
            'siteTitle' => 'Group Menu Management | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Group Menu Management',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Menu Group',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('grup_menu/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Check_nama() {
        $nama_grup = Post_get("nama");
        $data = [
            'param' => 'check_nama',
            'id_grup' => 0,
            'nama_group' => $nama_grup,
            'deskripsi' => "null",
            'order' => 0,
            'user_login' => 0
        ];
        $exec = $this->M_menugrup->sys_menu_group($data);
        if ($exec->result()[0]->total >= 0) {
            $result = ['status' => false, 'msg' => 'group name available to use'];
        } else {
            $result = ['status' => true, 'msg' => 'group name already exist'];
        }
        ToJson($result);
    }

    public function Save() {
        $order_no = $this->bodo->Dec(Post_input('order_no'));
        if (empty($order_no)) {
            $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('err_msg', 'error while insert new group'));
        } else {
            $data = [
                'param' => 'insert_baru',
                'id_grup' => 0,
                'nama_group' => Post_input("nama_grup"),
                'deskripsi' => Post_input("des_grup"),
                'order' => $order_no,
                'user_login' => $this->user
            ];
        }
        $exec = $this->M_menugrup->sys_menu_group($data);
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            log_message('error', APPPATH . 'modules/Systems/models/M_menugrup -> function sys_menu_group ' . 'error ketika insert group menu');
            $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('err_msg', 'error while insert new group'));
        } else {
            $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('succ_msg', 'success, new group menu has been added'));
        }
        return $result;
    }

    public function Update() {
        $id_grup = $this->bodo->Dec(Post_input('e_id'));
        if ($id_grup == 1 | $id_grup == 2 | $id_grup == 3) {
            $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('err_msg', '<b>default</b> menu group cannot be updated!'));
        } else {
            $data = [
                'param' => 'edit',
                'id_grup' => $id_grup,
                'nama_group' => Post_input("e_nama_grup"),
                'deskripsi' => Post_input("e_des_grup"),
                'order' => 0,
                'user_login' => $this->user
            ];
            $exec = $this->M_menugrup->sys_menu_group($data);
            if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
                log_message('error', APPPATH . 'modules/Systems/models/M_menugrup -> function sys_menu_group ' . 'error ketika update group menu');
                $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('err_msg', 'error while update new group'));
            } else {
                $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('succ_msg', 'success, new group menu has been updated'));
            }
        }
        return $result;
    }

    public function Edit() {
        $id_grup = $this->bodo->Dec(Post_get("id"));
        $data = [
            'param' => 'get_detail',
            'id_grup' => $id_grup,
            'nama_group' => "null",
            'deskripsi' => "null",
            'order' => 0,
            'user_login' => 0
        ];
        $exec = $this->M_menugrup->sys_menu_group($data)->row();
        if ($exec) {
            $response = ['status' => true, 'exec' => $exec];
        } else {
            $response = ['status' => false, 'msg' => 'error while get data'];
        }
        ToJson($response);
    }

    public function Delete() {
        $id_grup = $this->bodo->Dec(Post_input('d_id'));
        if ($id_grup == 1 | $id_grup == 2 | $id_grup == 3) {
            $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('err_msg', '<b>default</b> menu group cannot be deleted!'));
        } else {
            $data = [
                'param' => 'delete',
                'id_grup' => $id_grup,
                'nama_group' => "null",
                'deskripsi' => "null",
                'order' => 0,
                'user_login' => $this->user
            ];
            $exec = $this->M_menugrup->sys_menu_group($data);
        }
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            log_message('error', APPPATH . 'modules/Systems/models/M_menugrup -> function sys_menu_group ' . 'error ketika delete group menu');
            $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('err_msg', 'error while delete group menu'));
        } else {
            $result = redirect(base_url('Systems/Menu_group/index/'), $this->session->set_flashdata('succ_msg', 'success, group menu has been deleted'));
        }
        return $result;
    }

    public function Get_id() {
        $exec = $this->M_menugrup->Get_id(Post_get('id'));
        ToJson($exec);
    }

    public function Change_order() {
        $arr = explode(',', Post_input('ro_to'));
        $data = [
            'old_id' => Post_input('id_grup'),
            'old_order' => Post_input('from_id'),
            'new_id' => $arr[0],
            'new_order' => $arr[1]
        ];
        $this->M_menugrup->Change_order($data);
    }

}
