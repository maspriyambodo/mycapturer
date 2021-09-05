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
class M_general extends CI_Model {

    var $table = 'compro_option';
    var $column_order = ['id', 'option_name', null, null, 'stat']; //set column field database for datatable orderable
    var $column_search = ['option_name', 'option_value', 'description']; //set column field database for datatable searchable 
    var $order = array('id' => 'asc'); // default order

    private function _get_datatables_query() {
        $this->db->select('id,option_name,option_value,description,stat')
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

    private function _save($data) {
        $this->db->trans_begin();
        $this->db->insert('compro_option', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/General/index/'), $this->session->set_flashdata('err_msg', 'failed, error while adding new option'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/General/index/'), $this->session->set_flashdata('succ_msg', 'success, new option has been added'));
        }
        return $result;
    }

    public function Save($data) {
        $exec = $this->db->select('compro_option.id')
                ->from('compro_option')
                ->where('compro_option.option_name', $data['option_name'])
                ->get()
                ->num_rows();
        if ($exec == 0) {
            $result = $this->_save($data);
        } else {
            $result = redirect(base_url('Compro/General/index/'), $this->session->set_flashdata('err_msg', 'failed, option name has been registered!'));
        }
        return $result;
    }

    public function Get_detail($id) {
        $exec = $this->db->select('id,option_name,option_value,description')
                ->from($this->table)
                ->where('`' . $this->table . '`.`id`', $id, false)
                ->limit(1)
                ->get()
                ->row();
        return $exec;
    }

    public function Update($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`' . $this->table . '`.`id`', $id, false)
                ->update($this->table);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/General/index/'), $this->session->set_flashdata('err_msg', 'failed, error while updating new option'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/General/index/'), $this->session->set_flashdata('succ_msg', 'success, new option has been updated'));
        }
        return $result;
    }

    public function Delete($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`' . $this->table . '`.`id`', $id, false)
                ->update($this->table);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/General/index/'), $this->session->set_flashdata('err_msg', 'failed, error while deleting option'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/General/index/'), $this->session->set_flashdata('succ_msg', 'success, option has been deleted'));
        }
        return $result;
    }

    public function Active($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`' . $this->table . '`.`id`', $id, false)
                ->update($this->table);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/General/index/'), $this->session->set_flashdata('err_msg', 'failed, error while activing option'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/General/index/'), $this->session->set_flashdata('succ_msg', 'success, option has been activated'));
        }
        return $result;
    }

}
