<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class git_deploy extends CI_Controller {

    public function index() {
        shell_exec('cd /var/www/html/shandry/ && git reset –hard HEAD && git pull');
        log_message('info', 'success pulling project');
    }

}
