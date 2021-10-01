<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Streaming extends CI_Controller {

    public function index() {
        $this->load->view('v_streaming');
    }

    public function Chat_send() {
        $data = [
            'success' => true,
            'msg' => Post_input('message')
        ];
        ToJson($data);
    }

}
