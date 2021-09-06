<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_auth');
    }

    private function Check_session() {
        if ($this->session->userdata('id_user') and $this->session->userdata('uname') and $this->session->userdata('stat_aktif') and $this->session->userdata('role_id')) {
            $result = redirect(base_url('Dashboard'), 'refresh');
        } elseif ($this->session->tempdata('penalty')) {
            $result = show_404();
        } else {
            $result = true;
        }
        return $result;
    }

    public function index() {
        $this->Check_session();
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'siteTitle' => 'Signin System | ' . $this->bodo->Sys('app_name'),
        ];
        $this->parser->parse('v_auth', $data);
    }

    public function Signin() {
        $data = [
            'uname' => Post_input("username"),
            'pwd' => Post_input("password")
        ];
        $exec = $this->M_auth->Signin($data);
        if (!empty($exec) and ($exec->limit_login == 0 or $exec->limit_login != 3)) {
            $hashed = $exec->pwd;
            if (password_verify($data['pwd'], $hashed)) {
                $this->bodo->Set_session($exec);
                $this->M_auth->Remove_penalty($data);
                $result = redirect(base_url('Dashboard'), 'refresh');
            } else {
                $this->Attempt(1);
                $result = redirect(base_url('Signin'), $this->session->set_flashdata('err_msg', 'Sorry, your password was incorrect. Please double-check your password.'));
            }
        } elseif (!empty($exec) and $exec->limit_login == 3) {
            blocked_account();
        } else {
            $this->Attempt(2);
            $result = redirect(base_url('Signin'), $this->session->set_flashdata('err_msg', 'username not registered!'));
        }
        return $result;
    }

    private function Attempt($id) {
        $attempt = $this->session->userdata('attempt');
        $attempt++;
        $this->session->set_userdata('attempt', $attempt);
        $data = [
            'uname' => Post_input("username"),
            'attempt' => $attempt
        ];
        switch ($id) {
            case 1:
                $this->M_auth->Penalty($data);
                if ($attempt == 3) {
                    $this->session->set_tempdata('penalty', true, 300);
                    blocked_account();
                }
            case 2:
                if ($attempt == 5) {
                    $this->session->set_tempdata('penalty', true, 360);
                    show_404();
                }
        }
    }

    public function Logout() {
        $this->session->sess_destroy();
        return redirect(base_url('Signin'), 'refresh');
    }

}
