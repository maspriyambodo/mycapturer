<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_post extends CI_Model {

    var $table = 'post_index';
    var $column_order = [null, 'post_title', 'uname', 'category', 'syscreatedate', 'viewers', null, null]; //set column field database for datatable orderable
    var $column_search = ['post_title', 'uname', 'category', 'syscreatedate']; //set column field database for datatable searchable 
    var $order = ['id' => 'asc']; // default order

    private function role_name() {
        $role_id = $this->bodo->Dec($this->session->userdata('role_id'));
        $id_user = $this->bodo->Dec($this->session->userdata('id_user'));
        if ($role_id == 1) {
            $exec = $this->db->from($this->table)
                    ->where($this->table . '.`post_status` <>', 4, false);
        } else {
            $exec = $this->db->from($this->table)
                    ->where($this->table . '.`id_user`', $id_user, false)
                    ->where($this->table . '.`post_status` <>', 4, false);
        }
        return $exec;
    }

    private function _get_datatables_query() {
        $this->role_name();
        $i = 0;
        foreach ($this->column_search as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function lists() {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->role_name();
        return $this->db->count_all_results();
    }

    public function Category() {
        $exec = $this->db->select('dt_post_category.id, dt_post_category.category')
                ->from('dt_post_category')
                ->where('`dt_post_category`.`stat`', 1, false)
                ->get()
                ->result();
        return $exec;
    }

    public function Save($data) {
        $this->db->trans_begin();
        $this->db->insert('dt_post', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Blog/Post/index/'), $this->session->set_flashdata('err_msg', 'failed, error while processing new post!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Blog/Post/index/'), $this->session->set_flashdata('succ_msg', 'success, new post has been saving!'));
        }
    }

    public function Update($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_post`.`id`', $id, false)
                ->update('dt_post');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Blog/Post/index/'), $this->session->set_flashdata('err_msg', 'failed, error while updating post!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Blog/Post/index/'), $this->session->set_flashdata('succ_msg', 'success, post has been updating!'));
        }
    }

    public function Post($id) {
        $exec = $this->db->select('`dt_post`.`id` AS `id`,`dt_post`.`post_tags`,`dt_post`.`post_content`, `dt_post`.`post_title`, `dt_post`.`post_status`, `dt_post`.`viewers`, `dt_post`.`comment_status`, `dt_post`.`syscreateuser`, `dt_post`.`syscreatedate`,`dt_post`.`post_thumbnail`, `sys_users`.`uname`, `sys_users`.`id` AS `id_user`, `dt_post_category`.`id` AS `id_category`, `dt_post_category`.`category`')
                ->from('dt_post')
                ->join('sys_users', '`dt_post`.`syscreateuser` = `sys_users`.`id`', 'LEFT')
                ->join('dt_post_category', '`dt_post`.`post_category` = `dt_post_category`.`id`', 'LEFT')
                ->where('dt_post.id', $id, false)
                ->get()
                ->row_array();
        return $exec;
    }

    public function Delete($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_post`.`id`', $id, false)
                ->update('dt_post');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Blog/Post/index/'), $this->session->set_flashdata('err_msg', 'failed, error while deleting post!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Blog/Post/index/'), $this->session->set_flashdata('succ_msg', 'success, post has been deleting!'));
        }
    }

    public function Activated($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_post`.`id`', $id, false)
                ->update('dt_post');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Blog/Post/index/'), $this->session->set_flashdata('err_msg', 'failed, error while activating post!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Blog/Post/index/'), $this->session->set_flashdata('succ_msg', 'success, post has been activating!'));
        }
    }

}
