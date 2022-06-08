<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Slider', 'model');
        $this->user = Dekrip($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'data' => $this->model->index(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Compro/Services/List/',
            'privilege' => $this->bodo->Check_previlege('Compro/Services/List/'),
            'siteTitle' => 'Services Lists | Company Profile',
            'pagetitle' => 'Lists',
            'breadcrumb' => [
                0 => [
                    'nama' => 'index',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('slider/slider_index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

}
