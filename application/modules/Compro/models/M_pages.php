<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_pages extends CI_Model {

    var $table = 'services_pages';
    var $column_order = ['id_post', null, 'uname', 'syscreatedate', 'viewers', null]; //set column field database for datatable orderable
    var $column_search = ['post_title', 'uname']; //set column field database for datatable searchable 
    var $order = ['syscreatedate' => 'DESC']; // default order

    private function role_name() {
        $role_id = $this->bodo->Dec($this->session->userdata('role_id'));
        $id_user = $this->bodo->Dec($this->session->userdata('id_user'));
        if ($role_id == 1) {
            $exec = $this->db->from($this->table);
        } else {
            $exec = $this->db->from($this->table)
                    ->where($this->table . '.`id_user`', $id_user, false);
        }
        return $exec;
    }

    private function _get_datatables_query() {
        $this->role_name();
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
        $this->role_name();
        return $this->db->count_all_results();
    }

    public function Read($id) {
        $exec = $this->db->select('dt_post.id, dt_post.post_content, dt_services.nama AS post_title, dt_post.post_tags,dt_post.syscreatedate')
                ->from('dt_post')
                ->join('dt_services', 'dt_post.post_title = dt_services.id', false)
                ->where('`dt_post`.`id`', $id, false)
                ->get()
                ->row_array();
        return $exec;
    }

    public function Edit($id) {
        $exec = $this->db->select('dt_post.id, dt_post.post_content, dt_services.nama AS post_title, dt_post.post_tags')
                ->from('dt_post')
                ->join('dt_services', 'dt_post.post_title = dt_services.id', false)
                ->where('`dt_post`.`id`', $id, false)
                ->get()
                ->row_array();
        $new_arr = [
            'id' => Enkrip($exec['id']),
            'post_content' => $exec['post_content'],
            'post_title' => $exec['post_title'],
            'post_tags' => $exec['post_tags']
        ];
        return $new_arr;
    }

    public function update_page($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_post`.`id`', $id, false)
                ->update('dt_post');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Services/Pages/'), $this->session->set_flashdata('err_msg', 'failed, error while update data'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Services/Pages/'), $this->session->set_flashdata('succ_msg', 'success, services lists has been updated'));
        }
        return $result;
    }

    public function Delete($data, $id) {
        $this->db->trans_begin();
        $this->db->set($data)
                ->where('`dt_post`.`id`', $id, false)
                ->update('dt_post');
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Compro/Services/Pages/'), $this->session->set_flashdata('err_msg', 'failed, error while deleting data'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Compro/Services/Pages/'), $this->session->set_flashdata('succ_msg', 'success, services page has been deleted'));
        }
        return $result;
    }

}
