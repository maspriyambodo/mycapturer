<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends CI_Model {

    var $table = 'sys_users';
    var $column_order = ['sys_users.id', 'sys_users.uname', 'sys_users.role_id', 'sys_users.stat', 'sys_users.id']; //set column field database for datatable orderable
    var $column_search = ['sys_users.uname', 'sys_roles.name']; //set column field database for datatable searchable 
    var $order = ['sys_users.id' => 'asc']; // default order 

    public function index($param) {
        $exec = $this->db->query('CALL sys_users_select("' . $param['param'] . '",' . $param['id_user'] . ',' . $param['panjang'] . ',' . $param['mulai'] . ');');
        mysqli_next_result($this->db->conn_id);
        return $exec->result();
    }

    private function _filter() {
        $role_id = Dekrip($this->session->userdata('role_id'));
        $id_user = Dekrip($this->session->userdata('id_user'));
        if ($role_id == sys_parameter('SUPER_USER')['param_value']) {
            $exec = $this->db->select('sys_users.id,sys_users.uname,sys_users.pwd,sys_users.role_id,sys_users.pict,sys_users.stat,sys_roles.name');
            $this->db->from($this->table)
                    ->join('sys_roles', '`sys_users`.`role_id` = `sys_roles`.`id`');
        } else {
            $exec = $this->db->select('sys_users.id,sys_users.uname,sys_users.pwd,sys_users.role_id,sys_users.pict,sys_users.stat,sys_roles.name');
            $this->db->from($this->table)
                    ->join('sys_roles', '`sys_users`.`role_id` = `sys_roles`.`id`')
                    ->where('`sys_users`.`id`', $id_user, false)
                    ->or_where('`sys_roles`.`parent_id`', $role_id, false);
        }
        return $exec;
    }

    private function _get_datatables_query() {
        $this->_filter();
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
        $this->_filter();
        return $this->db->count_all_results();
    }

    public function Role($param) {
        $exec = $this->db->query('CALL sys_roles_select(' . $param . ');');
        mysqli_next_result($this->db->conn_id);
        return $exec->result();
    }

    public function Save($data) {
        $exec = $this->db->query('CALL sys_users_insert("' . $data['uname'] . '","' . $data['pwd'] . '",' . $data['role_id'] . ',"' . $data['pict'] . '",' . $data['stat'] . ',' . $data['user_login'] . ');');
        if (empty($exec->conn_id->affected_rows) or $exec->conn_id->affected_rows == 0) {
            log_message('error', APPPATH . 'modules/Systems/models/M_users -> function Save ' . 'error ketika sys_users_insert');
            $result = redirect(base_url('Systems/Users/Add/'), $this->session->set_flashdata('err_msg', 'failed, error while processing user data!'));
        } else {
            mysqli_next_result($this->db->conn_id);
            $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('succ_msg', 'success, data user has been processing'));
        }
        return $result;
    }

    public function Check($uname) {
        $exec = $this->db->select('sys_users.uname')
                ->from('sys_users')
                ->where('sys_users.uname', $uname)
                ->get()
                ->result();
        return $exec;
    }

    public function Stat($data) {
        $exec = $this->db->query('CALL sys_users_stat(' . $data['id_user'] . ',' . $data['user_login'] . ',' . $data['stat_active'] . ');');
        mysqli_next_result($this->db->conn_id);
        return $exec;
    }

    public function Reset($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`sys_users`.`id`', $id, false)
                ->update('sys_users');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('err_msg', 'failed, error while processing user data'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Systems/Users/index/'), $this->session->set_flashdata('succ_msg', 'success, user password has been reset'));
        }
    }

}
