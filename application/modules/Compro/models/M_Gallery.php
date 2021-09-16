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
class M_Gallery extends CI_Model {

    var $table = 'dt_portfolio';
    var $column_order = ['id', 'tipe', 'title', null, null, 'stat', null]; //set column field database for datatable orderable
    var $column_search = ['title', 'desc']; //set column field database for datatable searchable 
    var $order = array('id' => 'asc'); // default order

    private function _get_datatables_query() {
        $this->db->select('id,title,lowres,highres,desc,stat')
                ->select('CASE dt_portfolio.tipe WHEN 1 THEN "image" WHEN 2 THEN "video" ELSE "youtube" END AS tipe', false)
                ->from($this->table);
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

    public function Galeri_img($data) {
        $this->db->trans_begin();
        $this->db->insert('dt_portfolio', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Gallery/index/'), $this->session->set_flashdata('err_msg', 'failed, error while adding new gallelry'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Gallery/index/'), $this->session->set_flashdata('succ_msg', 'success, gallery lists has been added'));
        }
        return $result;
    }

    public function _GetDetail($id) {
        $exec = $this->db->select('id,lowres,highres,title,desc,tipe')
                ->from('dt_portfolio')
                ->where('`dt_portfolio`.`id`', $id, false)
                ->limit(1)
                ->get();
        if (!$exec) {
            $result = redirect(base_url('Compro/Gallery/index/'), $this->session->set_flashdata('err_msg', 'error, invalid data token!'));
        } else {
            $result = $exec->result();
        }
        return $result;
    }

    public function Delete($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_portfolio`.`id`', $id, false)
                ->update('dt_portfolio');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Gallery/index/'), $this->session->set_flashdata('err_msg', 'failed, error while deleting gallelry'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Gallery/index/'), $this->session->set_flashdata('succ_msg', 'success, gallery lists has been deleted'));
        }
        return $result;
    }
    
    public function Active($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_portfolio`.`id`', $id, false)
                ->update('dt_portfolio');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Gallery/index/'), $this->session->set_flashdata('err_msg', 'failed, error while activing gallelry'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Gallery/index/'), $this->session->set_flashdata('succ_msg', 'success, gallery lists has been Activated'));
        }
        return $result;
    }

}
