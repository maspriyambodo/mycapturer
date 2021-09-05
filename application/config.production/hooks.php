<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$hook['display_override'][] = array(
    'class' => '',
    'function' => 'compress',
    'filename' => 'compress.php',
    'filepath' => 'hooks'
);
