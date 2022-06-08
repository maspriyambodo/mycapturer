<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_compro', 'model');
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'list_services' => $this->model->List_services(),
            'siteTitle' => $this->bodo->Sys('company_name') . ' - ' . substr($this->bodo->Compro()['meta_description'], 0, 150),
            'description' => substr($this->bodo->Compro()['meta_description'], 0, 150)
        ];
        $data['slider'] = $this->parser->parse('section_slider', $data, true);
        $data['content'] = $this->parser->parse('index', $data, true);
        return $this->parser->parse('layout', $data);
    }

    public function Gallery() {
        $paginate = $this->Paginate();
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'siteTitle' => 'Gallery | ' . $this->bodo->Sys('company_name'),
            'pageTitle' => 'Our Portfolio',
            'description' => substr($this->bodo->Compro()['meta_description'], 0, 150),
            'portfolio' => $this->model->Portfolio($paginate)
        ];
        $data['slider'] = $this->parser->parse('section_slider2', $data, true);
        $data['content'] = $this->parser->parse('gallery', $data, true);
        return $this->parser->parse('layout', $data);
    }

    private function Paginate() {
        $this->load->library('pagination');
        $tot = $this->model->Totprotfolio();
        $config['base_url'] = base_url('Profile/Gallery');
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

    public function Newsletter() {
        $this->load->library('user_agent');
        $data = [
            'mail' => Post_input('emailtxt'),
            'nama' => Post_input('nametxt'),
            'platform' => $this->agent->platform()
        ];
        $this->model->Newsletter($data);
    }

    public function Contact() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'list_services' => $this->model->List_services(),
            'siteTitle' => 'Contact | ' . $this->bodo->Sys('company_name'),
            'pageTitle' => 'Contact Us',
            'description' => substr($this->bodo->Compro()['meta_description'], 0, 150)
        ];
        $data['slider'] = $this->parser->parse('section_slider2', $data, true);
        $data['content'] = $this->parser->parse('contact', $data, true);
        return $this->parser->parse('layout', $data);
    }

}
