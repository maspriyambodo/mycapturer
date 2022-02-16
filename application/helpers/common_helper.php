<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function print_array($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function ToJson($response) {
    $ci = & get_instance();
    $ci->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
    exit;
}

function sys_parameter($param) {
    $ci = & get_instance();
    $exec = $ci->db->select('sys_param.id,sys_param.param_group,sys_param.param_value')
            ->from('sys_param')
            ->where('sys_param.id', $param)
            ->limit(1)
            ->get()
            ->result();
    foreach ($exec as $value) {
        $data = [
            'id' => $value->id,
            'param_group' => $value->param_group,
            'param_value' => $value->param_value
        ];
    }
    return $data;
}

function Post_input($param) {
    $ci = & get_instance();
    return $ci->input->post($param, true);
}

function Post_get($param) {
    $ci = & get_instance();
    return $ci->input->post_get($param, true);
}

function Enkrip($param) {
    $ci = & get_instance();
    $result = str_replace(['+', '/', '='], ['-', '_', '~'], $ci->encryption->encrypt($param));
    return $result;
}

function Dekrip($enc) {//sama saja dengan libraries Bodo $this->bodo->Dec();
    $ci = & get_instance();
    $encrypt = str_replace(['-', '_', '~'], ['+', '/', '='], $enc);
    $dec = $ci->encryption->decrypt($encrypt);
    return $dec;
}

function _Upload($param) {
    $ci = & get_instance();
    $result = [];
    $config['upload_path'] = FCPATH . $param['upload_path'];
    $config['file_name'] = $param['file_name'];
    $config['allowed_types'] = 'gif|jpg|png|gif|ico';
//    $config['max_size'] = 1000;
    $config['maintain_ratio'] = true;
    $config['file_ext_tolower'] = true;
    $config['remove_spaces'] = true;
    $config['overwrite'] = true;
    $ci->load->library('upload', $config);
    if ($ci->upload->do_upload($param['input_name']) == true) {
        $result = $ci->upload->data();
        $result['status'] = true;
    } else {
        $result['status'] = false;
    }
    return $result;
}

function auth_sekuriti() {
    $ci = get_instance();
    $ci->output->set_status_header(200);
    $ci->load->view('errors/cli/auth_sekuriti');
    echo $ci->output->get_output();
    exit(4);
}
