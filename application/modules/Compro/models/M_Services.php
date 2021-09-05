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
class M_Services extends CI_Model {

    public function index() {
        $exec = $this->db->select('id,nama,desc,stat')
                ->from('dt_services')
                ->get()
                ->result();
        return $exec;
    }

    public function Add($data) {
        $this->db->trans_begin();
        $this->db->insert('dt_services', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Services/List/'), $this->session->set_flashdata('err_msg', 'failed, error while adding data'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Services/List/'), $this->session->set_flashdata('succ_msg', 'success, services lists has been added'));
        }
        return $result;
    }

    public function Delete($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_services`.`id`', $id, false)
                ->update('dt_services');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Services/List/'), $this->session->set_flashdata('err_msg', 'failed, error while deleting data'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Services/List/'), $this->session->set_flashdata('succ_msg', 'success, services lists has been deleted'));
        }
        return $result;
    }

    public function Get_detail($id) {
        $exec = $this->db->select('nama,desc')
                ->from('dt_services')
                ->where('`dt_services`.`id`', $id, false)
                ->get()
                ->row();
        return $exec;
    }

    public function Update($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_services`.`id`', $id, false)
                ->update('dt_services');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Services/List/'), $this->session->set_flashdata('err_msg', 'failed, error while updating data'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Services/List/'), $this->session->set_flashdata('succ_msg', 'success, services lists has been updated'));
        }
        return $result;
    }

    public function Activate($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_services`.`id`', $id, false)
                ->update('dt_services');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Services/List/'), $this->session->set_flashdata('err_msg', 'failed, error while activating data'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Services/List/'), $this->session->set_flashdata('succ_msg', 'success, services lists has been activated'));
        }
        return $result;
    }

    public function post_title() {
        $exec = $this->db->select('dt_services.id, dt_services.nama')
                ->from('dt_services')
                ->join('dt_post', 'dt_services.id = dt_post.post_title', 'LEFT')
                ->where('dt_services.stat', 1, false)
                ->where('dt_services.id NOT IN', '(SELECT dt_post.post_title FROM dt_post WHERE dt_post.post_status = 4 )', false)
                ->get()
                ->result();
        foreach ($exec as $post_title) {
            $new_arr[] = (object) [
                        'id' => Enkrip($post_title->id),
                        'nama' => $post_title->nama
            ];
        }
        return $new_arr;
    }

    public function Page_lists() {
        $exec = $this->db->select('dt_post.id AS id_post,dt_services.nama AS post_title,sys_users.uname,dt_post.syscreatedate,dt_post.viewers')
                ->from('dt_post')
                ->join('dt_services', 'dt_post.post_title = dt_services.id', 'LEFT')
                ->join('sys_users', 'dt_post.syscreateuser = sys_users.id ', 'INNER')
                ->where('`dt_post`.`post_status`', 4, false)
                ->get()
                ->result();
        return $exec;
    }

    public function save_page($data) {
        $this->db->trans_begin();
        $this->db->insert('dt_post', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Services/Pages/'), $this->session->set_flashdata('err_msg', 'failed, error while saving new page'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Services/Pages/'), $this->session->set_flashdata('succ_msg', 'success, services page has been added'));
        }
        return $result;
    }

}
