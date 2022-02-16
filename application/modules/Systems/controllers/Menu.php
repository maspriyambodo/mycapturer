<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_menu');
        $this->user = Dekrip($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'data' => $this->M_menu->index()->result(),
            'name_group' => $this->M_menu->name_group(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Systems/Menu/index/',
            'privilege' => $this->bodo->Check_previlege('Systems/Menu/index/'),
            'siteTitle' => 'Menu Management | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Menu Management',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Menu Management',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('menu/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Save() {
        if (Post_input('menu_parent')) {
            $parent = Dekrip(Post_input('menu_parent'));
        } else {
            $parent = "NULL";
        }
        $order = Post_input('order_no');
        if ($order == 'undefined') {
            $new_order = Dekrip(Post_input('gr_menu')) . '00';
        } else {
            $new_order = $order + 1;
        }
        $data = [
            'parent' => $parent,
            'description' => Post_input('desc_txt'),
            'nama_menu' => Post_input('nama_menu'),
            'link_menu' => Post_input('link_menu'),
            'gr_menu' => Dekrip(Post_input('gr_menu')),
            'ico_menu' => Post_input('ico_menu'),
            'order_no' => $new_order,
            'user_login' => $this->user
        ];
        $exec = $this->M_menu->Save($data);
        if ($exec['status'] == false) {
            redirect(base_url('Systems/Menu/index/'), $this->session->set_flashdata('err_msg', $exec['pesan']));
        } else {
            redirect(base_url('Systems/Menu/index/'), $this->session->set_flashdata('succ_msg', 'Menu has been added'));
        }
    }

    public function Delete() {
        $id = Dekrip(Post_input("d_id_menu"));
        $data = [
            'id' => $id,
            'user_login' => $this->user
        ];
        $exec = $this->M_menu->Delete($data);
        if ($exec['status'] == false) {
            redirect(base_url('Systems/Menu/index/'), $this->session->set_flashdata('err_msg', $exec['pesan']));
        } else {
            redirect(base_url('Systems/Menu/index/'), $this->session->set_flashdata('succ_msg', 'Success deleting menu <b>' . $exec['menu_nama'] . '</b>'));
        }
    }

    public function Set_active() {
        $id = Dekrip(Post_input("a_id_menu"));
        $data = [
            'id' => $id,
            'user_login' => $this->user
        ];
        $exec = $this->M_menu->Set_active($data);
        if ($exec['status'] == false) {
            redirect(base_url('Systems/Menu/index/'), $this->session->set_flashdata('err_msg', $exec['pesan']));
        } else {
            redirect(base_url('Systems/Menu/index/'), $this->session->set_flashdata('succ_msg', 'Success activating menu <b>' . $exec['menu_nama'] . '</b>'));
        }
    }

    public function Edit() {
        $id = Dekrip(Post_get("id"));
        $data = [
            'data' => $this->M_menu->Edit($id),
            'menu' => $this->M_menu->index()->result(),
            'name_group' => $this->M_menu->name_group(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Systems/Menu/index/',
            'privilege' => $this->bodo->Check_previlege('Systems/Menu/index/'),
            'siteTitle' => 'Edit Menu | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Menu Management',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Menu Management',
                    'link' => base_url('Systems/Menu/index/'),
                    'status' => false
                ],
                1 => [
                    'nama' => 'Edit',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('menu/edit', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    private function get_groupMenu($id_menu, $gr_menu) {
        $exec = $this->M_menu->groupMenu($id_menu);
        $old_groupmenu = $exec[0]->group_menu;
        $order = $exec[0]->order_no;
        $new_order = $this->M_menu->New_order($gr_menu);
        if ($old_groupmenu == $gr_menu) {
            $result = $order;
        } else {
            if (empty($new_order[0]->order_no) or ($new_order[0]->order_no == 0)) {
                $result = $gr_menu * 100;
            } else {
                $result = $new_order[0]->order_no + 1;
            }
        }
        return $result;
    }

    public function Update() {
        $id_menu = Dekrip(Post_input('id_menu'));
        $nomor_order = $this->get_groupMenu($id_menu, Dekrip(Post_input("gr_menu")));
        $parent = Dekrip(Post_input("menu_parent"));
        if ($parent) {
            $id_parent = $parent;
        } else {
            $id_parent = "NULL";
        }
        $data = [
            'parent' => $id_parent,
            'description' => Post_input('desc_txt'),
            'menu' => Post_input("nama_menu"),
            'location' => Post_input("link_menu"),
            'nomor_order' => $nomor_order,
            'grup' => Dekrip(Post_input("gr_menu")),
            'icon_menu' => Post_input("ico_menu"),
            'user_login' => $this->user,
            'id_menu' => $id_menu
        ];
        $exec = $this->M_menu->Update($data);
        if ($exec['status'] == false) {
            redirect(base_url('Systems/Menu/Edit?id=' . Post_input("id_menu")), $this->session->set_flashdata('err_msg', $exec['pesan']));
        } else {
            redirect(base_url('Systems/Menu/index/'), $this->session->set_flashdata('succ_msg', 'Success update menu <b>' . $exec['menu_nama'] . '</b>'));
        }
    }

    public function Get_order() {
        $role_id = Dekrip(Post_get("id"));
        $exec = $this->M_menu->Get_order($role_id);
        ToJson($exec->result());
    }

    public function Get_detail() {
        $data = [
            'id_menu' => Post_get('id_menu'),
            'group_id' => Post_get('group_id'),
            'order_no' => Post_get('order_no'),
            'menu_parent' => Post_get('menu_parent')
        ];
        $exec = $this->M_menu->Get_detail($data);
        ToJson($exec);
    }

    public function Change_order() {
        $arr = explode(',', Post_input('new_order'));
        $data = [
            'old_id' => Post_input('old_menu_id'),
            'old_order' => Post_input('old_order_no'),
            'new_id' => $arr[0],
            'new_order' => $arr[1]
        ];
        $this->M_menu->Change_order($data);
    }

}
