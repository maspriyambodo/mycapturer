<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Git_deploy extends CI_Controller {

    public function index() {
        shell_exec('cd /var/www/html/shandry/ && git reset –hard HEAD && git pull');
        log_message('error', 'success pulling project');
    }

}
