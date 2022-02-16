<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Locked extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Locked');
        $this->user = Dekrip($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'item_active' => 'Systems/Locked/index/',
            'csrf' => $this->bodo->Csrf(),
            'privilege' => $this->bodo->Check_previlege('Systems/Locked/index/'),
            'siteTitle' => 'Account Blocked | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Account Blocked',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Account Blocked',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('locked/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function lists() {
        $list = $this->M_Locked->lists();
        $data = [];
        $no = Post_get("start");
        $privilege = $this->bodo->Check_previlege('Systems/Users/index/');
        foreach ($list as $users) {
            $id_user = Enkrip($users->id);
            if ($privilege['delete'] and $users->stat) {
                $delbtn = '<button id="unlock_user" type="button" class="btn btn-icon btn-success btn-xs" title="Unblock ' . $users->uname . '" value="' . $id_user . '" onclick="Unblocked(this.value)"><i class="fas fa-lock"></i></button>';
            } else {
                $delbtn = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $users->uname;
            $row[] = $users->name;
            $row[] = $users->last_login;
            $row[] = $users->ip_address;
            $row[] = '<div class="btn-group">' . $delbtn . '</div>';
            $data[] = $row;
        }
        return $this->_list($data, $privilege);
    }

    private function _list($data, $privilege) {
        if ($privilege['read']) {
            $output = [
                "draw" => Post_get('draw'),
                "recordsTotal" => $this->M_Locked->count_all(),
                "recordsFiltered" => $this->M_Locked->count_filtered(),
                "data" => $data
            ];
        } else {
            $output = [
                "draw" => Post_get('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        }
        return ToJson($output);
    }

    public function Unlock() {
        $id_user = Dekrip(Post_input('id_user'));
        return $this->M_Locked->Unlock($id_user);
    }

}
