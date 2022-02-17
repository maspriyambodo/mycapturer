<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_post');
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Blog/Post/index/',
            'privilege' => $this->bodo->Check_previlege('Blog/Post/index/'),
            'siteTitle' => 'Post Blog Management | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Post Blog Management',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Post',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('post/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function lists() {
        $list = $this->M_post->lists();
        $data = [];
        $no = Post_get("start");
        $privilege = $this->bodo->Check_previlege('Blog/Post/index/');
        foreach ($list as $post) {
            $id_post = Enkrip($post->id);
            if ($post->post_status == 1) {
                $stat = '<span class="label label-success label-inline font-weight-lighter mr-2">active</span>';
            } else {
                $stat = '<span class="label label-danger label-inline font-weight-lighter mr-2">nonactive</span>';
            }
            if ($privilege['update']) {
                $editbtn = '<button id="edit_post" type="button" class="btn btn-icon btn-default btn-xs" title="Edit Post" value="' . $id_post . '" onclick="Edit(this.value)"><i class="far fa-edit"></i></button>';
            } else {
                $editbtn = null;
            }
            if ($privilege['delete'] and $post->post_status == 1) {
                $activebtn = null;
                $delbtn = '<button id="del_post" type="button" class="btn btn-icon btn-danger btn-xs" title="Delete Post" value="' . $id_post . '" onclick="Delete(this.value)"><i class="far fa-trash-alt"></i></button>';
            } elseif ($privilege['delete'] and $post->post_status != 1) {
                $delbtn = null;
                $activebtn = '<button id="act_user" type="button" class="btn btn-icon btn-success btn-xs" title="Activate Post" value="' . $id_post . '" onclick="Activated(this.value)"><i class="fas fa-unlock"></i></button>';
            } else {
                $delbtn = null;
                $activebtn = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $post->post_title;
            $row[] = $post->uname;
            $row[] = $post->category;
            $row[] = $post->syscreatedate;
            $row[] = $post->viewers;
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
                "recordsTotal" => $this->M_post->count_all(),
                "recordsFiltered" => $this->M_post->count_filtered(),
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

    public function Add() {
        $data = [
            'category' => $this->M_post->Category(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Blog/Post/index/',
            'privilege' => $this->bodo->Check_previlege('Blog/Post/index/'),
            'siteTitle' => 'Add new post | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Add new post',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Post',
                    'link' => base_url('Blog/Post/index/'),
                    'status' => false
                ],
                1 => [
                    'nama' => 'Add',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('post/add', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Browser() {
        $data['csrf'] = $this->bodo->Csrf();
        return $this->load->view('elfinder', $data);
    }

    public function elfinder_init() {
        $opts = initialize_elfinder();
        return $this->load->library('elfinder_lib', $opts);
    }

    public function Save() {
        $post_category = $this->bodo->Dec(Post_input('post_category'));
        $post_tags = str_replace(' ', '', Post_input('post_tags'));
        $data = [
            'post_content' => $this->input->post('post_content', false),
            'post_title' => Post_input('post_title'),
            'post_status' => Post_input('stat_post'),
            'comment_status' => Post_input('post_comment'),
            'post_category' => $post_category,
            'post_tags' => $post_tags,
            'post_thumbnail' => Post_input('thumbnail_txt'),
            'syscreateuser' => $this->user,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        return $this->M_post->Save($data);
    }

    public function Update() {
        $post_category = $this->bodo->Dec(Post_input('post_category'));
        $id_post = $this->bodo->Dec(Post_input('id_post'));
        $post_tags = str_replace(' ', '', Post_input('post_tags'));
        $data = [
            'post_content' => $this->input->post('post_content', false),
            'post_title' => Post_input('post_title'),
            'post_status' => Post_input('stat_post'),
            'comment_status' => Post_input('post_comment'),
            'post_category' => $post_category,
            'post_tags' => $post_tags,
            'post_thumbnail' => Post_input('thumbnail_txt'),
            'sysupdateuser' => $this->user,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        return $this->M_post->Update($data, $id_post);
    }

    public function Edit() {
        $id_post = $this->bodo->Dec(Post_get('id_post'));
        $post = $this->M_post->Post($id_post);
        $data = [
            'post' => $post,
            'category' => $this->M_post->Category(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Blog/Post/index/',
            'privilege' => $this->bodo->Check_previlege('Blog/Post/index/'),
            'siteTitle' => $post['post_title'] . ' | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Edit Post',
            'breadcrumb' => [
                0 => [
                    'nama' => 'Post',
                    'link' => base_url('Blog/Post/index/'),
                    'status' => false
                ],
                1 => [
                    'nama' => 'Edit',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('post/edit', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Delete() {
        $id_post = $this->bodo->Dec(Post_input('id_post'));
        $data = [
            'post_status' => 2 + false,
            'sysdeleteuser' => $this->user + false,
            'sysdeletedate' => date('Y-m-d H:i:s')
        ];
        return $this->M_post->Delete($data, $id_post);
    }

    public function Activated() {
        $id_post = $this->bodo->Dec(Post_input('id_act'));
        $data = [
            'post_status' => 1 + false,
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        return $this->M_post->Activated($data, $id_post);
    }

    public function Upload_image() {
        $param = [
            'upload_path' => 'assets/images/blog/thumb/',
            'file_name' => date('Y_m_d_H_i_s'),
            'input_name' => 'thmbtxt',
            'allowed_types' => 'jpg|png|jpeg'
        ];
        $upload = _Upload($param);
        $response = [
            'stat' => $upload['status'],
            'file_name' => $upload['file_name']
        ];
        return ToJson($response);
    }

}
