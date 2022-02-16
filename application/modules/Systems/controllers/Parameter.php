<?php

defined('BASEPATH') OR exit('trying to signin from backdoor?');

class Parameter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_param', 'model');
        $this->user = Dekrip($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'data' => $this->model->index(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Systems/Parameter/index/',
            'privilege' => $this->bodo->Check_previlege('Systems/Parameter/index/'),
            'siteTitle' => 'Parameters Management | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'System Parameters',
            'breadcrumb' => [
                0 => [
                    'nama' => 'index',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('param/param_index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function check_id() {
        $exec = $this->model->check_id(Post_get('param_id'));
        if ($exec) {
            $response = [
                'stat' => false
            ];
        } else {
            $response = [
                'stat' => true
            ];
        }
        return ToJson($response);
    }

    public function add() {
        $data = [
            'id' => str_replace(' ', '_', strtoupper(Post_input('param_id'))),
            'param_group' => str_replace(' ', '_', strtoupper(Post_input('grouptxt'))),
            'param_value' => Post_input('valtxt'),
            'param_desc' => Post_input('desctxt'),
            '`stat`' => 1 + false,
            '`syscreateuser`' => $this->user + false,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        $exec = $this->model->_add($data);
        if ($exec) {
            $result = redirect(base_url('Systems/Parameter/index/'), $this->session->set_flashdata('succ_msg', '<b>' . $data['id'] . '</b> has beed added'));
        } else {
            $result = redirect(base_url('Systems/Parameter/index/'), $this->session->set_flashdata('err_msg', 'error while saving data!'));
        }
        return $result;
    }

    public function update() {
        $old_param = Post_input('param_stat2');
        $data = [
            'id' => str_replace(' ', '_', strtoupper(Post_input('param_id2'))),
            'param_group' => str_replace(' ', '_', strtoupper(Post_input('grouptxt2'))),
            'param_value' => Post_input('valtxt2'),
            'param_desc' => Post_input('desctxt2'),
            '`sysupdateuser`' => $this->user + false,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        $exec = $this->model->_update($old_param, $data);
        if ($exec) {
            $result = redirect(base_url('Systems/Parameter/index/'), $this->session->set_flashdata('succ_msg', '<b>' . $data['id'] . '</b> has beed changed'));
        } else {
            $result = redirect(base_url('Systems/Parameter/index/'), $this->session->set_flashdata('err_msg', 'error while updating data!'));
        }
        return $result;
    }

    public function delete() {
        $old_param = Dekrip(Post_input('param_id3'));
        if (!empty($old_param)) {
            $nama_param = Post_input('nama_param');
            $data = [
                '`stat`' => 0 + false,
                '`sysdeleteuser`' => $this->user + false,
                'sysdeletedate' => date('Y-m-d H:i:s')
            ];
            $exec = $this->model->_update($old_param, $data);
            if ($exec) {
                $result = redirect(base_url('Systems/Parameter/index/'), $this->session->set_flashdata('succ_msg', '<b>' . $nama_param . '</b> has beed changed'));
            } else {
                $result = redirect(base_url('Systems/Parameter/index/'), $this->session->set_flashdata('err_msg', 'error while updating data!'));
            }
        } else {
            $result = redirect(base_url('Systems/Parameter/index/'), $this->session->set_flashdata('err_msg', 'error while updating data!'));
        }
        return $result;
    }

    public function get_detail() {
        $id = Dekrip(Post_get('token'));
        $exec = $this->model->_detail($id);
        if (!empty($exec)) {
            foreach ($exec as $value) {
                $response = [
                    'stat' => true,
                    'id' => $value->id,
                    'param_group' => $value->param_group,
                    'param_value' => $value->param_value,
                    'param_desc' => $value->param_desc
                ];
            }
        } else {
            $response = [
                'stats' => false
            ];
        }
        return ToJson($response);
    }

}
