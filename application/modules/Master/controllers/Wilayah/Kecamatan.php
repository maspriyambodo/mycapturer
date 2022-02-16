<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user = Dekrip($this->session->userdata('id_user'));
        $this->load->model('M_kecamatan');
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Master/Wilayah/Kecamatan/index/',
            'privilege' => $this->bodo->Check_previlege('Master/Wilayah/Kecamatan/index/'),
            'siteTitle' => 'Master Wilayah Kecamatan | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Kecamatan',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Kecamatan',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('wilayah/kecamatan/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Lists() {
        $list = $this->M_kecamatan->lists();
        $data = [];
        $no = Post_get("start");
        $privilege = $this->bodo->Check_previlege('Master/Wilayah/Kecamatan/index/');
        foreach ($list as $users) {
            $id_user = Enkrip($users->id_kecamatan);
            if ($users->is_actived == 1) {
                $stat = '<span class="label label-success label-inline font-weight-lighter mr-2">active</span>';
            } else {
                $stat = '<span class="label label-danger label-inline font-weight-lighter mr-2">nonactive</span>';
            }
            if ($privilege['update']) {
                $editbtn = '<button type="button" class="btn btn-icon btn-default btn-xs" title="Edit ' . $users->nama . '" value="' . $id_user . '" onclick="Edit(this.value)" data-toggle="modal" data-target="#modal_edit"><i class="far fa-edit"></i></button>';
            } else {
                $editbtn = null;
            }
            if ($privilege['delete'] and $users->is_actived == 1) {
                $activebtn = null;
                $delbtn = '<button type="button" class="btn btn-icon btn-danger btn-xs" title="Delete ' . $users->nama . '" value="' . $id_user . '" onclick="Delete(this.value)"><i class="far fa-trash-alt"></i></button>';
            } elseif ($privilege['delete'] and $users->is_actived != 1) {
                $delbtn = null;
                $activebtn = '<button type="button" class="btn btn-icon btn-success btn-xs" title="Activate ' . $users->nama . '" value="' . $id_user . '" onclick="Active(this.value)"><i class="fas fa-unlock"></i></button>';
            } else {
                $delbtn = null;
                $activebtn = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $users->id_kecamatan;
            $row[] = $users->nama;
            $row[] = $stat;
            $row[] = $users->longitude;
            $row[] = $users->latitude;
            $row[] = '<a href="https://www.google.com/maps/place/' . $users->nama . '" class="btn btn-icon btn-default btn-xs" title="View ' . $users->nama . ' on maps" target="_blank"><i class="fas fa-map-marked-alt"></i></a>';
            $row[] = '<div class="btn-group">' . $editbtn . $delbtn . $activebtn . '</div>';
            $data[] = $row;
        }
        $output = [
            "draw" => Post_get('draw'),
            "recordsTotal" => $this->M_kecamatan->count_all(),
            "recordsFiltered" => $this->M_kecamatan->count_filtered(),
            "data" => $data
        ];
        return ToJson($output);
    }

    public function Get_kab() {
        $exec = $this->M_kecamatan->Get_kab();
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

    public function Get_id() {
        $kec = Post_get('id_kec');
        $exec = $this->M_kecamatan->Get_id($kec);
        if ($exec) {
            $response = [
                'stat' => false,
                'msg' => 'ID Kelurahan already exist!'
            ];
        } else {
            $response = [
                'stat' => true,
                'msg' => 'ID Kelurahan available to use!'
            ];
        }
        ToJson($response);
    }

    public function Add() {
        $data = [
            'id_kecamatan' => Post_input('a_id'),
            'id_kabupaten' => Post_input('kabtxt'),
            'nama' => Post_input('kectxt'),
            'latitude' => Post_input('txtlat'),
            'longitude' => Post_input('longtxt'),
            'syscreateuser' => $this->user + false,
            'syscreatedate' => date('Y-m-d')
        ];
        $this->M_kecamatan->Add($data);
    }

    public function Detail() {
        $id_kel = Dekrip(Post_get('id'));
        $exec = $this->M_kecamatan->Detail($id_kel);
        if ($exec) {
            $response = [
                'stat' => true,
                'results' => $exec
            ];
        } else {
            $response = [
                'stat' => false,
                'results' => []
            ];
        }
        ToJson($response);
    }

    public function Update() {
        $id_kecamatan = Post_input('e_idkel');
        $data = [
            'id_kabupaten' => Post_input('e_kectxt'),
            'nama' => Post_input('e_keltxt'),
            'latitude' => Post_input('e_lattxt'),
            'longitude' => Post_input('e_longtxt'),
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date('Y-m-d')
        ];
        $this->M_kecamatan->Update($data, $id_kecamatan);
    }

    public function Delete() {
        $id = Dekrip(Post_input('d_id'));
        $data = [
            'is_actived' => 0 + false,
            'sysdeleteuser' => $this->user,
            'sysdeletedate' => date('Y-m-d H:i:s')
        ];
        $this->M_kecamatan->Delete($data, $id);
    }

    public function Activate() {
        $id = Dekrip(Post_input('act_id'));
        $data = [
            'is_actived' => 1 + false,
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        $this->M_kecamatan->Activate($data, $id);
    }

}
