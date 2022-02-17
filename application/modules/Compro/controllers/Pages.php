<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_pages', 'model');
        $this->load->model('M_Services', 'model2');
        $this->user = Dekrip($this->session->userdata('id_user'));
    }

    public function index() {
        $id_post = Dekrip(Post_get('service'));
        $post = $this->model->Read($id_post);
        $data = [
            'post' => $post,
            'csrf' => $this->bodo->Csrf(),
            'siteTitle' => $post['post_title'] . ' | ' . $this->bodo->Sys('company_name'),
            'pageTitle' => $post['post_title'],
            'description' => substr($post['post_title'], 0, 150) . '-' . $this->bodo->Sys('company_name')
        ];
        $data['slider'] = $this->parser->parse('Profile/section_slider2', $data, true);
        $data['content'] = $this->parser->parse('services/read_pages', $data, true);
        return $this->parser->parse('Profile/layout', $data);
    }

    public function Edit() {
        $id_post = Dekrip(Post_get('service'));
        $data = [
            'data' => $this->model->Edit($id_post),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Compro/Services/Pages/',
            'privilege' => $this->bodo->Check_previlege('Compro/Services/Pages/'),
            'siteTitle' => 'Edit service page | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Edit service page',
            'breadcrumb' => [
                0 => [
                    'nama' => 'index',
                    'link' => base_url('Compro/Services/Pages/'),
                    'status' => false
                ],
                [
                    'nama' => 'Edit',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('services/edit_page', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function lists() {
        $list = $this->model->lists();
        $data = [];
        $no = Post_get("start");
        $privilege = $this->bodo->Check_previlege('Compro/Services/Pages/');
        foreach ($list as $post) {
            $id_post = Enkrip($post->id_post);
            if ($privilege['update']) {
                $editbtn = '<a id="edit_post" href="' . base_url('Compro/Pages/Edit?service=' . $id_post) . '" class="btn btn-icon btn-default btn-xs" title="Edit Post"><i class="far fa-edit"></i></a>';
            } else {
                $editbtn = null;
            }
            $viewbtn = '<a href="' . base_url('Compro/Pages/index?service=' . $id_post) . '" class="btn btn-icon btn-default btn-xs" target="new"><i class="far fa-eye"></i></a>';
            $delbtn = '<button id="del_post" type="button" class="btn btn-icon btn-danger btn-xs" title="Delete Post" value="' . $id_post . '" onclick="Delete(this.value)"><i class="far fa-trash-alt"></i></button>';
            $syscreatedate = new DateTime($post->syscreatedate);
            $stringDate = $syscreatedate->format('d-m-Y');
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $post->post_title;
            $row[] = $post->uname;
            $row[] = $stringDate;
            $row[] = $post->viewers;
            $row[] = '<div class="btn-group">' . $viewbtn . $editbtn . $delbtn . '</div>';
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

    public function update_page() {
        $id = Dekrip(Post_get('service'));
        if (!empty($id)) {
            $post_tags = str_replace([' ', '.'], '', Post_input('post_tags'));
            $data = [
                'post_content' => $this->input->post('post_content', false),
                'post_tags' => $post_tags,
                'sysupdateuser' => $this->user,
                'sysupdatedate' => date('Y-m-d H:i:s')
            ];
            $result = $this->model->update_page($data, $id);
        } else {
            $result = redirect(base_url('Compro/Services/Pages/'), 'refresh');
        }
        return $result;
    }

    public function Delete() {
        $id = Dekrip(Post_input('d_id'));
        $data = [
            'post_status' => 0 + false,
            'sysdeleteuser' => $this->user + false,
            'sysdeletedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Delete($data, $id);
    }

}
