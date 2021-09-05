<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kelurahan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
        $this->load->model('M_kelurahan');
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Master/Wilayah/Kelurahan/index/',
            'privilege' => $this->bodo->Check_previlege('Master/Wilayah/Kelurahan/index/'),
            'siteTitle' => 'Master Wilayah Kelurahan | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Kelurahan',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Kelurahan',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('wilayah/kelurahan/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Lists() {
        $list = $this->M_kelurahan->lists();
        $data = [];
        $no = Post_input("start");
        $privilege = $this->bodo->Check_previlege('Master/Wilayah/Kelurahan/index/');
        foreach ($list as $users) {
            $id_user = Enkrip($users->id_kelurahan);
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
            $row[] = $users->id_kelurahan;
            $row[] = $users->nama;
            $row[] = $stat;
            $row[] = $users->longitude;
            $row[] = $users->latitude;
            $row[] = '<a href="https://www.google.com/maps/place/' . $users->nama . '" class="btn btn-icon btn-default btn-xs" title="View ' . $users->nama . ' on maps" target="_blank"><i class="fas fa-map-marked-alt"></i></a>';
            $row[] = '<div class="btn-group">' . $editbtn . $delbtn . $activebtn . '</div>';
            $data[] = $row;
        }
        $output = array(
            "draw" => Post_input('draw'),
            "recordsTotal" => $this->M_kelurahan->count_all(),
            "recordsFiltered" => $this->M_kelurahan->count_filtered(),
            "data" => $data,
        );
        ToJson($output);
    }

    public function Get_id() {
        $kec = Post_get('id_kel');
        $exec = $this->M_kelurahan->Get_id($kec);
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

    public function Save() {
        $data = [
            'kectxt' => Post_input('kectxt'),
            'id_kelurahan' => Post_input('a_id'),
            'keltxt' => Post_input('keltxt'),
            'longtxt' => Post_input('longtxt'),
            'lattxt' => Post_input('lattxt'),
            'syscreateuser' => $this->user,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        $this->M_kelurahan->Save($data);
    }

    public function Update() {
        $id_kelurahan = $this->bodo->Dec(Post_input('e_id'));
        $data = [
            'id_kecamatan' => Post_input('e_kectxt'),
            'nama' => Post_input('e_keltxt'),
            'longitude' => Post_input('e_longtxt'),
            'latitude' => Post_input('e_lattxt'),
            'syscreateuser' => $this->user + false,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        $this->M_kelurahan->Update($data, $id_kelurahan);
    }

    public function Get_kec() {
        $exec = $this->M_kelurahan->Get_kec();
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

    public function Detail() {
        $id_kel = $this->bodo->Dec(Post_get('id'));
        $exec = $this->M_kelurahan->Detail($id_kel);
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

    public function Delete() {
        $id = $this->bodo->Dec(Post_input('d_id'));
        $data = [
            'is_actived' => 0 + false,
            'sysdeleteuser' => $this->user,
            'sysdeletedate' => date('Y-m-d H:i:s')
        ];
        $this->M_kelurahan->Delete($data, $id);
    }

    public function Activate() {
        $id = $this->bodo->Dec(Post_input('act_id'));
        $data = [
            'is_actived' => 1 + false,
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        $this->M_kelurahan->Activate($data, $id);
    }

}
