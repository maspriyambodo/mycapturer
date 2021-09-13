<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bodo {

    private $CI;

    public function __construct() {
        $this->CI = &get_instance();
        $this->role_id = $this->Dec($this->CI->session->userdata('role_id'));
    }

    public function Check_login() {
        if ($this->CI->session->userdata('id_user') and $this->CI->session->userdata('uname') and $this->CI->session->userdata('stat_aktif') and $this->CI->session->userdata('role_id')) {
            $result = true;
        } else {
            $result = redirect(base_url('Signin'), $this->CI->session->set_flashdata('err_msg', 'you need signin to access the system'));
        }
        return $result;
    }

    public function Check_previlege($param) {
        $exec = $this->CI->db->select()
                ->from('sys_menu_select')
                ->where([
                    'sys_menu_select.link' => $param,
                    '`sys_menu_select`.`role_id`' => $this->role_id + false,
                    '`sys_menu_select`.`view`' => 1 + false
                ])
                ->get()
                ->row_array();
        mysqli_next_result($this->CI->db->conn_id);
        if ($exec) {
            $result = [
                'view' => $exec['view'],
                'create' => $exec['create'],
                'read' => $exec['read'],
                'update' => $exec['update'],
                'delete' => $exec['delete']
            ];
        } else {
            $this->Check_login();
            $result = show_404();
        }
        return $result;
    }

    public function Count_notif() {
        if ($this->role_id == 1) {
            $exec = $this->CI->M_notification->Count_notif_su();
        } else {
            $exec = $this->CI->M_notification->Count_notif();
        }
        return $exec;
    }

    public function Dec($enc) {
        $encrypt = str_replace(['-', '_', '~'], ['+', '/', '='], $enc);
        $dec = $this->CI->encryption->decrypt($encrypt);
        return $dec;
    }

    public function Url($a) {
        $b = $this->Dec($a); //output $dec = ?a=2020&b=16&c=212&d=Kab. Madiun
        $c = str_replace(['?a=', '&b=', '&c=', '&d=', '&e=', '&f=', '&g='], ['', ',', ',', ',', ',', ',', ',', ','], $b);
        $d = explode(',', $c); //output $kabupaten = Array ( [0] => 2020 [1] => 16 [2] => 212 [3] => Kab. Madiun )        
        return $d;
    }

    public function Sys($param) {
        return $this->CI->M_default->Sys()->$param;
    }

    public function Csrf() {
        $csrf = array(
            'name' => $this->CI->security->get_csrf_token_name(),
            'hash' => $this->CI->security->get_csrf_hash()
        );
        return $csrf;
    }

    public function Set_session($param) {
        $data = [
            'id_user' => Enkrip($param->id_user),
            'uname' => $param->uname,
            'fullname' => $param->fullname,
            'stat_aktif' => Enkrip($param->stat_aktif),
            'role_id' => Enkrip($param->role_id),
            'role_name' => $param->role_name,
            'avatar' => $param->pict
        ];
        $this->CI->session->set_userdata($data);
    }

    public function Compro() {
        $exec = $this->CI->db->select('option_name,option_value,description,stat')
                ->from('compro_option')
                ->where('`compro_option`.`stat`', 1, false)
                ->get()
                ->result();
        $data = [];
        foreach ($exec as $value) {
            $data[$value->option_name] = $value->option_value;
        }
        return $data;
    }

    public function List_service() {
        $exec = $this->CI->db->select('dt_services.nama,dt_post.id AS id_post')
                ->from('dt_services')
                ->join('dt_post', 'dt_services.id = dt_post.post_title', 'LEFT')
                ->where('dt_post.post_title IN', '(SELECT dt_post.post_title FROM dt_post WHERE dt_post.post_title = dt_services.id)', false)
                ->get()
                ->result();
        foreach ($exec as $post_title) {
            $new_arr[] = (object) [
                        'id' => Enkrip($post_title->id_post),
                        'nama' => $post_title->nama
            ];
        }
        return $new_arr;
    }

}
