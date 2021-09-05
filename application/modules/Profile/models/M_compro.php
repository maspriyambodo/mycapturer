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
 * Description of M_compro
 *
 * @author centos
 */
class M_compro extends CI_Model {

    public function Portfolio($paginate) {
        $exec = $this->db->select('id,lowres,highres,tipe,title,desc')
                ->from('dt_portfolio')
                ->where('`dt_portfolio`.`stat`', 1, false)
                ->limit($paginate['config']['per_page'], $paginate['from'])
                ->get()
                ->result();
        return $exec;
    }

    public function Totprotfolio() {
        $exec = $this->db->select()
                ->from('dt_portfolio')
                ->where('`dt_portfolio`.`stat`', 1, false)
                ->get()
                ->num_rows();
        return $exec;
    }

    public function List_services() {
        $exec = $this->db->select('dt_services.id,nama,desc,dt_post.post_title,dt_post.id AS id_post')
                ->from('dt_services')
                ->join('dt_post', 'dt_services.id = dt_post.post_title', 'LEFT')
                ->where('`dt_services`.`stat`', 1, false)
                ->get()
                ->result();
        return $exec;
    }

    public function Newsletter($data) {
        $this->db->trans_begin();
        $this->db->insert('dt_subscriber', $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $result = redirect(base_url('Profile/index/'), $this->session->set_flashdata('err_msg', 'failed, error while saving data'));
        } else {
            $this->db->trans_commit();
            $result = redirect(base_url('Profile/index/'), $this->session->set_flashdata('succ_msg', 'success, thank you for subscribing'));
        }
        return $result;
    }

}
