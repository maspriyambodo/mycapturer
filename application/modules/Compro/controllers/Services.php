<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Product:        System of AU+ PRODUCTION
 * License Type:   Company
 * Access Type:    Multi-User
 * License:        https://maspriyambodo.com
 * maspriyambodo@gmail.com
 * 
 * Thank you,
 * maspriyambodo
 */

/**
 * Description of Profile
 *
 * @author centos
 */
class Services extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Services', 'model');
        $this->load->model('Blog/M_post');
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
    }

    public function List() {
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
        $data['content'] = $this->parser->parse('services/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Add() {
        $data = [
            'nama' => Post_input('nametxt'),
            'desc' => Post_input('desctxt'),
            'syscreateuser' => $this->user + false,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Add($data);
    }

    public function Delete() {
        $id = $this->bodo->Dec(Post_input('d_id'));
        $data = [
            'stat' => 0 + false,
            'sysdeleteuser' => $this->user + false,
            'sysdeletedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Delete($data, $id);
    }

    public function Get_detail() {
        $id = $this->bodo->Dec(Post_get('id'));
        $exec = $this->model->Get_detail($id);
        return ToJson($exec);
    }

    public function Update() {
        $id = $this->bodo->Dec(Post_get('e_id'));
        $data = [
            'nama' => Post_input('e_nametxt'),
            'desc' => Post_input('e_desctxt'),
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Update($data, $id);
    }

    public function Activate() {
        $id = $this->bodo->Dec(Post_get('act_id'));
        $data = [
            'stat' => 1,
            'sysupdateuser' => $this->user + false,
            'sysupdatedate' => date('Y-m-d H:i:s')
        ];
        $this->model->Activate($data, $id);
    }

    public function Pages() {
        $data = [
            'data' => $this->model->Page_lists(),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Compro/Services/Pages/',
            'privilege' => $this->bodo->Check_previlege('Compro/Services/Pages/'),
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
        $data['content'] = $this->parser->parse('services/v_page_lists', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Pages_add() {
        $post_title = $this->model->post_title();
        $data = [
            'post_title' => $post_title,
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Compro/Services/Pages/',
            'privilege' => $this->bodo->Check_previlege('Compro/Services/Pages/'),
            'siteTitle' => 'Add new page | ' . $this->bodo->Sys('app_name'),
            'pagetitle' => 'Add new page',
            'breadcrumb' => [
                0 => [
                    'nama' => 'index',
                    'link' => base_url('Compro/Services/Pages/'),
                    'status' => false
                ],
                [
                    'nama' => 'Add',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('services/add_page', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function save_page() {
        $post_tags = str_replace([' ', '.'], '', Post_input('post_tags'));
        $post_title = $this->bodo->Dec(Post_input('post_title'));
        $data = [
            'post_content' => $this->input->post('post_content', false),
            'post_title' => $post_title,
            'post_status' => 4 + false,
            'comment_status' => 2 + false,
            'post_category' => 1 + false,
            'post_tags' => $post_tags,
            'post_thumbnail' => null,
            'syscreateuser' => $this->user,
            'syscreatedate' => date('Y-m-d H:i:s')
        ];
        $this->model->save_page($data);
    }

}
