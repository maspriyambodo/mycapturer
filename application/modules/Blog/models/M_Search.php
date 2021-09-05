<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class M_Search extends CI_Model {

    public function Category($paginate, $query) {
        $exec = $this->db->select('SUBSTRING(`dt_post`.`post_content`, 1, 350) AS post_content,`dt_post`.`post_title`,dt_post_category.category,dt_users.nama,dt_post.syscreatedate,dt_post.post_thumbnail')
                ->from('dt_post')
                ->join('dt_users', 'dt_post.syscreateuser = dt_users.sys_user_id', 'INNER')
                ->join('dt_post_category', 'dt_post.post_category = dt_post_category.id', 'INNER')
                ->where('`dt_post`.`post_status`', 1, false)
                ->where('dt_post_category.category', $query)
                ->order_by('dt_post.syscreatedate', 'DESC')
                ->limit($paginate['config']['per_page'], $paginate['from'])
                ->get()
                ->result();
        return $exec;
    }

    public function Tags($paginate, $query) {
        $exec = $this->db->select('SUBSTRING(`dt_post`.`post_content`, 1, 350) AS post_content,`dt_post`.`post_title`,dt_post_category.category,dt_users.nama,dt_post.syscreatedate,dt_post.post_thumbnail')
                ->from('dt_post')
                ->join('dt_users', 'dt_post.syscreateuser = dt_users.sys_user_id', 'INNER')
                ->join('dt_post_category', 'dt_post.post_category = dt_post_category.id', 'INNER')
                ->where('`dt_post`.`post_status`', 1, false)
                ->like('dt_post.post_tags', $query)
                ->order_by('dt_post.syscreatedate', 'DESC')
                ->limit($paginate['config']['per_page'], $paginate['from'])
                ->get()
                ->result();
        return $exec;
    }

    public function TotCategory($query) {
        $exec = $this->db->select('dt_post.id')
                ->from('dt_post')
                ->join('dt_post_category', 'dt_post.post_category = dt_post_category.id', 'INNER')
                ->where('`dt_post`.`post_status`', 1, false)
                ->where('dt_post_category.category', $query)
                ->get()
                ->num_rows();
        return $exec;
    }

    public function Tot_tags($query) {
        
    }

}
