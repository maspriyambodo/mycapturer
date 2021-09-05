<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_country', 'model');
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
    }

    public function lists() {
        $list = $this->model->lists();
        $data = [];
        $no = Post_input("start");
        $privilege = $this->bodo->Check_previlege('Master/Country/index/');
        foreach ($list as $value) {
            $id = Enkrip($value->id_country);
            if ($value->flags) {
                $flags = '<img src="' . base_url("assets/images/systems/flags/" . $value->flags) . '" width="25" alt="flag ' . $value->nama_country . '"/>';
            } else {
                $flags = null;
            }
            if ($value->stat) {
                $stat = '<span class="label label-success label-inline font-weight-lighter mr-2">active</span>';
            } else {
                $stat = '<span class="label label-danger label-inline font-weight-lighter mr-2">nonactive</span>';
            }
            if ($privilege['update']) {
                $editbtn = '<button id="editbtn" type="button" class="btn btn-icon btn-warning btn-xs" title="Edit Country" value="' . $id . '" onclick="Edit(this.value)"><i class="far fa-edit"></i></button>';
            } else {
                $editbtn = null;
            }
            if ($privilege['delete'] and $value->stat) {
                $activebtn = null;
                $delbtn = '<button id="delbtn" type="button" class="btn btn-icon btn-danger btn-xs" title="Delete Country" value="' . $id . '" onclick="Delete(this.value)"><i class="far fa-trash-alt"></i></button>';
            } elseif ($privilege['delete'] and!$value->stat) {
                $delbtn = null;
                $activebtn = '<button id="actvbtn" type="button" class="btn btn-icon btn-default btn-xs" title="Set Active" value="' . $id . '" onclick="Active(this.value)"><i class="fas fa-unlock text-success"></i></button>';
            } else {
                $delbtn = null;
                $activebtn = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->code_country;
            $row[] = $value->nama_country;
            $row[] = $flags;
            $row[] = $stat;
            $row[] = '<div class="btn-group">' . $editbtn . $delbtn . $activebtn . '</div>';
            $data[] = $row;
        }
        return $this->_list($data, $privilege);
    }

    private function _list($data, $privilege) {
        if ($privilege['read']) {
            $output = [
                "draw" => Post_input('draw'),
                "recordsTotal" => $this->model->count_all(),
                "recordsFiltered" => $this->model->count_filtered(),
                "data" => $data
            ];
        } else {
            $output = [
                "draw" => Post_input('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        }
        ToJson($output);
    }

    private function _Save($bendera) {
        if (!$bendera['file_name']) {
            $result = redirect(base_url('Master/Country/index/'), $this->session->set_flashdata('err_msg', 'error while upload image flag'));
        } else {
            $data = [
                'param' => 'insert',
                'country_id' => 0,
                'kode_negara' => strtoupper(Post_input('code_country')),
                'nama_negara' => Post_input('name_country'),
                'bendera' => $bendera['file_name'],
                'user_login' => $this->user
            ];
            $exec = $this->model->index($data);
            if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
                $result = redirect(base_url('Master/Country/index/'), $this->session->set_flashdata('err_msg', 'error while saving data country'));
            } else {
                $result = redirect(base_url('Master/Country/index/'), $this->session->set_flashdata('succ_msg', 'success adding new country!'));
            }
        }
        return $result;
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Master/Country/index/',
            'privilege' => $this->bodo->Check_previlege('Master/Country/index/'),
            'siteTitle' => 'Master Country | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Country',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Country',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('country/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Check() {
        $data = [
            'param' => 'get_code',
            'country_id' => 0,
            'kode_negara' => Post_get("name"),
            'nama_negara' => "NULL",
            'bendera' => "NULL",
            'user_login' => "NULL"
        ];
        $exec = $this->model->index($data)->row();
        if ($exec->total == 0) {
            $result = ['status' => false, 'msg' => 'Country code available to use'];
        } else {
            $result = ['status' => true, 'msg' => 'Country code already exist!'];
        }
        return ToJson($result);
    }

    public function Save() {
        if ($_FILES['flag_country']['name']) {
            $param = [
                'upload_path' => 'assets/images/systems/flags/',
                'file_name' => Post_input('code_country'),
                'input_name' => "flag_country",
                'allowed_types' => 'gif|jpg|png|gif|ico'
            ];
            $bendera = _Upload($param);
        } else {
            $bendera['file_name'] = 'Untitled.png';
        }
        return $this->_Save($bendera);
    }

    public function Edit() {
        $country_id = $this->bodo->Dec(Post_get("id"));
        $data = [
            'param' => 'get_detail',
            'country_id' => $country_id,
            'kode_negara' => "NULL",
            'nama_negara' => "NULL",
            'bendera' => "NULL",
            'user_login' => "NULL"
        ];
        $exec = $this->model->index($data)->row();
        if ($exec) {
            $response = ['status' => true, 'exec' => $exec];
        } else {
            $response = ['status' => false, 'msg' => 'error while get data country'];
        }
        ToJson($response);
    }

    public function Update() {
        if ($_FILES['e_flag_country']['name']) {
            $param = [
                'upload_path' => 'assets/images/systems/flags/',
                'file_name' => Post_input('e_code_country'),
                'input_name' => "e_flag_country",
                'allowed_types' => 'gif|jpg|png|gif|ico'
            ];
            $bendera = _Upload($param);
        } else {
            $bendera['file_name'] = 'Untitled.png';
        }
        return $this->_Update($bendera);
    }

    private function _Update($bendera) {
        if (!$bendera['file_name']) {
            $result = redirect(base_url('Master/Country/index/'), $this->session->set_flashdata('err_msg', 'error while upload image flag'));
        } else {
            $country_id = $this->bodo->Dec(Post_input("e_id"));
            $data = [
                'param' => 'update',
                'country_id' => $country_id,
                'kode_negara' => Post_input("e_code_country"),
                'nama_negara' => Post_input("e_name_country"),
                'bendera' => $bendera['file_name'],
                'user_login' => $this->user
            ];
            $exec = $this->model->index($data);
            if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
                $result = redirect(base_url('Master/Country/index/'), $this->session->set_flashdata('err_msg', 'error while updating data <b>' . $data['nama_negara'] . '</b>'));
            } else {
                $result = redirect(base_url('Master/Country/index/'), $this->session->set_flashdata('succ_msg', 'success updating data <b>' . $data['nama_negara'] . '</b>'));
            }
        }
        return $result;
    }

    public function Delete() {
        $country_id = $this->bodo->Dec(Post_input("d_id"));
        $data = [
            'param' => 'delete',
            'country_id' => $country_id,
            'kode_negara' => null,
            'nama_negara' => null,
            'bendera' => null,
            'user_login' => $this->user
        ];
        $exec = $this->model->index($data);
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            $result = redirect(base_url('Master/Country/index/'), $this->session->set_flashdata('err_msg', 'error while deleting data country'));
        } else {
            $result = redirect(base_url('Master/Country/index/'), $this->session->set_flashdata('succ_msg', 'success deleting data country'));
        }
    }

}
