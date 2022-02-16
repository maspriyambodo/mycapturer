<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Password_management extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
        $this->load->model('M_pwdmgr', 'model');
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Applications/Password_management/index/',
            'privilege' => $this->bodo->Check_previlege('Applications/Password_management/index/'),
            'siteTitle' => 'Password Management | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Password Management',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Password Management',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('pwdmgr/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function lists() {
        $list = $this->model->lists();
        $data = [];
        $no = Post_get("start");
        $privilege = $this->bodo->Check_previlege('Applications/Password_management/index/');
        foreach ($list as $value) {
            $id = Enkrip($value->id);
            $detilbtn = '<button id="detilbtn" type="button" class="btn btn-icon btn-default btn-xs" title="Detail" value="' . $id . '" onclick="Detail_pwd(this.value)"><i class="fas fa-eye text-primary"></i></button>';
            if ($value->status_aktif == 1) {
                $stat = '<span class="label label-success label-inline font-weight-lighter mr-2">active</span>';
            } else {
                $stat = '<span class="label label-danger label-inline font-weight-lighter mr-2">nonactive</span>';
            }
            if ($privilege['update']) {
                $editbtn = '<button id="editbtn" type="button" class="btn btn-icon btn-default btn-xs" title="Edit" value="' . $id . '" onclick="Edit(this.value)"><i class="far fa-edit text-warning"></i></button>';
            } else {
                $editbtn = null;
            }
            if ($privilege['delete'] and $value->status_aktif == 1) {
                $activebtn = null;
                $delbtn = '<button id="delbtn" type="button" class="btn btn-icon btn-default btn-xs" title="Delete" value="' . $id . '" onclick="Delete(this.value)"><i class="far fa-trash-alt text-danger"></i></button>';
            } elseif ($privilege['delete'] and $value->status_aktif != 1) {
                $delbtn = null;
                $activebtn = '<button id="actvbtn" type="button" class="btn btn-icon btn-default btn-xs" title="Set Active" value="' . $id . '" onclick="Active_pwd(this.value)"><i class="fas fa-unlock text-success"></i></button>';
            } else {
                $delbtn = null;
                $activebtn = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->owner;
            $row[] = $value->link;
            $row[] = $value->username;
            $row[] = $value->lastcheck;
            $row[] = $stat;
            $row[] = '<div class="btn-group">' . $detilbtn . $editbtn . $delbtn . $activebtn . '</div>';
            $data[] = $row;
        }
        return $this->_list($data, $privilege);
    }

    private function _list($data, $privilege) {
        if ($privilege['read']) {
            $output = [
                "draw" => Post_get('draw'),
                "recordsTotal" => $this->model->count_all(),
                "recordsFiltered" => $this->model->count_filtered(),
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
        ToJson($output);
    }

    public function Delete() {
        $id = $this->bodo->Dec(Post_input("d_id"));
        $data = [
            'status' => 2,
            'sysdeletedate' => date("Y-m-d H:i:s"),
            'sysdeleteuser' => $this->user + false
        ];
        $this->model->Update($data, $id);
    }

    public function Edit() {
        $id = $this->bodo->Dec(Post_get('id'));
        $exec = $this->model->Edit($id);
        ToJson($exec);
    }

    public function Update() {
        $id = $this->bodo->Dec(Post_input('e_id'));
        $data = [
            'link' => Post_input('e_link'),
            'uname' => Post_input('e_uname'),
            'pwd' => Post_input('e_pwd'),
            'lastcheck' => date("Y-m-d H:i:s"),
            'note' => Post_input('e_note'),
            'sysupdatedate' => date("Y-m-d H:i:s"),
            'sysupdateuser' => $this->user
        ];
        $this->model->Update($data, $id);
    }

    public function Activated() {
        $id = $this->bodo->Dec(Post_input('act_id'));
        $data = [
            'status' => 1,
            'lastcheck' => date("Y-m-d H:i:s"),
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date("Y-m-d H:i:s")
        ];
        $this->model->Update($data, $id);
    }

    public function Add() {
        $data = [
            'link' => Post_input('add_link'),
            'uname' => Post_input('add_uname'),
            'pwd' => Post_input('add_pwd'),
            'lastcheck' => date("Y-m-d H:i:s"),
            'note' => Post_input('add_note'),
            'status' => 1,
            'syscreatedate' => date("Y-m-d H:i:s"),
            'syscreateuser' => $this->user
        ];
        $this->model->Add($data);
    }

}