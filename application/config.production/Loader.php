<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class HMVC_Loader extends CI_Loader {

    protected $_ci_modules = array();
    protected $_ci_controllers = array();

    public function __construct() {
        parent::__construct();
        $router = & $this->_ci_get_component('router');
        if ($router->module) {
            $this->add_module($router->module);
        }
    }

    public function controller($uri, $params = array(), $return = FALSE) {
        list($module) = $this->detect_module($uri);
        if (!isset($module)) {
            $router = & $this->_ci_get_component('router');
            if ($router->module) {
                $module = $router->module;
                $uri = $module . '/' . $uri;
            }
        }
        $this->add_module($module);
        $void = $this->_load_controller($uri, $params, $return);
        $this->remove_module();
        return $void;
    }

    public function library($library = '', $params = NULL, $object_name = NULL) {
        if (is_array($library)) {
            foreach ($library as $class) {
                $this->library($class, $params);
            }
            return;
        }
        if (list($module, $class) = $this->detect_module($library)) {
            if (in_array($module, $this->_ci_modules)) {
                return parent::library($class, $params, $object_name);
            }
            $this->add_module($module);
            $void = parent::library($class, $params, $object_name);
            $this->remove_module();
            return $void;
        } else {
            return parent::library($library, $params, $object_name);
        }
    }

    public function model($model, $name = '', $db_conn = FALSE) {
        if (is_array($model)) {
            foreach ($model as $babe) {
                $this->model($babe);
            }
            return;
        }
        if (list($module, $class) = $this->detect_module($model)) {
            if (in_array($module, $this->_ci_modules)) {
                return parent::model($class, $name, $db_conn);
            }
            $this->add_module($module);
            $void = parent::model($class, $name, $db_conn);
            $this->remove_module();
            return $void;
        } else {
            return parent::model($model, $name, $db_conn);
        }
    }

    public function view($view, $vars = array(), $return = FALSE) {
        if (list($module, $class) = $this->detect_module($view)) {
            if (in_array($module, $this->_ci_modules)) {
                return parent::view($class, $vars, $return);
            }
            $this->add_module($module);
            $void = parent::view($class, $vars, $return);
            $this->remove_module();
            return $void;
        } else {
            return parent::view($view, $vars, $return);
        }
    }

    public function config($file = '', $use_sections = FALSE, $fail_gracefully = FALSE) {
        if (list($module, $class) = $this->detect_module($file)) {
            if (in_array($module, $this->_ci_modules)) {
                return parent::config($class, $use_sections, $fail_gracefully);
            }
            $this->add_module($module);
            $void = parent::config($class, $use_sections, $fail_gracefully);
            $this->remove_module();
            return $void;
        } else {
            parent::config($file, $use_sections, $fail_gracefully);
        }
    }

    public function helper($helper = array()) {
        if (is_array($helper)) {
            foreach ($helper as $help) {
                $this->helper($help);
            }
            return;
        }
        if (list($module, $class) = $this->detect_module($helper)) {
            if (in_array($module, $this->_ci_modules)) {
                return parent::helper($class);
            }
            $this->add_module($module);
            $void = parent::helper($class);
            $this->remove_module();
            return $void;
        } else {
            return parent::helper($helper);
        }
    }

    public function language($file = array(), $lang = '') {
        if (is_array($file)) {
            foreach ($file as $langfile) {
                $this->language($langfile, $lang);
            }
            return;
        }
        if (list($module, $class) = $this->detect_module($file)) {
            if (in_array($module, $this->_ci_modules)) {
                return parent::language($class, $lang);
            }
            $this->add_module($module);
            $void = parent::language($class, $lang);
            $this->remove_module();
            return $void;
        } else {
            return parent::language($file, $lang);
        }
    }

    public function widget($widget) {
        if (list($module, $widget) = $this->detect_module($widget)) {
            if (in_array($module, $this->_ci_modules)) {
                return array(
                    $module,
                    $widget
                );
            }
            $this->add_module($module);
            $void = $this->widget($module . '/' . $widget);
            if (!$void) {
                $this->remove_module();
            }
            return $void;
        } else {
            return FALSE;
        }
    }

    public function add_module($module, $view_cascade = TRUE) {
        if ($path = $this->find_module($module)) {
            array_unshift($this->_ci_modules, $module);
            parent::add_package_path($path, $view_cascade);
        }
    }

    public function remove_module($module = '', $remove_config = TRUE) {
        if ($module == '') {
            array_shift($this->_ci_modules);
            parent::remove_package_path('', $remove_config);
        } else if (($key = array_search($module, $this->_ci_modules)) !== FALSE) {
            if ($path = $this->find_module($module)) {
                unset($this->_ci_modules[$key]);
                parent::remove_package_path($path, $remove_config);
            }
        }
    }

    private function _load_controller($uri = '', $params = array(), $return = FALSE) {
        $router = & $this->_ci_get_component('router');
        $backup = array();
        foreach (array(
    'directory',
    'class',
    'method',
    'module'
        ) as $prop) {
            $backup[$prop] = $router->{$prop};
        }
        $segments = $router->locate(explode('/', $uri));
        $class = isset($segments[0]) ? $segments[0] : FALSE;
        $method = isset($segments[1]) ? $segments[1] : "index";
        if (!$class) {
            return;
        }
        if (!array_key_exists(strtolower($class), $this->_ci_controllers)) {
            $filepath = APPPATH . 'controllers/' . $router->fetch_directory() . $class . '.php';
            if (file_exists($filepath)) {
                include_once($filepath);
            }
            if (!class_exists($class)) {
                show_404("{$class}/{$method}");
            }
            $this->_ci_controllers[strtolower($class)] = new $class();
        }
        $controller = $this->_ci_controllers[strtolower($class)];
        if (!method_exists($controller, $method)) {
            show_404("{$class}/{$method}");
        }
        foreach ($backup as $prop => $value) {
            $router->{$prop} = $value;
        }
        ob_start();
        $result = call_user_func_array(array(
            $controller,
            $method
                ), $params);
        if ($return === TRUE) {
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        }
        ob_end_flush();
        return $result;
    }

    private function detect_module($class) {
        $class = str_replace('.php', '', trim($class, '/'));
        if (($first_slash = strpos($class, '/')) !== FALSE) {
            $module = substr($class, 0, $first_slash);
            $class = substr($class, $first_slash + 1);
            if ($this->find_module($module)) {
                return array(
                    $module,
                    $class
                );
            }
        }
        return FALSE;
    }

    private function find_module($module) {
        $config = & $this->_ci_get_component('config');
        foreach ($config->item('modules_locations') as $location) {
            $path = $location . rtrim($module, '/') . '/';
            if (is_dir($path)) {
                return $path;
            }
        }
        return FALSE;
    }

}
