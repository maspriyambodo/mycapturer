<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kabupaten extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_kabupaten', 'model');
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'prov' => $this->model->Provinsi(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Master/Wilayah/Kabupaten/index/',
            'privilege' => $this->bodo->Check_previlege('Master/Wilayah/Kabupaten/index/'),
            'siteTitle' => 'Master Wilayah Kabupaten | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Kabupaten',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Kabupaten',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('wilayah/kabupaten/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Lists() {
        $list = $this->model->lists();
        $data = [];
        $no = Post_input("start");
        $privilege = $this->bodo->Check_previlege('Master/Wilayah/Kabupaten/index/');
        foreach ($list as $kabupaten) {
            $id_kabupaten = Enkrip($kabupaten->id_kabupaten);
            if ($kabupaten->is_actived == 1) {
                $stat = '<span class="label label-success label-inline font-weight-lighter mr-2">active</span>';
            } else {
                $stat = '<span class="label label-danger label-inline font-weight-lighter mr-2">nonactive</span>';
            }
            if ($privilege['update']) {
                $editbtn = '<button id="edit_user" type="button" class="btn btn-icon btn-default btn-xs" title="Edit ' . $kabupaten->nama . '" value="' . $id_kabupaten . '" data-toggle="modal" data-target="#modal_edit" onclick="Edit(this.value)"><i class="far fa-edit"></i></button>';
            } else {
                $editbtn = null;
            }
            if ($privilege['delete'] and $kabupaten->is_actived) {
                $activebtn = null;
                $delbtn = '<button id="del_user" type="button" class="btn btn-icon btn-danger btn-xs" title="Delete ' . $kabupaten->nama . '" value="' . $id_kabupaten . '" data-toggle="modal" data-target="#modal_delete" onclick="Delete(this.value)"><i class="far fa-trash-alt"></i></button>';
            } elseif ($privilege['delete'] and!$kabupaten->is_actived) {
                $delbtn = null;
                $activebtn = '<button id="act_user" type="button" class="btn btn-icon btn-success btn-xs" title="Activate ' . $kabupaten->nama . '" value="' . $id_kabupaten . '" data-toggle="modal" data-target="#modal_active" onclick="Active(this.value)"><i class="fas fa-unlock"></i></button>';
            } else {
                $delbtn = null;
                $activebtn = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $kabupaten->id_kabupaten;
            $row[] = $kabupaten->nama;
            $row[] = $stat;
            $row[] = $kabupaten->longitude;
            $row[] = $kabupaten->latitude;
            $row[] = '<a href="https://www.google.com/maps/place/' . $kabupaten->nama . '" class="btn btn-icon btn-default btn-xs" title="View ' . $kabupaten->nama . ' on maps" target="_blank"><i class="fas fa-map-marked-alt"></i></a>';
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

    public function Get_id() {
        $id = Post_get('id_kab');
        $exec = $this->model->Get_id($id);
        if ($exec) {
            $response = [
                'stat' => false,
                'msg' => 'ID Kabupaten already exist!'
            ];
        } else {
            $response = [
                'stat' => true,
                'msg' => 'ID Kabupaten available to use!'
            ];
        }
        ToJson($response);
    }

    public function Add() {
        $id_provinsi = $this->bodo->Dec(Post_input('add_prov'));
        $data = [
            'id_kabupaten' => Post_input('add_idkab'),
            'id_provinsi' => $id_provinsi,
            'nama' => Post_input('add_namakab'),
            'is_actived' => 1,
            'latitude' => Post_input('add_lat'),
            'longitude' => Post_input('add_longt'),
            'syscreateuser' => $this->user,
            'syscreatedate' => date("Y-m-d H:i:s")
        ];
        $this->model->Add($data);
    }

    public function Get_prov() {
        $exec = $this->model->Get_prov();
        if ($exec) {
            $response = [
                'stat' => true,
                'results' => $exec
            ];
        } else {
            $response = [
                'stat' => false
            ];
        }
        ToJson($exec);
    }

    public function Get_detail() {
        $id = $this->bodo->Dec(Post_get('id'));
        $exec = $this->model->Get_detail($id);
        ToJson($exec);
    }

    public function Update() {
        $id_kab = $this->bodo->Dec(Post_input('e_id'));
        $data = [
            'id_provinsi' => Post_input('edit_prov'),
            'nama' => Post_input('edit_namakab'),
            'latitude' => Post_input('edit_lat'),
            'longitude' => Post_input('edit_longt'),
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date("Y-m-d H:i:s")
        ];
        $this->model->Update($data, $id_kab);
    }

    public function Delete() {
        $id_kab = $this->bodo->Dec(Post_input('d_id'));
        $data = [
            '`mt_wil_kabupaten`.`is_actived`' => 0 + false,
            '`mt_wil_kabupaten`.`sysdeleteuser`' => $this->user + false,
            'mt_wil_kabupaten.sysdeletedate' => date("Y-m-d H:i:s")
        ];
        $this->model->Delete($data, $id_kab);
    }

    public function Active() {
        $id_kab = $this->bodo->Dec(Post_input('act_id'));
        $data = [
            '`mt_wil_kabupaten`.`is_actived`' => 1 + false,
            '`mt_wil_kabupaten`.`sysupdateuser`' => $this->user + false,
            'mt_wil_kabupaten.sysupdatedate' => date("Y-m-d H:i:s")
        ];
        $this->model->Active($data, $id_kab);
    }

}
