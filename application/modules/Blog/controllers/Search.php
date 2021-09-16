<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Search', 'model');
        $this->load->model('M_Blog', 'model_blog');
    }

    public function Category() {
        $query = str_replace(['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], ['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], Post_get('q'));
        $paginate = $this->Paginate('Category', $query);
        $data = [
            'post' => $this->model->Category($paginate, $query),
            'asside_category' => $this->model_blog->Category(),
            'asside_popular' => $this->model_blog->Popular(),
            'asside_recent' => $this->model_blog->Recent_post(),
            'asside_tags' => $this->Tags_popular(),
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

    public function Post() {
        $query = str_replace(['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], ['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], Post_get('searchtxt'));
        $paginate = $this->Paginate('Post', $query);
        $data = [
            'post' => $this->model->Get_post($paginate, $query),
            'asside_category' => $this->model_blog->Category(),
            'asside_popular' => $this->model_blog->Popular(),
            'asside_recent' => $this->model_blog->Recent_post(),
            'asside_tags' => $this->Tags_popular(),
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

    public function Tags() {
        $query = str_replace(['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], ['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], Post_get('q'));
        $paginate = $this->Paginate('Tags', $query);
        $data = [
            'post' => $this->model->Tags($paginate, $query),
            'asside_category' => $this->model_blog->Category(),
            'asside_popular' => $this->model_blog->Popular(),
            'asside_recent' => $this->model_blog->Recent_post(),
            'asside_tags' => $this->Tags_popular(),
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

    private function Paginate($param, $query) {
        if ($param == 'Category') {
            $tot = $this->model->TotCategory($query);
        } elseif ($param == 'Post') {
            $tot = $this->model->TotPost($query);
        }
        else {
            $tot = $this->model->Tot_tags($query);
        }
        $this->load->library('pagination');
        $config['base_url'] = base_url('Blog/Search/' . $param);
        $config['reuse_query_string'] = true;
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
        $from = $this->uri->segment(4);
        $data = [
            'config' => $config,
            'from' => $from
        ];
        $this->pagination->initialize($config);
        return $data;
    }

    private function Tags_popular() {
        $exec = $this->model_blog->Popular_tags();
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

}
