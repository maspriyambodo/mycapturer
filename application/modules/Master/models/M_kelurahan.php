<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_kelurahan extends CI_Model {

    var $table = 'mt_wil_kelurahan';
    var $column_order = [null, 'id_kelurahan', 'nama', 'is_actived', null, null, null, null]; //set column field database for datatable orderable
    var $column_search = ['id_kelurahan', 'nama', 'longitude', 'latitude']; //set column field database for datatable searchable 
    var $order = array('id_kelurahan' => 'asc'); // default order 

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

    public function Get_id($id) {
        $exec = $this->db->select()
                ->from('mt_wil_kelurahan')
                ->where('mt_wil_kelurahan.id_kelurahan', $id, false)
                ->get()
                ->row();
        return $exec;
    }

    public function Get_kec() {
        if (Post_get('q')) {
            $exec = $this->db->select('id_kecamatan AS id, nama AS text')
                    ->from('mt_wil_kecamatan')
                    ->like('mt_wil_kecamatan.nama', Post_get('term'))
                    ->get()
                    ->result();
        } else {
            $exec = [];
        }
        return $exec;
    }

    public function Save($data) {
        $this->db->trans_begin();
        $this->db->insert('mt_wil_kelurahan', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url(), $this->session->set_flashdata('err_msg', 'error while inserting new kelurahan'));
        } else {
            $this->db->trans_commit();
            redirect(base_url(), $this->session->set_flashdata('succ_msg', 'new kelurahan has been added'));
        }
    }

    public function Detail($id) {
        $exec = $this->db->select('mt_wil_kelurahan.id_kelurahan, mt_wil_kelurahan.id_kecamatan, mt_wil_kelurahan.nama,mt_wil_kecamatan.nama AS kecamatan, mt_wil_kelurahan.latitude, mt_wil_kelurahan.longitude')
                ->from('mt_wil_kelurahan')
                ->join('mt_wil_kecamatan', 'mt_wil_kelurahan.id_kecamatan = mt_wil_kecamatan.id_kecamatan')
                ->where('id_kelurahan', $id, false)
                ->get()
                ->row();
        return $exec;
    }

    public function Update($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('mt_wil_kelurahan.id_kelurahan', $id)
                ->update('mt_wil_kelurahan');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url(), $this->session->set_flashdata('err_msg', 'error while update kelurahan'));
        } else {
            $this->db->trans_commit();
            redirect(base_url(), $this->session->set_flashdata('succ_msg', 'kelurahan has been updated'));
        }
    }

    public function Delete($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('mt_wil_kelurahan.id_kelurahan', $id)
                ->update('mt_wil_kelurahan');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Master/Wilayah/Kelurahan/index/'), $this->session->set_flashdata('err_msg', 'error while delete kelurahan'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Master/Wilayah/Kelurahan/index/'), $this->session->set_flashdata('succ_msg', 'kelurahan has been deleted'));
        }
    }
    
    public function Activate($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('mt_wil_kelurahan.id_kelurahan', $id)
                ->update('mt_wil_kelurahan');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            redirect(base_url('Master/Wilayah/Kelurahan/index/'), $this->session->set_flashdata('err_msg', 'error while activate kelurahan'));
        } else {
            $this->db->trans_commit();
            redirect(base_url('Master/Wilayah/Kelurahan/index/'), $this->session->set_flashdata('succ_msg', 'kelurahan has been activated'));
        }
    }

}
