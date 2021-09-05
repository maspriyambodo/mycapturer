<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Slider extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Slider', 'model');
        $this->user = Dekrip($this->session->userdata('id_user'));
    }

    public function index() {
        
    }

}
