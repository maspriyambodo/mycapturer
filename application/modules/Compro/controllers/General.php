<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Product:        System of AU+ PRODUCTION
 * License Type:   Company
 * Access Type:    Multi-User
 * License:        https://maspriyambodo.com
 * maspriyambodo@gmail.com
 * 
 * Thank you,
 * maspriyambodo
 */

/**
 * Description of Profile
 *
 * @author centos
 */
class General extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_general', 'model');
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Compro/General/index/',
            'privilege' => $this->bodo->Check_previlege('Compro/General/index/'),
            'siteTitle' => 'General Settings | Company Profile',
            'pagetitle' => 'General Settings',
            'breadcrumb' => [
                0 => [
                    'nama' => 'index',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('general/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Lists() {
        $list = $this->model->lists();
        $data = [];
        $no = Post_input("start");
        $privilege = $this->bodo->Check_previlege('Compro/General/index/');
        foreach ($list as $option) {
            $id = Enkrip($option->id);
            if ($option->stat == 1) {
                $stat = '<span class="label label-success label-inline font-weight-lighter mr-2">active</span>';
            } else {
                $stat = '<span class="label label-danger label-inline font-weight-lighter mr-2">nonactive</span>';
            }
            if ($privilege['update']) {
                $editbtn = '<button id="edit_user" type="button" class="btn btn-icon btn-default btn-xs" title="Edit" value="' . $id . '" data-toggle="modal" data-target="#modal_edit" onclick="Edit(this.value)"><i class="far fa-edit"></i></button>';
            } else {
                $editbtn = null;
            }
            if ($privilege['delete'] and $option->stat) {
                $activebtn = null;
                $delbtn = '<button id="del_user" type="button" class="btn btn-icon btn-danger btn-xs" title="Delete" value="' . $id . '" data-toggle="modal" data-target="#modal_delete" onclick="Delete(this.value)"><i class="far fa-trash-alt"></i></button>';
            } elseif ($privilege['delete'] and!$option->stat) {
                $delbtn = null;
                $activebtn = '<button id="act_user" type="button" class="btn btn-icon btn-success btn-xs" title="Activate" value="' . $id . '" data-toggle="modal" data-target="#modal_active" onclick="Active(this.value)"><i class="fas fa-unlock"></i></button>';
            } else {
                $delbtn = null;
                $activebtn = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $option->option_name;
            $row[] = $option->option_value;
            $row[] = $option->description;
            $row[] = $stat;
            $row[] = '<div class="btn-group">' . $editbtn . $delbtn . $activebtn . '</div>';
            $data[] = $row;
        }
        return $this->_list($data, $privilege);
    }

    private function _list($data, $privilege) {
        $csrf = $this->bodo->Csrf();
        if ($privilege['read']) {
            $output = [
                "draw" => Post_input('draw'),
                "recordsTotal" => $this->model->count_all(),
                "recordsFiltered" => $this->model->count_filtered(),
                "data" => $data
            ];
            $output[$csrf['name']] = $csrf['hash'];
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

    public function Save() {
        $option_name = str_replace(' ', '_', Post_input('nametxt'));
        $data = [
            'option_name' => $option_name,
            'option_value' => Post_input('valuetxt'),
            'description' => Post_input('desctxt'),
            'syscreateuser' => $this->user,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        return $this->model->Save($data);
    }

    public function Get_detail() {
        $id = $this->bodo->Dec(Post_get('token'));
        $exec = $this->model->Get_detail($id);
        if ($exec) {
            $exec->id = Enkrip($exec->id);
            $exec->stat = true;
            $exec->msg = 'data found!';
        } else {
            $exec->stat = false;
            $exec->msg = 'data not found, please refresh this page!';
        }
        return ToJson($exec);
    }

    public function Update() {
        $id = $this->bodo->Dec(Post_input('e_id'));
        $data = [
            'option_name' => Post_input('e_nametxt'),
            'option_value' => Post_input('e_valuetxt'),
            'description' => Post_input('e_desctxt'),
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        return $this->model->Update($data, $id);
    }

    public function Delete() {
        $id = $this->bodo->Dec(Post_input('d_id'));
        $data = [
            '`stat`' => 0 + false,
            'sysdeleteuser' => $this->user + false,
            'sysdeletedate' => date('Y-m-d H:i:s')
        ];
        return $this->model->Delete($data, $id);
    }

    public function Active() {
        $id = $this->bodo->Dec(Post_input('act_id'));
        $data = [
            '`stat`' => 1 + false,
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        return $this->model->Active($data, $id);
    }

}
