<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->user_id = Dekrip($this->session->userdata('id_user'));
        $this->role_id = Dekrip($this->session->userdata('role_id'));
        $this->load->library('App_notification');
        $this->load->model('M_notification', 'model');
        $this->bodo->Check_login();
    }

    public function index() {
        $data = [
            'title_notif' => 'example notification title',
            'url' => 'javascript:void(0);',
            'icon_text' => base_url('assets/media/svg/misc/006-plurk.svg'),
            'role_id' => $this->role_id,
            'syscreateuser' => $this->user_id,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        $exec = $this->model->_Save($data);
        if (!$exec) {
            $this->db->trans_rollback();
            log_message('error', 'error while saving notification!');
            $result = null;
        } else {
            $this->db->trans_commit();
            $result = $this->app_notification->Count_notif();
        }
        return $result;
    }

    public function Save_($param) {
        $data = [
            'title_notif' => $param['title_notif'],
            'url' => $param['url'],
            'icon_text' => $param['icon_text'],
            'role_id' => $this->role_id,
            'syscreateuser' => $this->user_id,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        $exec = $this->model->_Save($data);
        if (!$exec) {
            $this->db->trans_rollback();
            log_message('error', 'error while saving notification!');
            $result = null;
        } else {
            $this->db->trans_commit();
            $result = $this->app_notification->Count_notif();
        }
        return $result;
    }

    public function Get_notif() {
        if ($this->role_id == 1) {
            $exec = $this->model->Get_notif_su();
        } else {
            $exec = $this->model->Get_notif();
        }
        if (!empty($exec)) {
            foreach ($exec as $value) {
                $syscreatedate = new DateTime($value->syscreatedate);
                $stringDate = $syscreatedate->format('d M Y H:i:s');
                $result[] = (object) [
                            'title_notif' => $value->title_notif,
                            'syscreatedate' => $stringDate,
                            'url_link' => $value->url
                ];
            }
        } else {
            $result[] = (object) [
                        'title_notif' => 'kosong',
                        'tot_notif' => $this->bodo->Count_notif()
            ];
        }
        return ToJson($result);
    }

    public function Mark_all_read() {
        $this->model->Mark_all_read();
    }

}
