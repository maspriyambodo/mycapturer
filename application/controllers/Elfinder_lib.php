<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Elfinder_lib extends CI_Controller {

    public function manager() {
        if ($this->session->userdata('id_user')) {
            $data['connector'] = site_url('/Elfinder_lib/connector');
            $this->load->view('elfinder', $data);
        } else {
            show_404();
        }
    }

//    public function manager() {
//        if ($this->session->userdata('id_user')) {
//            $data['connector'] = site_url('/Elfinder_lib/connector');
//            $this->load->view('CKEditor', $data);
//        } else {
//            show_404();
//        }
//    }

    public function connector() {
        $path = 'assets/images/blog/' . date('Y_m_d') . '/';
        if (!is_dir($path)) {
            ob_start();
            mkdir($path, 0777, true);
            ob_end_clean();
        }
        $opts = array(
            'roots' => array(
                array(
                    'driver' => 'LocalFileSystem',
                    'path' => FCPATH . $path,
                    'URL' => base_url($path),
                    'uploadDeny' => array('all'), // All Mimetypes not allowed to upload
                    'uploadAllow' => array('image', 'text/plain', 'application/pdf'), // Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder' => array('deny', 'allow'), // allowed Mimetype `image` and `text/plain` only
                    'accessControl' => array($this, 'elfinderAccess'), // disable and hide dot starting files (OPTIONAL)
                // more elFinder options here
                )
            ),
        );
        $connector = new elFinderConnector(new elFinder($opts));
        return $connector->run();
    }

    public function elfinderAccess($attr, $path, $data, $volume, $isDir, $relpath) {
        $basename = basename($path);
        return $basename[0] === '.'                  // if file/folder begins with '.' (dot)
                && strlen($relpath) !== 1           // but with out volume root
                ? !($attr == 'read' || $attr == 'write') // set read+write to false, other (locked+hidden) set to true
                : null;                                 // else elFinder decide it itself
    }

}
