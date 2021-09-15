<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Blog', 'model');
    }

    public function index() {
        $paginate = $this->Paginate();
        $asside_tags = $this->Tags_popular();
        $data = [
            'post' => $this->model->index($paginate),
            'asside_category' => $this->model->Category(),
            'asside_popular' => $this->model->Popular(),
            'asside_recent' => $this->model->Recent_post(),
            'asside_tags' => $asside_tags,
            'csrf' => $this->bodo->Csrf(),
            'siteTitle' => $this->bodo->Sys('company_name'),
            'pageTitle' => 'Blog Posts',
            'description' => substr($this->bodo->Compro()['meta_description'], 0, 150)
        ];
        $data['slider'] = $this->parser->parse('Profile/section_slider2', $data, true);
        $data['sidebar'] = $this->parser->parse('blog/sidebar', $data, true);
        $data['content'] = $this->parser->parse('blog/index', $data, true);
        return $this->parser->parse('Profile/layout', $data);
    }

    private function Paginate() {
        $this->load->library('pagination');
        $tot = $this->model->Totpost();
        $config['base_url'] = base_url('Blog/index/');
        $config['total_rows'] = $tot;
        $config['per_page'] = 6;
        $config['full_tag_open'] = '<nav><ul class="pagination pagination-sm justify-content-center" style="-webkit-box-shadow:none;">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:void(0);" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $from = $this->uri->segment(3);
        $data = [
            'config' => $config,
            'from' => $from
        ];
        $this->pagination->initialize($config);
        return $data;
    }

    public function Read($title) {
        $post_title = str_replace(['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], ['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], $title);
        $post = $this->model->Read($post_title);
        $data = [
            'post' => $post,
            'asside_category' => $this->model->Category(),
            'asside_popular' => $this->model->Popular(),
            'asside_recent' => $this->model->Recent_post(),
            'asside_related' => $this->model->Related_post($post_title),
            'asside_tags' => $this->Tags_popular(),
            'post_comment' => $this->Post_comment($post['id']),
            'csrf' => $this->bodo->Csrf(),
            'siteTitle' => $post_title . ' | ' . $this->bodo->Sys('company_name'),
            'pageTitle' => 'Read Post',
            'description' => substr($post['post_title'], 0, 150) . '-' . $this->bodo->Sys('company_name')
        ];
        $data['slider'] = $this->parser->parse('Profile/section_slider2', $data, true);
        $data['sidebar'] = $this->parser->parse('blog/sidebar', $data, true);
        $data['content'] = $this->parser->parse('blog/v_read', $data, true);
        return $this->parser->parse('Profile/layout', $data);
    }

    private function Post_comment($id) {
        $exec = $this->model->Post_comment($id);
        if (!empty($exec)) {
            foreach ($exec as $key => $value) {
                if ($value->comment_parent == 0) {
                    $parent[$key] = $exec[$key];
                    unset($exec[$key]);
                }
            }
            $new_parent['parent'] = $parent;
            $childern['childern'] = $exec;
            $comment = array_merge($new_parent, $childern);
        } else {
            $comment = '';
        }
        return $comment;
    }

    private function Tags_popular() {
        $exec = $this->model->Popular_tags();
        foreach ($exec as $key => $value) {
            $data[$key] = explode(',', str_replace(' ', '', $value->post_tags));
            if (count($data[$key]) != 1) {
                $multi_arr[$key] = $data[$key];
                unset($data[$key]);
            }
        }
        foreach ($multi_arr as $value2) {
            for ($i = 0; $i < count($value2); $i++) {
                $new_arr[] = $value2[$i];
            }
        }
        foreach ($data as $value3) {
            for ($i = 0; $i < count($value3); $i++) {
                $new_arr[] = $value3[$i];
            }
        }
        $final = array_unique($new_arr);
        return $final;
    }

    public function Comment() {
        if ($this->session->userdata('id_user')) {
            $id_user = $this->bodo->Dec($this->session->userdata('id_user'));
        } else {
            $id_user = 99;
        }
        $data = [
            'post_id' => $this->bodo->Dec(Post_input('post_id')) + false,
            'comment_user' => Post_input('name'),
            'comment_email' => Post_input('email'),
            'comment_content' => Post_input('message'),
            'comment_date' => date('Y-m-d H:i:s'),
            'comment_parent' => Post_input('comment_parent'),
            'ip_address' => $this->input->ip_address(),
            '`stat`' => 1 + false,
            '`syscreateuser`' => $id_user + false,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Save_comment($data);
    }

    public function get_comment() {
        $id = $this->bodo->Dec(Post_get('key'));
        if (!empty($id)) {
            $exec = $this->model->get_comment($id);
        } else {
            $exec = [
                'id' => 0,
                'comment_user' => null,
                'comment_parent' => 0
            ];
        }
        return ToJson($exec);
    }

}
