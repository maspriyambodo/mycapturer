<?php

defined('BASEPATH') OR exit('No direct script access allowed');
$autoload['packages'] = [];
$autoload['libraries'] = ['session', 'database', 'email', 'parser', 'encryption', 'Bodo', 'Multi_menu'];
$autoload['drivers'] = [];
$autoload['helper'] = ['form', 'url', 'html', 'file', 'common_helper'];
$autoload['config'] = ['multi_menu'];
$autoload['language'] = [];
$autoload['model'] = ['Systems/M_default'];
