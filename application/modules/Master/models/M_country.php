<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_country extends CI_Model {

    var $table = 'mt_country';
    var $column_order = ['mt_country.id', 'mt_country.`code`', 'mt_country.country', 'mt_country.id', 'mt_country.stat', 'mt_country.id']; //set column field database for datatable orderable
    var $column_search = ['mt_country.`code`', 'mt_country.country']; //set column field database for datatable searchable 
    var $order = ['mt_country.id' => 'asc']; // default order

    public function index($data) {
        $exec = $this->db->query('CALL mt_country("' . $data['param'] . '",' . $data['country_id'] . ',"' . $data['kode_negara'] . '","' . $data['nama_negara'] . '","' . $data['bendera'] . '",' . $data['user_login'] . ');');
        mysqli_next_result($this->db->conn_id);
        return $exec;
    }

    private function _get_datatables_query() {
        $this->db->select('mt_country.id AS id_country, mt_country.`code` AS code_country, mt_country.country AS nama_country, mt_country.stat, mt_country.flags')
                ->from($this->table)
                ->where('mt_country.stat', 1, false);
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

}
