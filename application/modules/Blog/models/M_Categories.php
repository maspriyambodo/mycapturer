<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Categories extends CI_Model {

    var $table = 'dt_post_category';
    var $column_order = [null, 'category', 'descriptions', 'stat', null]; //set column field database for datatable orderable
    var $column_search = ['category', 'descriptions']; //set column field database for datatable searchable 
    var $order = ['id' => 'asc']; // default order

    private function _get_datatables_query() {
        $this->db->from($this->table);
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function Save($data) {
        $this->db->trans_begin();
        $this->db->insert('dt_post_category', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Blog/Categories/index/'), $this->session->set_flashdata('err_msg', 'failed, error while processing new category!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Blog/Categories/index/'), $this->session->set_flashdata('succ_msg', 'success, new category has been saving!'));
        }
    }

    public function Update($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_post_category`.`id`', $id, false)
                ->update('dt_post_category');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Blog/Categories/index/'), $this->session->set_flashdata('err_msg', 'failed, error while updating category <b>' . $data['category'] . '</b>!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Blog/Categories/index/'), $this->session->set_flashdata('succ_msg', 'success, category <b>'. $data['category'] .'</b> has been updated!'));
        }
    }
    
    public function Delete($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_post_category`.`id`', $id, false)
                ->update('dt_post_category');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Blog/Categories/index/'), $this->session->set_flashdata('err_msg', 'failed, error while deleting category!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Blog/Categories/index/'), $this->session->set_flashdata('succ_msg', 'success, category has been deleted!'));
        }
    }
    
    public function Activate($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_post_category`.`id`', $id, false)
                ->update('dt_post_category');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Blog/Categories/index/'), $this->session->set_flashdata('err_msg', 'failed, error while activating category!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Blog/Categories/index/'), $this->session->set_flashdata('succ_msg', 'success, category has been activated!'));
        }
    }

    public function Get_category($id) {
        $exec = $this->db->select()
                ->from('dt_post_category')
                ->where('`dt_post_category`.`id`', $id, false)
                ->get()
                ->row();
        return $exec;
    }

}
