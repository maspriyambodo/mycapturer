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
class Gallery extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_Gallery', 'model');
        $this->user = $this->bodo->Dec($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Compro/Gallery/index/',
            'privilege' => $this->bodo->Check_previlege('Compro/Gallery/index/'),
            'siteTitle' => 'Portfolio Gallery | Company Profile',
            'pagetitle' => 'Portfolio',
            'breadcrumb' => [
                0 => [
                    'nama' => 'index',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('galeri/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Lists() {
        $list = $this->model->lists();
        $data = [];
        $no = Post_input("start");
        $privilege = $this->bodo->Check_previlege('Compro/Gallery/index/');
        foreach ($list as $galeri) {
            $id = Enkrip($galeri->id);
            if ($galeri->tipe == 'image') {
                $path_portfolio = base_url('assets/images/portfolio/highres/' . $galeri->highres);
            } elseif ($galeri->tipe == 'video') {
                $path_portfolio = base_url('assets/images/portfolio/highres/' . $galeri->highres);
            } else {
                $path_portfolio = $galeri->highres;
            }
            $pict = '<div class="gallery">'
                    . '<a href="' . $path_portfolio . '" class="image-link">'
                    . '<img src="' . base_url('assets/images/portfolio/' . $galeri->lowres) . '" alt="' . $galeri->title . '" onclick="Gallery(\'' . $galeri->tipe . '\')" style="height:50px;"/>'
                    . '</a>'
                    . '</div>';
            if ($galeri->stat == 1) {
                $stat = '<span class="label label-success label-inline font-weight-lighter mr-2">active</span>';
            } else {
                $stat = '<span class="label label-danger label-inline font-weight-lighter mr-2">nonactive</span>';
            }
            if ($privilege['update']) {
                $editbtn = '<button id="edit_user" type="button" class="btn btn-icon btn-default btn-xs" title="Edit" value="' . $id . '" onclick="Edit(this.value)"><i class="far fa-edit"></i></button>';
            } else {
                $editbtn = null;
            }
            if ($privilege['delete'] and $galeri->stat) {
                $activebtn = null;
                $delbtn = '<button id="del_user" type="button" class="btn btn-icon btn-danger btn-xs" title="Delete" value="' . $id . '" data-toggle="modal" data-target="#modal_delete" onclick="Delete(this.value)"><i class="far fa-trash-alt"></i></button>';
            } elseif ($privilege['delete'] and!$galeri->stat) {
                $delbtn = null;
                $activebtn = '<button id="act_user" type="button" class="btn btn-icon btn-success btn-xs" title="Activate" value="' . $id . '" data-toggle="modal" data-target="#modal_active" onclick="Active(this.value)"><i class="fas fa-unlock"></i></button>';
            } else {
                $delbtn = null;
                $activebtn = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $galeri->tipe;
            $row[] = $galeri->title;
            $row[] = $pict;
//            $row[] = $galeri->highres;
            $row[] = $galeri->desc;
            $row[] = $stat;
            $row[] = '<div class="btn-group">' . $editbtn . $delbtn . $activebtn . '</div>';
            $data[] = $row;
        }
        return $this->_list($data, $privilege);
    }

    private function _list($data, $privilege) {
        if ($privilege['read']) {
            $output = [
                "draw" => Post_input('draw'),
                "recordsTotal" => $this->model->count_all(),
                "recordsFiltered" => $this->model->count_filtered(),
                "data" => $data
            ];
        } else {
            $output = [
                "draw" => Post_input('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        }
        ToJson($output);
    }

    public function Add() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Compro/Gallery/index/',
            'privilege' => $this->bodo->Check_previlege('Compro/Gallery/index/'),
            'siteTitle' => 'Add new | Company Profile',
            'pagetitle' => 'Add new gallery',
            'breadcrumb' => [
                0 => [
                    'nama' => 'index',
                    'link' => base_url('Compro/Gallery/index/'),
                    'status' => false
                ],
                1 => [
                    'nama' => 'add',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('galeri/add', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Upload_image($inputtxt) {
        if ($inputtxt == 'thmbtxt' or $inputtxt == 'thmbvidtxt' or $inputtxt == 'thmbyttxt') {
            $upload_path = 'assets/images/portfolio/';
            $input_name = $inputtxt;
        } else {
            $upload_path = 'assets/images/portfolio/highres/';
            $input_name = $inputtxt;
        }
        $param = [
            'upload_path' => $upload_path,
            'file_name' => date('Y_m_d_H_i_s'),
            'input_name' => $input_name,
            'allowed_types' => 'jpg|png|jpeg|mp4|mkv|avi'
        ];
        $upload = _Upload($param);
        $response = [
            'stat' => $upload['status'],
            'file_name' => $upload['file_name']
        ];
        ToJson($response);
    }

    public function Save() {
        if (!Post_input('tipetxt')) {
            redirect(base_url('Compro/Gallery/index/'), $this->session->set_flashdata('err_msg', 'error, while adding new gallery!'));
        } elseif (Post_input('tipetxt') == 1) {
            $result = $this->Galeri_img();
        } elseif (Post_input('tipetxt') == 2) {
            $result = $this->Galeri_img();
        } elseif (Post_input('tipetxt') == 3) {
            $result = $this->Gallery_yt();
        }
        return $result;
    }

    private function Galeri_img() {
        $lowres = FCPATH . 'assets/images/portfolio/' . Post_input('thumbnail_txt');
        $highres = FCPATH . 'assets/images/portfolio/highres/' . Post_input('highres_txt');
        if (file_exists($lowres) and file_exists($highres)) {
            $data = [
                'lowres' => Post_input('thumbnail_txt'),
                'highres' => Post_input('highres_txt'),
                'title' => Post_input('titletxt'),
                '`desc`' => Post_input('desctxt'),
                '`tipe`' => Post_input('tipetxt') + false,
                'syscreateuser' => $this->user + false,
                'syscreatedate' => date('Y-m-d H:i:s')
            ];
            $result = $this->model->Galeri_img($data);
        } else {
            unlink($lowres);
            unlink($highres);
            $result = redirect('Compro/Gallery/Add/', $this->session->set_flashdata('err_msg', 'error, while adding new gallery!'));
        }
        return $result;
    }

    private function Gallery_yt() {
        $lowres = FCPATH . 'assets/images/portfolio/' . Post_input('thumbnail_txt');
        if (file_exists($lowres)) {
            $data = [
                'lowres' => Post_input('thumbnail_txt'),
                'highres' => Post_input('linktxt'),
                'title' => Post_input('titletxt'),
                '`desc`' => Post_input('desctxt'),
                '`tipe`' => Post_input('tipetxt') + false,
                'syscreateuser' => $this->user + false,
                'syscreatedate' => date('Y-m-d H:i:s')
            ];
            $result = $this->model->Galeri_img($data);
        } else {
            unlink($lowres);
            $result = redirect('Compro/Gallery/Add/', $this->session->set_flashdata('err_msg', 'error, while adding new gallery!'));
        }
        return $result;
    }

    public function Edit() {
        $id = $this->bodo->Dec(Post_get('token'));
        $data = [
            'data' => $this->model->_GetDetail($id),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Compro/Gallery/index/',
            'privilege' => $this->bodo->Check_previlege('Compro/Gallery/index/'),
            'siteTitle' => 'Edit gallery | Company Profile',
            'pagetitle' => 'Edit gallery',
            'breadcrumb' => [
                0 => [
                    'nama' => 'index',
                    'link' => base_url('Compro/Gallery/index/'),
                    'status' => false
                ],
                1 => [
                    'nama' => 'edit',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('galeri/edit', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Detail() {
        $id = $this->bodo->Dec(Post_get('token'));
        $exec = $this->model->_GetDetail($id);
        ToJson($exec);
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

}
