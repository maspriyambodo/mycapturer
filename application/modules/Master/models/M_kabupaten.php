<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_kabupaten extends CI_Model {

    var $table = 'mt_wil_kabupaten';
    var $column_order = ['mt_wil_kabupaten.id_kabupaten','mt_wil_kabupaten.id_kabupaten', 'mt_wil_kabupaten.nama', 'mt_wil_kabupaten.is_actived', 'mt_wil_kabupaten.longitude', 'mt_wil_kabupaten.latitude', 'mt_wil_kabupaten.id_kabupaten', 'mt_wil_kabupaten.id_kabupaten']; //set column field database for datatable orderable
    var $column_search = ['mt_wil_kabupaten.id_kabupaten', 'mt_wil_kabupaten.nama', 'mt_wil_kabupaten.longitude', 'mt_wil_kabupaten.latitude']; //set column field database for datatable searchable 
    var $order = ['id_kabupaten' => 'asc']; // default order

    private function _get_datatables_query() {
        $this->db->from($this->table);
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function Get_id($id) {
        $exec = $this->db->select('mt_wil_kabupaten.id_kabupaten')
                ->from('mt_wil_kabupaten')
                ->where('mt_wil_kabupaten.id_kabupaten', $id, false)
                ->get()
                ->row();
        return $exec;
    }

    public function Provinsi() {
        $exec = $this->db->select('mt_wil_provinsi.id_provinsi, mt_wil_provinsi.nama')
                ->from('mt_wil_provinsi')
                ->get()
                ->result();
        return $exec;
    }

    public function Add($data) {
        $this->db->trans_begin();
        $this->db->insert('mt_wil_kabupaten', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url(), $this->session->set_flashdata('err_msg', 'error while inserting new kabupaten'));
        } else {
            $this->db->trans_commit();
            redirect(base_url(), $this->session->set_flashdata('succ_msg', 'new kabupaten has been added'));
        }
    }

    public function Get_prov() {
        if (Post_get('q')) {
            $exec = $this->db->select('id_provinsi AS id, nama AS text')
                    ->from('mt_wil_provinsi')
                    ->like('mt_wil_provinsi.nama', Post_get('term'))
                    ->get()
                    ->result();
        } else {
            $exec = [];
        }
        return $exec;
    }

    public function Get_detail($id) {
        $exec = $this->db->select('mt_wil_kabupaten.id_kabupaten, mt_wil_kabupaten.id_provinsi, mt_wil_kabupaten.nama, mt_wil_kabupaten.latitude, mt_wil_kabupaten.longitude,mt_wil_provinsi.nama AS provinsi')
                ->from('mt_wil_kabupaten')
                ->join('mt_wil_provinsi', 'mt_wil_kabupaten.id_provinsi = mt_wil_provinsi.id_provinsi', 'LEFT')
                ->where('`mt_wil_kabupaten`.`id_kabupaten`', $id, false)
                ->get()
                ->row();
        return $exec;
    }

    public function Update($data, $id_kab) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`mt_wil_kabupaten`.`id_kabupaten`', $id_kab, false)
                ->update('mt_wil_kabupaten');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Master/Wilayah/Kabupaten/index/'), $this->session->set_flashdata('err_msg', 'error while updating data kabupaten'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Master/Wilayah/Kabupaten/index/'), $this->session->set_flashdata('succ_msg', 'data kabupaten has been updated'));
        }
    }

    public function Delete($data, $id_kab) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`mt_wil_kabupaten`.`id_kabupaten`', $id_kab, false)
                ->update('mt_wil_kabupaten');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Master/Wilayah/Kabupaten/index/'), $this->session->set_flashdata('err_msg', 'error while deleting data kabupaten'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Master/Wilayah/Kabupaten/index/'), $this->session->set_flashdata('succ_msg', 'data kabupaten has been deleted'));
        }
    }

    public function Active($data, $id_kab) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`mt_wil_kabupaten`.`id_kabupaten`', $id_kab, false)
                ->update('mt_wil_kabupaten');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Master/Wilayah/Kabupaten/index/'), $this->session->set_flashdata('err_msg', 'error while activating data kabupaten'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Master/Wilayah/Kabupaten/index/'), $this->session->set_flashdata('succ_msg', 'data kabupaten has been activated'));
        }
    }

}
