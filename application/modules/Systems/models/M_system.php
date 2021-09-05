<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_system extends CI_Model {

    public function Favico($data) {
        $this->db->trans_begin();
        $this->db->set($data['field'], $data['file_name'])
                ->update('sys_app');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $status = false;
        } else {
            $this->db->trans_commit();
            $status = true;
        }
        return $status;
    }

    public function Old_pwd($param) {
        $exec = $this->db->select('sys_users.pwd')
                ->from('sys_users')
                ->where('`sys_users`.`id`', $param, false)
                ->get()
                ->row();
        return $exec;
    }

    public function Update_pwd($param) {
        $this->db->trans_begin();
        $this->db->set([
                    'sys_users.pwd' => $param['pwd'],
                    'sys_users.sysupdateuser' => $param['id_user'],
                    'sys_users.sysupdatedate' => date('Y-m-d H:i:s')
                ])
                ->where([
                    '`sys_users`.`id`' => $param['id_user'] + false,
                    '`sys_users`.`stat`' => 1 + false
                ])
                ->update('sys_users');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $status = redirect(base_url('Change%20Password'), $this->session->set_flashdata('err_msg', 'error, Password failed to change'));
        } else {
            $this->db->trans_commit();
            $status = redirect(base_url('Change%20Password'), $this->session->set_flashdata('succ_msg', 'Password has been changed'));
        }
        return $status;
    }

    public function Update($data) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->update('sys_app');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $status = redirect(base_url('Systems/index/'), $this->session->set_flashdata('err_msg', 'error, while saving data!'));
        } else {
            $this->db->trans_commit();
            $status = redirect(base_url('Systems/index/'), $this->session->set_flashdata('succ_msg', 'success saving data!'));
        }
        return $status;
    }

    public function Profile($id) {//query saved on navicat with name query_1
        $exec = $this->db->select('sys_users.id,sys_users.uname,sys_users.role_id,sys_users.pict,sys_roles.`name` AS name_role,dt_users.id AS id_dt_users,dt_users.nama AS nama_lengkap,dt_users.jenis_kelamin,dt_users.id_number,dt_users.lahir_1,dt_users.lahir_2,dt_users.address_1,dt_users.address_provinsi,dt_users.address_kabupaten,dt_users.address_kecamatan,dt_users.address_kelurahan,dt_users.mail,dt_users.telp')
                ->from('sys_users')
                ->join('sys_roles', 'sys_users.role_id = sys_roles.id', 'INNER')
                ->join('dt_users', 'sys_users.id = dt_users.sys_user_id', 'INNER')
                ->where('`sys_users`.`id`', $id, false)
                ->get()
                ->result();
        return $exec;
    }

    public function Provinsi() {
        $exec = $this->db->select('mt_wil_provinsi.id_provinsi, mt_wil_provinsi.nama')
                ->from('mt_wil_provinsi')
                ->get()
                ->result();
        return $exec;
    }

    public function Getkab($id) {
        $exec = $this->db->select('`mt_wil_kabupaten`.`id_kabupaten`, `mt_wil_kabupaten`.`id_provinsi`, `mt_wil_kabupaten`.`nama` AS `kabupaten`')
                ->from('`mt_wil_kabupaten`')
                ->where([
                    '`mt_wil_kabupaten`.`is_actived`' => 1,
                    '`mt_wil_kabupaten`.`id_provinsi`' => $id
                ])
                ->get()
                ->result();
        $a[0] = array('kabupaten' => 'Choose Kabupaten');
        $b = array_merge($a, $exec);
        return $b;
    }

    public function Getkec($id) {
        $exec = $this->db->select('`mt_wil_kecamatan`.`id_kecamatan`, `mt_wil_kecamatan`.`nama` AS `kecamatan`')
                ->from('`mt_wil_kecamatan`')
                ->where([
                    '`mt_wil_kecamatan`.`is_actived`' => 1 + false,
                    '`mt_wil_kecamatan`.`id_kabupaten`' => $id + false
                ])
                ->get()
                ->result();
        $a[0] = array('kecamatan' => 'Pilih Kecamatan');
        $b = array_merge($a, $exec);
        return $b;
    }

    public function Getkel($id) {
        $exec = $this->db->select('`mt_wil_kelurahan`.`id_kelurahan`, `mt_wil_kelurahan`.`nama` AS `kelurahan`')
                ->from('`mt_wil_kelurahan`')
                ->where([
                    '`mt_wil_kelurahan`.`is_actived`' => 1 + false,
                    '`mt_wil_kelurahan`.`id_kecamatan`' => $id + false
                ])
                ->get()
                ->result();
        $a[0] = array('kelurahan' => 'Pilih Kelurahan');
        $b = array_merge($a, $exec);
        return $b;
    }

    public function Profile_save($data) {
        $this->db->trans_begin();
        $this->db->set($data['sys_users'])
                ->where('`sys_users`.`id`', $data['id_user'], false)
                ->update('sys_users');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Setting%20Profile'));
        } else {
            $this->db->trans_commit();
            $this->dt_users($data);
        }
    }

    private function dt_users($data) {
        $this->db->trans_begin();
        $this->db->set($data['dt_users'])
                ->where('`dt_users`.`sys_user_id`', $data['id_user'], false)
                ->update('dt_users');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Setting%20Profile'), $this->session->set_flashdata('err_msg', 'error, error while update'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Setting%20Profile'), $this->session->set_flashdata('succ_msg', 'Success, data has been updated'));
        }
    }

    public function Check_uname($uname) {
        $exec = $this->db->select('sys_users.id')
                ->from('sys_users')
                ->where('sys_users.uname', $uname)
                ->limit(1)
                ->get()
                ->row();
        return $exec;
    }

}
