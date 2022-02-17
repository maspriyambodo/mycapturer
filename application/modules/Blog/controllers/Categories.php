<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Categories');
        $this->model = $this->M_Categories;
        $this->user = Dekrip($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Blog/Categories/index/',
            'privilege' => $this->bodo->Check_previlege('Blog/Categories/index/'),
            'siteTitle' => 'Post Categories Management | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Post Categories Management',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Categories',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('categories/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function lists() {
        $list = $this->model->lists();
        $data = [];
        $no = Post_get("start");
        $privilege = $this->bodo->Check_previlege('Blog/Categories/index/');
        foreach ($list as $category) {
            $id_post = Enkrip($category->id);
            if ($category->stat == 1) {
                $stat = '<span class="label label-success label-inline font-weight-lighter mr-2">active</span>';
            } else {
                $stat = '<span class="label label-danger label-inline font-weight-lighter mr-2">nonactive</span>';
            }
            if ($privilege['update']) {
                $editbtn = '<button type="button" class="btn btn-icon btn-default btn-xs" title="Edit Category" value="' . $id_post . '" onclick="Edit(this.value)"><i class="far fa-edit"></i></button>';
            } else {
                $editbtn = null;
            }
            if ($privilege['delete'] and $category->stat == 1) {
                $activebtn = null;
                $delbtn = '<button type="button" class="btn btn-icon btn-danger btn-xs" title="Delete Post" value="' . $id_post . '" onclick="Delete(this.value)"><i class="far fa-trash-alt"></i></button>';
            } elseif ($privilege['delete'] and $category->stat != 1) {
                $delbtn = null;
                $activebtn = '<button type="button" class="btn btn-icon btn-success btn-xs" title="Activate Category" value="' . $id_post . '" onclick="Activated(this.value)"><i class="fas fa-unlock"></i></button>';
            } else {
                $delbtn = null;
                $activebtn = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $category->category;
            $row[] = $category->descriptions;
            $row[] = $stat;
            $row[] = '<div class="btn-group">' . $editbtn . $delbtn . $activebtn . '</div>';
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

    public function Save() {
        $data = [
            'category' => Post_input('a_category'),
            'descriptions' => Post_input('a_desc'),
            'stat' => 1 + false,
            'syscreateuser' => $this->user + false,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Save($data);
    }

    public function Get_category() {
        $id_category = $this->bodo->Dec(Post_get('id_category'));
        $exec = $this->model->Get_category($id_category);
        if ($exec) {
            $response = ['status' => true, 'exec' => $exec];
        } else {
            $response = ['status' => false, 'msg' => 'error while getting data provinsi'];
        }
        return ToJson($response);
    }

    public function Update() {
        $id_category = $this->bodo->Dec(Post_input('e_id'));
        $data = [
            'category' => Post_input('e_category'),
            'descriptions' => Post_input('e_desc'),
            'sysupdateuser' => $this->user,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Update($data, $id_category);
    }

    public function Activate() {
        $id_category = $this->bodo->Dec(Post_input('a_id'));
        $data = [
            'stat' => 1 + false,
            'sysdeleteuser' => $this->user + false,
            'sysdeletedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Activate($data, $id_category);
    }

    public function Delete() {
        $id_category = $this->bodo->Dec(Post_input('d_id'));
        $data = [
            'stat' => 2 + false,
            'sysdeleteuser' => $this->user + false,
            'sysdeletedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Delete($data, $id_category);
    }

}
