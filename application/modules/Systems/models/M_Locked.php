<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Locked extends CI_Model {

    var $table = 'sys_users';
    var $column_order = [null, 'uname', 'name', null, null, null]; //set column field database for datatable orderable
    var $column_search = ['uname', 'name']; //set column field database for datatable searchable 
    var $order = ['id' => 'asc']; // default order

    private function _get_datatables_query() {
        $this->db->select('sys_users.id,sys_users.uname,sys_users.pwd,sys_users.role_id,sys_users.pict,sys_users.stat,sys_users.ip_address, sys_users.last_login, sys_roles.name');
        $this->db->from($this->table)
                ->where('`sys_users`.`login_attempt` !=', 0, false)
                ->join('sys_roles', '`sys_users`.`role_id` = `sys_roles`.`id`');
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
        $this->db->from($this->table)
                ->join('sys_roles', '`sys_users`.`role_id` = `sys_roles`.`id`')
                ->where('`sys_users`.`login_attempt` !=', 0, false);
        return $this->db->count_all_results();
    }

    public function Unlock($id) {
        $this->db->trans_begin();
        $this->db->set([
                    '`sys_users`.`login_attempt`' => 0 + false
                ])
                ->where('`sys_users`.`id`', $id, false)
                ->update('sys_users');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $status = redirect(base_url('Systems/Locked/index/'), $this->session->set_flashdata('err_msg', 'error, Password failed to unblock'));
        } else {
            $this->db->trans_commit();
            $status = redirect(base_url('Systems/Locked/index/'), $this->session->set_flashdata('succ_msg', 'Account has been unblocked'));
        }
        return $status;
    }

}
