<?php

defined('BASEPATH') OR exit('trying to signin from backdoor?');

class M_param extends CI_Model {

    public function index() {
        $exec = $this->db->select('sys_param.id,sys_param.param_group,sys_param.param_value,sys_param.param_desc,sys_param.stat')
                ->from('sys_param')
                ->where('`sys_param`.`stat`', 1, false)
                ->get()
                ->result();
        return $exec;
    }

    public function check_id($param) {
        $exec = $this->db->select('sys_param.id')
                ->from('sys_param')
                ->where('sys_param.id', $param)
                ->count_all_results();
        return $exec;
    }

    public function _add($data) {
        $this->db->trans_begin();
        $this->db->insert('sys_param', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = false;
        } else {
            $this->db->trans_commit();
            $result = true;
        }
        return $result;
    }
    
    public function _update($old_param, $data) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('sys_param.id', $old_param)
                ->update('sys_param');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = false;
        } else {
            $this->db->trans_commit();
            $result = true;
        }
        return $result;
    }

    public function _detail($id) {
        $exec = $this->db->select('sys_param.id,sys_param.param_group,sys_param.param_value,sys_param.param_desc')
                ->from('sys_param')
                ->where('sys_param.id', $id)
                ->limit(1)
                ->get()
                ->result();
        return $exec;
    }

}
