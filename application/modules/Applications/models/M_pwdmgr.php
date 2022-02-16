<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_pwdmgr extends CI_Model {

    var $table = 'password_management';
    var $column_order = ['password_management.id', 'password_management.owner', 'password_management.link', 'password_management.username', 'password_management.lastcheck', 'password_management.status_aktif', 'password_management.id']; //set column field database for datatable orderable
    var $column_search = ['password_management.owner', 'password_management.link', 'password_management.username', 'password_management.note']; //set column field database for datatable searchable
    var $order = ['password_management.id' => 'asc']; // default order

    private function _get_datatables_query() {
        $this->db->select()
                ->from($this->table)
                ->where('password_management.syscreateuser', Dekrip($this->session->userdata('id_user')), false);
        $i = 0;
        foreach ($this->column_search as $item) { // loop column 
            if ($_GET['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_GET['search']['value']);
                } else {
                    $this->db->or_like($item, $_GET['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_GET['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_GET['order']['0']['column']], $_GET['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function lists() {
        $this->_get_datatables_query();
        if ($_GET['length'] != -1)
            $this->db->limit($_GET['length'], $_GET['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        $this->db->select()
                ->from($this->table)
                ->where('password_management.syscreateuser', Dekrip($this->session->userdata('id_user')), false);
        return $this->db->count_all_results();
    }

    public function Edit($id) {
        $exec = $this->db->select()
                ->from('dt_pwd')
                ->where('`dt_pwd`.`id`', $id, false)
                ->get()
                ->row();
        return $exec;
    }

    public function Update($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_pwd`.`id`', $id, false)
                ->update('dt_pwd');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Applications/Password_management/index/'), $this->session->set_flashdata('err_msg', 'error while update data!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Applications/Password_management/index/'), $this->session->set_flashdata('succ_msg', 'data has been changed successfully!'));
        }
    }

    public function Add($data) {
        $this->db->trans_begin();
        $this->db->insert('dt_pwd', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Applications/Password_management/index/'), $this->session->set_flashdata('err_msg', 'error while inserting new data!'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Applications/Password_management/index/'), $this->session->set_flashdata('succ_msg', 'data has been saved successfully!'));
        }
    }

}