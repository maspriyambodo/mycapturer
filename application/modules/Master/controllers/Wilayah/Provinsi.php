<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Provinsi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Wilayah', 'model');
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
    }

    private function _index() {
        $param = [
            'param' => 'select',
            'prov_id' => 0,
            'nama_prov' => "",
            'lat' => 0,
            'ltd' => 0,
            'user_login' => 0
        ];
        return $param;
    }

    public function index() {
        $data = [
            'data' => $this->model->Provinsi($this->_index())->result(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Master/Wilayah/Provinsi/index/',
            'privilege' => $this->bodo->Check_previlege('Master/Wilayah/Provinsi/index/'),
            'siteTitle' => 'Master Wilayah Provinsi | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Provinsi',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Provinsi',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('wilayah/provinsi/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Get_() {
        $id_provinsi = $this->bodo->Dec(Post_get("id"));
        $param = [
            'param' => 'detail',
            'prov_id' => $id_provinsi,
            'nama_prov' => "",
            'lat' => 0,
            'ltd' => 0,
            'user_login' => 0
        ];
        $exec = $this->model->Provinsi($param)->row();
        if ($exec) {
            $response = ['status' => true, 'exec' => $exec];
        } else {
            $response = ['status' => false, 'msg' => 'error while getting data provinsi'];
        }
        return ToJson($response);
    }

    public function Update() {
        $id_provinsi = $this->bodo->Dec(Post_input("e_id"));
        $param = [
            'param' => 'update',
            'prov_id' => $id_provinsi,
            'nama_prov' => Post_input("e_nama_prov"),
            'lat' => Post_input("e_txtlat"),
            'ltd' => Post_input("e_txtlong"),
            'user_login' => $this->user
        ];
        $exec = $this->model->Provinsi($param);
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            $result = redirect(base_url('Master/Wilayah/Provinsi/index/'), $this->session->set_flashdata('err_msg', 'error while updating data provinsi'));
        } else {
            $result = redirect(base_url('Master/Wilayah/Provinsi/index/'), $this->session->set_flashdata('succ_msg', 'success updating data provinsi!'));
        }
        return $result;
    }

    public function Delete() {
        $id_provinsi = $this->bodo->Dec(Post_input("d_id"));
        $param = [
            'param' => 'delete',
            'prov_id' => $id_provinsi,
            'nama_prov' => "",
            'lat' => 0,
            'ltd' => 0,
            'user_login' => $this->user
        ];
        $exec = $this->model->Provinsi($param);
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            $result = redirect(base_url('Master/Wilayah/Provinsi/index/'), $this->session->set_flashdata('err_msg', 'error while deleting data provinsi'));
        } else {
            $result = redirect(base_url('Master/Wilayah/Provinsi/index/'), $this->session->set_flashdata('succ_msg', 'success deleting data provinsi!'));
        }
        return $result;
    }

    public function Get_id() {
        $id_provinsi = Post_get("id");
        $param = [
            'param' => 'Get_id',
            'prov_id' => $id_provinsi,
            'nama_prov' => "",
            'lat' => 0,
            'ltd' => 0,
            'user_login' => $this->user
        ];
        $exec = $this->model->Provinsi($param)->row();
        ToJson($exec);
    }

    public function Save() {
        $param = [
            'param' => 'insert',
            'prov_id' => Post_input('prov_id'),
            'nama_prov' => Post_input('nama_prov'),
            'lat' => Post_input('txtlat'),
            'ltd' => Post_input('txtlong'),
            'user_login' => $this->user
        ];
        $exec = $this->model->Provinsi($param);
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            $result = redirect(base_url('Master/Wilayah/Provinsi/index/'), $this->session->set_flashdata('err_msg', 'error while adding data provinsi'));
        } else {
            $result = redirect(base_url('Master/Wilayah/Provinsi/index/'), $this->session->set_flashdata('succ_msg', 'success adding data provinsi!'));
        }
        return $result;
    }

    public function Set_active() {
        $prov_id = $this->bodo->Dec(Post_input('a_id'));
        $param = [
            'param' => 'Set_active',
            'prov_id' => $prov_id,
            'nama_prov' => "",
            'lat' => 0,
            'ltd' => 0,
            'user_login' => $this->user
        ];
        $exec = $this->model->Provinsi($param);
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            $result = redirect(base_url('Master/Wilayah/Provinsi/index/'), $this->session->set_flashdata('err_msg', 'error while activating data provinsi'));
        } else {
            $result = redirect(base_url('Master/Wilayah/Provinsi/index/'), $this->session->set_flashdata('succ_msg', 'success activating data provinsi!'));
        }
        return $result;
    }

}
