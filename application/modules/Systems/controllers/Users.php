<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_users');
        $this->user = Dekrip($this->session->userdata('id_user'));
    }

    public function index() {
        $data = [
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Systems/Users/index/',
            'privilege' => $this->bodo->Check_previlege('Systems/Users/index/'),
            'siteTitle' => 'Users Management',
            'pagetitle' => 'User Management',
            'breadcrumb' => [
                0 => [
                    'nama' => 'User Management',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('users/index', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function lists() {
        $list = $this->M_users->lists();
        $data = [];
        $no = Post_get("start");
        $privilege = $this->bodo->Check_previlege('Systems/Users/index/');
        foreach ($list as $users) {
            $id_user = Enkrip($users->id);
            if ($users->stat) {
                $stat = '<span class="label label-success label-inline font-weight-lighter mr-2">active</span>';
            } else {
                $stat = '<span class="label label-danger label-inline font-weight-lighter mr-2">nonactive</span>';
            }
            if ($privilege['update']) {
                $editbtn = '<button id="edit_user" type="button" class="btn btn-icon btn-default btn-xs" title="Edit ' . $users->uname . '" value="' . $id_user . '" onclick="Edit(this.value)"><i class="far fa-edit"></i></button>';
            } else {
                $editbtn = null;
            }
            if ($privilege['delete'] and $users->stat) {
                $activebtn = null;
                $delbtn = '<button id="del_user" type="button" class="btn btn-icon btn-danger btn-xs" title="Delete ' . $users->uname . '" value="' . $id_user . '" onclick="Delete(this.value)"><i class="far fa-trash-alt"></i></button>';
                $reset_pwd = '<button id="reset_password" type="button" class="btn btn-icon btn-default btn-xs" title="Reset Password ' . $users->uname . '" value="' . $id_user . '" onclick="Reset_pwd(this.value)"><i class="fas fa-key"></i></button>';
            } elseif ($privilege['delete'] and!$users->stat) {
                $delbtn = null;
                $reset_pwd = '<button id="reset_password" type="button" class="btn btn-icon btn-default btn-xs" title="Reset Password ' . $users->uname . '" value="' . $id_user . '" onclick="Reset_pwd(this.value)"><i class="fas fa-key"></i></button>';
                $activebtn = '<button id="act_user" type="button" class="btn btn-icon btn-success btn-xs" title="Activate ' . $users->uname . '" value="' . $id_user . '" onclick="Active(this.value)"><i class="fas fa-unlock"></i></button>';
            } else {
                $delbtn = null;
                $activebtn = null;
                $reset_pwd = null;
            }
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $users->uname;
            $row[] = $users->name;
            $row[] = $stat;
            $row[] = '<div class="btn-group">' . $editbtn . $reset_pwd . $delbtn . $activebtn . '</div>';
            $data[] = $row;
        }
        return $this->_list($data, $privilege);
    }

    private function _list($data, $privilege) {
        if ($privilege['read']) {
            $output = [
                "draw" => Post_get('draw'),
                "recordsTotal" => $this->M_users->count_all(),
                "recordsFiltered" => $this->M_users->count_filtered(),
                "data" => $data
            ];
        } else {
            $output = [
                "draw" => Post_get('draw'),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => []
            ];
        }
        return ToJson($output);
    }

    public function Add() {
        $data = [
            'role' => $this->M_users->Role(0),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Systems/Users/index/',
            'privilege' => $this->bodo->Check_previlege('Systems/Users/index/'),
            'siteTitle' => 'Add new User',
            'pagetitle' => 'Add user',
            'breadcrumb' => [
                0 => [
                    'nama' => 'User Management',
                    'link' => base_url('Systems/Users/index/'),
                    'status' => false
                ],
                1 => [
                    'nama' => 'Add',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('users/add', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Save() {
        $param = [
            'upload_path' => 'assets/images/users/',
            'file_name' => 'users' . date('d_His'),
            'input_name' => "profile_avatar",
            'allowed_types' => 'gif|jpg|png|gif|ico'
        ];
        $pict = _Upload($param);
        $role_user = Dekrip(Post_input('role_user'));
        if (!$pict['status']) {
            $file_name = 'blank.png';
        } else {
            $file_name = $pict['file_name'];
        }
        $data = [
            'uname' => Post_input('uname'),
            'pwd' => password_hash("a", PASSWORD_DEFAULT),
            'role_id' => $role_user,
            'pict' => $file_name,
            'stat' => 1,
            'user_login' => $this->user
        ];
        return $this->_Save($data);
    }

    private function _Save($data) {
        if ($data['role_id'] == sys_parameter('SUPER_USER')['param_value'] and Dekrip($this->session->userdata('role_id')) != sys_parameter('SUPER_USER')['param_value']) {
            $result = redirect(base_url('Systems/Users/Add/'), $this->session->set_flashdata('err_msg', 'failed, error while processing user data!'));
        } else {
            $result = $this->M_users->Save($data);
        }
        return $result;
    }

    public function Check_uname() {
        $uname = Post_get('nama');
        $check = $this->M_users->Check($uname);
        if ($check) {
            $response = [
                'status' => true,
                'msg' => 'username already exist'
            ];
        } else {
            $response = [
                'status' => false,
                'msg' => 'username available to use'
            ];
        }
        return ToJson($response);
    }

    public function Delete() {
        $id_user = Dekrip(Post_input("e_id"));
        $data = [
            'id_user' => $id_user,
            'stat_active' => 0,
            'user_login' => $this->user
        ];
        if ($id_user == 1) {
            $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('err_msg', 'error, users cannot be deleted!!!'));
        } else {
            $exec = $this->M_users->Stat($data);
            if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
                $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('err_msg', 'error, failed to deleted users!'));
            } else {
                $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('succ_msg', 'success, users has been deleted!'));
            }
        }
        return $result;
    }

    public function Active() {
        $id_user = Dekrip(Post_input("act_id"));
        $data = [
            'id_user' => $id_user,
            'stat_active' => 1,
            'user_login' => $this->user
        ];
        $exec = $this->M_users->Stat($data);
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('err_msg', 'error, failed to activating user!'));
        } else {
            $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('succ_msg', 'success, user has been activated!'));
        }
    }

    public function Edit() {
        $id_user = Dekrip(Post_get('id'));
        $data = [
            'data' => $this->M_users->index(['param' => 'get_detail', 'id_user' => $id_user, 'panjang' => 0, 'mulai' => 0]),
            'role' => $this->M_users->Role(0),
            'csrf' => $this->bodo->Csrf(),
            'item_active' => 'Systems/Users/index/',
            'privilege' => $this->bodo->Check_previlege('Systems/Users/index/'),
            'siteTitle' => 'Edit User',
            'pagetitle' => 'Edit user',
            'breadcrumb' => [
                0 => [
                    'nama' => 'User Management',
                    'link' => base_url('Systems/Users/index/'),
                    'status' => false
                ],
                1 => [
                    'nama' => 'Edit',
                    'link' => null,
                    'status' => true
                ]
            ]
        ];
        $data['content'] = $this->parser->parse('users/edit', $data, true);
        return $this->parser->parse('Template/layout', $data);
    }

    public function Update() {
        $param = [
            'upload_path' => 'assets/images/users/',
            'file_name' => 'users' . date('d_His'),
            'input_name' => "profile_avatar",
            'allowed_types' => 'gif|jpg|png|gif|ico'
        ];
        $pict = _Upload($param);
        $role_user = Dekrip(Post_input('role_user'));
        $old_ava = Post_input("old_ava");
        $id_user = Dekrip(Post_input("id_user"));
        if (!$pict['status'] or empty($pict['status'])) {
            $pict['file_name'] = $old_ava;
        } else {
            unlink('assets/images/users/' . $old_ava);
        }
        $data = [
            'uname' => Post_input('uname'),
            'pwd' => 'update',
            'role_id' => $role_user,
            'pict' => $pict['file_name'],
            'stat' => $id_user, //jika fungsi update maka berubah jadi id user
            'user_login' => $this->user
        ];
        return $this->_Save($data);
    }

    public function Reset() {
        $id = Dekrip(Post_input('reset_id'));
        $role_id = Dekrip($this->session->userdata('role_id'));
        if ($id == 1) {
            if ($role_id != sys_parameter('SUPER_USER')['param_value']) {
                $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('err_msg', 'failed, you don`t have permission for this'));
            } else {
                $data = [
                    'sys_users.pwd' => password_hash(sys_parameter('DEFAULT_PASSWORD')['param_value'], PASSWORD_DEFAULT),
                    '`sys_users`.`login_attempt`' => 0 + false,
                    '`sys_users`.`sysupdateuser`' => $this->user + false,
                    'sys_users.sysupdatedate' => date('Y-m-d H:i:s')
                ];
                $result = $this->M_users->Reset($data, $id);
            }
        } elseif (empty($id) or!$id) {
            $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('err_msg', 'failed, error while processing user data'));
        } else {
            $data = [
                'sys_users.pwd' => password_hash(sys_parameter('DEFAULT_PASSWORD')['param_value'], PASSWORD_DEFAULT),
                '`sys_users`.`login_attempt`' => 0 + false,
                '`sys_users`.`sysupdateuser`' => $this->user + false,
                'sys_users.sysupdatedate' => date('Y-m-d H:i:s')
            ];
            $result = $this->M_users->Reset($data, $id);
        }
        return $result;
    }

}
