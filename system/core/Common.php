<?php

defined('BASEPATH') or exit('No direct script access allowed');
if (!function_exists('is_php')) {

    function is_php($version) {
        static $_is_php;
        $version = (string) $version;
        if (!isset($_is_php[$version])) {
            $_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
        }
        return $_is_php[$version];
    }

}
if (!function_exists('is_really_writable')) {

    function is_really_writable($file) {
        if (DIRECTORY_SEPARATOR === '/' && (is_php('5.4') or!ini_get('safe_mode'))) {
            return is_writable($file);
        }
        if (is_dir($file)) {
            $file = rtrim($file, '/') . '/' . md5(mt_rand());
            if (($fp = @fopen($file, 'ab')) === false) {
                return false;
            }
            fclose($fp);
            @chmod($file, 0777);
            @unlink($file);
            return true;
        } elseif (!is_file($file) or ($fp = @fopen($file, 'ab')) === false) {
            return false;
        }
        fclose($fp);
        return true;
    }

}
if (!function_exists('load_class')) {

    function &load_class($class, $directory = 'libraries', $param = NULL) {
        static $_classes = array();
        if (isset($_classes[$class])) {
            return $_classes[$class];
        }
        $name = false;
        foreach (array(
    APPPATH,
    BASEPATH
        ) as $path) {
            if (file_exists($path . $directory . '/' . $class . '.php')) {
                $name = 'CI_' . $class;
                if (class_exists($name, false) === false) {
                    require_once ($path . $directory . '/' . $class . '.php');
                }
                break;
            }
        }
        if (file_exists(APPPATH . $directory . '/' . config_item('subclass_prefix') . $class . '.php')) {
            $name = config_item('subclass_prefix') . $class;
            if (class_exists($name, false) === false) {
                require_once (APPPATH . $directory . '/' . $name . '.php');
            }
        }
        if ($name === false) {
            set_status_header(503);
            echo 'Unable to locate the specified class: ' . $class . '.php';
            exit(5);
        }
        is_loaded($class);
        $_classes[$class] = isset($param) ? new $name($param) : new $name();
        return $_classes[$class];
    }

}
if (!function_exists('is_loaded')) {

    function &is_loaded($class = '') {
        static $_is_loaded = array();
        if ($class !== '') {
            $_is_loaded[strtolower($class)] = $class;
        }
        return $_is_loaded;
    }

}
if (!function_exists('get_config')) {

    function &get_config(Array $replace = array()) {
        static $config;
        if (empty($config)) {
            $file_path = APPPATH . 'config/config.php';
            $found = false;
            if (file_exists($file_path)) {
                $found = true;
                require ($file_path);
            }
            if (file_exists($file_path = APPPATH . 'config/' . ENVIRONMENT . '/config.php')) {
                require ($file_path);
            } elseif (!$found) {
                set_status_header(503);
                echo 'The configuration file does not exist.';
                exit(3);
            }
            if (!isset($config) or!is_array($config)) {
                set_status_header(503);
                echo 'Your config file does not appear to be formatted correctly.';
                exit(3);
            }
        }
        foreach ($replace as $key => $val) {
            $config[$key] = $val;
        }
        return $config;
    }

}
if (!function_exists('config_item')) {

    function config_item($item) {
        static $_config;
        if (empty($_config)) {
            $_config[0] = & get_config();
        }
        return isset($_config[0][$item]) ? $_config[0][$item] : NULL;
    }

}
if (!function_exists('get_mimes')) {

    function &get_mimes() {
        static $_mimes;
        if (empty($_mimes)) {
            $_mimes = file_exists(APPPATH . 'config/mimes.php') ? include (APPPATH . 'config/mimes.php') : array();
            if (file_exists(APPPATH . 'config/' . ENVIRONMENT . '/mimes.php')) {
                $_mimes = array_merge($_mimes, include (APPPATH . 'config/' . ENVIRONMENT . '/mimes.php'));
            }
        }
        return $_mimes;
    }

}
if (!function_exists('is_https')) {

    function is_https() {
        if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
            return true;
        } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return true;
        }
        return false;
    }

}
if (!function_exists('is_cli')) {

    function is_cli() {
        return (PHP_SAPI === 'cli' or defined('STDIN'));
    }

}
if (!function_exists('show_error')) {

    function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered') {
        $status_code = abs($status_code);
        if ($status_code < 100) {
            $exit_status = $status_code + 9;
            $status_code = 500;
        } else {
            $exit_status = 1;
        }
        $_error = & load_class('Exceptions', 'core');
        echo $_error->show_error($heading, $message, 'error_general', $status_code);
        exit($exit_status);
    }

}
if (!function_exists('show_404')) {

    function show_404($page = '', $log_error = true) {
        $ci = get_instance();
        $ci
                ->output
                ->set_status_header(404);
        $ci
                ->load
                ->view('errors/cli/error_404');
        echo $ci
                ->output
                ->get_output();
        exit(4);
    }

}
if (!function_exists('blocked_account')) {

    function blocked_account() {
        $ci = get_instance();
        $ci
                ->output
                ->set_status_header(200);
        $ci
                ->load
                ->view('errors/cli/blocked_account');
        echo $ci
                ->output
                ->get_output();
        exit(4);
    }

}
if (!function_exists('log_message')) {

    function log_message($level, $message) {
        static $_log;
        if ($_log === NULL) {
            $_log[0] = & load_class('Log', 'core');
        }
        $_log[0]->write_log($level, $message);
    }

}
if (!function_exists('set_status_header')) {

    function set_status_header($code = 200, $text = '') {
        if (is_cli()) {
            return;
        }
        if (empty($code) or!is_numeric($code)) {
            show_error('Status codes must be numeric', 500);
        }
        if (empty($text)) {
            is_int($code) or $code = (int) $code;
            $stati = array(
                100 => 'Continue',
                101 => 'Switching Protocols',
                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',
                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                307 => 'Temporary Redirect',
                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                422 => 'Unprocessable Entity',
                426 => 'Upgrade Required',
                428 => 'Precondition Required',
                429 => 'Too Many Requests',
                431 => 'Request Header Fields Too Large',
                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported',
                511 => 'Network Authentication Required',
            );
            if (isset($stati[$code])) {
                $text = $stati[$code];
            } else {
                show_error('No status text available. Please check your status code number or supply your own message text.', 500);
            }
        }
        if (strpos(PHP_SAPI, 'cgi') === 0) {
            header('Status: ' . $code . ' ' . $text, true);
            return;
        }
        $server_protocol = (isset($_SERVER['SERVER_PROTOCOL']) && in_array($_SERVER['SERVER_PROTOCOL'], array(
                    'HTTP/1.0',
                    'HTTP/1.1',
                    'HTTP/2'
                        ), true)) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
        header($server_protocol . ' ' . $code . ' ' . $text, true, $code);
    }

}
if (!function_exists('_error_handler')) {

    function _error_handler($severity, $message, $filepath, $line) {
        $is_error = (((E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR | E_USER_ERROR) & $severity) === $severity);
        if ($is_error) {
            set_status_header(500);
        }
        if (($severity & error_reporting()) !== $severity) {
            return;
        }
        $_error = & load_class('Exceptions', 'core');
        $_error->log_exception($severity, $message, $filepath, $line);
        if (str_ireplace(array(
                    'off',
                    'none',
                    'no',
                    'false',
                    'null'
                        ), '', ini_get('display_errors'))) {
            $_error->show_php_error($severity, $message, $filepath, $line);
        }
        if ($is_error) {
            exit(1);
        }
    }

}
if (!function_exists('_exception_handler')) {

    function _exception_handler($exception) {
        $_error = & load_class('Exceptions', 'core');
        $_error->log_exception('error', 'Exception: ' . $exception->getMessage(), $exception->getFile(), $exception->getLine());
        is_cli() or set_status_header(500);
        if (str_ireplace(array(
                    'off',
                    'none',
                    'no',
                    'false',
                    'null'
                        ), '', ini_get('display_errors'))) {
            $_error->show_exception($exception);
        }
        exit(1);
    }

}
if (!function_exists('_shutdown_handler')) {

    function _shutdown_handler() {
        $last_error = error_get_last();
        if (isset($last_error) && ($last_error['type'] & (E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING))) {
            _error_handler($last_error['type'], $last_error['message'], $last_error['file'], $last_error['line']);
        }
    }

}
if (!function_exists('remove_invisible_characters')) {

    function remove_invisible_characters($str, $url_encoded = true) {
        $non_displayables = array();
        if ($url_encoded) {
            $non_displayables[] = '/%0[0-8bcef]/i';
            $non_displayables[] = '/%1[0-9a-f]/i';
            $non_displayables[] = '/%7f/i';
        }
        $non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';
        do {
            $str = preg_replace($non_displayables, '', $str, -1, $count);
        } while ($count);
        return $str;
    }

}
if (!function_exists('html_escape')) {

    function html_escape($var, $double_encode = true) {
        if (empty($var)) {
            return $var;
        }
        if (is_array($var)) {
            foreach (array_keys($var) as $key) {
                $var[$key] = html_escape($var[$key], $double_encode);
            }
            return $var;
        }
        return htmlspecialchars($var, ENT_QUOTES, config_item('charset'), $double_encode);
    }

}
if (!function_exists('_stringify_attributes')) {

    function _stringify_attributes($attributes, $js = false) {
        $atts = NULL;
        if (empty($attributes)) {
            return $atts;
        }
        if (is_string($attributes)) {
            return ' ' . $attributes;
        }
        $attributes = (array) $attributes;
        foreach ($attributes as $key => $val) {
            $atts .= ($js) ? $key . '=' . $val . ',' : ' ' . $key . '="' . $val . '"';
        }
        return rtrim($atts, ',');
    }

}
if (!function_exists('function_usable')) {

    function function_usable($function_name) {
        static $_suhosin_func_blacklist;
        if (function_exists($function_name)) {
            if (!isset($_suhosin_func_blacklist)) {
                $_suhosin_func_blacklist = extension_loaded('suhosin') ? explode(',', trim(ini_get('suhosin.executor.func.blacklist'))) : array();
            }
            return !in_array($function_name, $_suhosin_func_blacklist, true);
        }
        return false;
    }

}

