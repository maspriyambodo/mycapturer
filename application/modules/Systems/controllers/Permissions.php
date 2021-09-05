<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_permision');
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
    }

    private function _Role($data) {
        $exec = $this->M_permision->Role_update($data);
        if ($exec['status'] == false) {
            redirect(base_url('Systems/Permissions/index/'), $this->session->set_flashdata('err_msg', $exec['pesan']));
        } else {
            redirect(base_url('Systems/Permissions/index/'), $this->session->set_flashdata('succ_msg', 'Roles has been updated'));
        }
    }

    public function index() {
        $data = [
            'data' => $this->M_default->Roles(0)->result(),
            'menu' => $this->M_default->Menu()->result(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Systems/Permissions/index/',
            'privilege' => $this->bodo->Check_previlege('Systems/Permissions/index/'),
            'siteTitle' => 'System Permissions | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Permissions',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Permissions',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('permissions/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Role_update() {
        $id = $this->bodo->Dec(Post_input("id_grup_edit"));
        if ($id == 1) {
            redirect(base_url('Systems/Permissions/index/'), $this->session->set_flashdata('err_msg', 'this user cannot be edit'));
        } else {
            $data = [
                'id_grup' => $id,
                'parent_id' => Post_input('gr_parent_edit'),
                'nama_grup' => Post_input("gr_name_edit"),
                'des_grup' => Post_input("gr_desc_edit"),
                'user_login' => $this->user
            ];
        }
        return $this->_Role($data);
    }

    public function Get_role() {
        $id = $this->bodo->Dec(Post_get("id"));
        $exec = $this->M_default->Roles($id)->row();
        if ($exec) {
            $result = [
                'status' => true,
                'value' => $exec
            ];
        } else {
            $result = [
                'status' => false,
                'msg' => 'error while getting data'
            ];
        }
        ToJson($result);
    }

    public function Get_permission() {
        $id = $this->bodo->Dec(Post_get("id"));
        $exec = $this->M_default->Permission($id)->result();
        if ($exec) {
            $result = [
                'status' => true,
                'value' => $exec
            ];
        } else {
            $result = [
                'status' => false,
                'msg' => 'error while getting data'
            ];
        }
        ToJson($result);
    }

    public function Save() {
        if (Post_input('gr_parent_add') === '0') {
            $parent_id = 0;
        } elseif ($this->bodo->Dec(Post_input('gr_parent_add')) === 1) {
            $parent_id = 1;
        } else {
            $parent_id = $this->bodo->Dec(Post_input('gr_parent_add'));
        }
        $data = [
            'name' => Post_input("gr_name_add"),
            'description' => Post_input("gr_des_add"),
            'user_login' => $this->user,
            'parent_id' => $parent_id
        ];
        return $this->_Save($data);
    }

    private function _Save($data) {
        if ($data['parent_id'] == 1) {
            redirect(base_url('Systems/Permissions/index/'), $this->session->set_flashdata('err_msg', 'error while saving role!'));
        } else {
            $this->M_permision->Save($data);
        }
    }

    public function Save_access() {
        $role = $this->bodo->Dec(Post_input("role_id"));
        $data = [
            'role_id' => $role,
            'id_menu' => Post_input("id_menu"),
            'user_login' => $this->user,
            'v' => Post_input('view_menu'),
            'c' => Post_input('create_menu'),
            'r' => Post_input('read_menu'),
            'u' => Post_input('update_menu'),
            'd' => Post_input('delete_menu')
        ];
        $exec = $this->M_permision->Save_access($data);
        if ($exec['status'] == true) {
            redirect(base_url('Systems/Permissions/index/'), $this->session->set_flashdata('succ_msg', $exec['pesan']));
        } else {
            redirect(base_url('Systems/Permissions/index/'), $this->session->set_flashdata('err_msg', $exec['pesan']));
        }
    }

    public function Delete() {
        $id = $this->bodo->Dec(Post_input('id_grup'));
        if ($id == 1) {
            redirect(base_url('Systems/Permissions/index/'), $this->session->set_flashdata('err_msg', 'you cannot proceed with this request'));
        } else {
            $data = [
                'id' => $id,
                'id_user' => $this->user
            ];
            $this->M_permision->Delete($data);
        }
    }

}
