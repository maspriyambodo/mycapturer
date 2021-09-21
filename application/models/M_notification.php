<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_notification extends CI_Model {

    public function _Save($data) {
        $this->db->trans_begin();
        $this->db->insert('dt_notif', $data);
        return $this->db->trans_status();
    }

    public function Count_notif_su() {// menghitung notifikasi untuk akses super user
        $exec = $this->db->select('dt_notif.id')
                ->from('dt_notif')
                ->where('`dt_notif`.`stat`', 1, false)
                ->count_all_results();
        return $exec;
    }

    public function Count_notif() {// menghitung notifikasi untuk akses selain super user
        $role_id = Dekrip($this->session->userdata('role_id'));
        $exec = $this->db->select('dt_notif.id')
                ->from('dt_notif')
                ->join('sys_roles', 'dt_notif.role_id = sys_roles.id', 'INNER')
                ->where([
                    '`dt_notif`.`stat`', 1, false,
                    '`sys_roles`.`parent_id`', $role_id, false
                ])
                ->count_all_results();
        return $exec;
    }

    public function Get_notif_su() {//mendapatkan data notifikasi untuk akses super user
        $exec = $this->db->select('dt_notif.title_notif,dt_notif.url,dt_notif.syscreatedate')
                ->from('dt_notif')
                ->join('sys_roles', 'dt_notif.role_id = sys_roles.id', 'INNER')
                ->where('`dt_notif`.`stat`', 1, false)
                ->order_by('dt_notif.id', 'DESC')
                ->get()
                ->result();
        return $exec;
    }

    public function Get_notif() {//mendapatkan data notifikasi untuk akses selais super user
        $exec = $this->db->select('dt_notif.id AS id_notif,dt_notif.title_notif,dt_notif.url,dt_notif.syscreatedate,sys_roles.`name` AS role_name')
                ->from('dt_notif')
                ->join('sys_roles', 'dt_notif.role_id = sys_roles.id', 'INNER')
                ->where('`dt_notif`.`stat`', 1, false)
                ->get()
                ->result();
        return $exec;
    }

    public function Mark_all_read() {
        $this->db->set('`dt_notif`.`stat`', 0, false)
                ->where('`dt_notif`.`stat`', 1, false)
                ->update('dt_notif');
    }

}
