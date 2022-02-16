<?php

defined('BASEPATH') or exit('No direct script access allowed');

class CI_Loader {

    protected $_ci_ob_level;
    protected $_ci_view_paths = array(
        VIEWPATH => true
    );
    protected $_ci_library_paths = array(
        APPPATH,
        BASEPATH
    );
    protected $_ci_model_paths = array(
        APPPATH
    );
    protected $_ci_helper_paths = array(
        APPPATH,
        BASEPATH
    );
    protected $_ci_cached_vars = array();
    protected $_ci_classes = array();
    protected $_ci_models = array();
    protected $_ci_helpers = array();
    protected $_ci_varmap = array(
        'unit_test' => 'unit',
        'user_agent' => 'agent'
    );

    public function __construct() {
        $this->_ci_ob_level = ob_get_level();
        $this->_ci_classes = & is_loaded();
        log_message('info', 'Loader Class Initialized');
    }

    public function initialize() {
        $this->_ci_autoloader();
    }

    public function is_loaded($class) {
        return array_search(ucfirst($class), $this->_ci_classes, true);
    }

    public function library($library, $params = NULL, $object_name = NULL) {
        if (empty($library)) {
            return $this;
        } elseif (is_array($library)) {
            foreach ($library as $key => $value) {
                if (is_int($key)) {
                    $this->library($value, $params);
                } else {
                    $this->library($key, $params, $value);
                }
            }
            return $this;
        }
        if ($params !== NULL && !is_array($params)) {
            $params = NULL;
        }
        $this->_ci_load_library($library, $params, $object_name);
        return $this;
    }

    public function model($model, $name = '', $db_conn = false) {
        if (empty($model)) {
            return $this;
        } elseif (is_array($model)) {
            foreach ($model as $key => $value) {
                is_int($key) ? $this->model($value, '', $db_conn) : $this->model($key, $value, $db_conn);
            }
            return $this;
        }
        $path = '';
        if (($last_slash = strrpos($model, '/')) !== false) {
            $path = substr($model, 0, ++$last_slash);
            $model = substr($model, $last_slash);
        }
        if (empty($name)) {
            $name = $model;
        }
        if (in_array($name, $this->_ci_models, true)) {
            return $this;
        }
        $CI = & get_instance();
        if (isset($CI->$name)) {
            throw new RuntimeException('The model name you are loading is the name of a resource that is already being used: ' . $name);
        }
        if ($db_conn !== false && !class_exists('CI_DB', false)) {
            if ($db_conn === true) {
                $db_conn = '';
            }
            $this->database($db_conn, false, true);
        }
        if (!class_exists('CI_Model', false)) {
            $app_path = APPPATH . 'core' . DIRECTORY_SEPARATOR;
            if (file_exists($app_path . 'Model.php')) {
                require_once ($app_path . 'Model.php');
                if (!class_exists('CI_Model', false)) {
                    throw new RuntimeException($app_path . "Model.php exists, but doesn't declare class CI_Model");
                }
                log_message('info', 'CI_Model class loaded');
            } elseif (!class_exists('CI_Model', false)) {
                require_once (BASEPATH . 'core' . DIRECTORY_SEPARATOR . 'Model.php');
            }
            $class = config_item('subclass_prefix') . 'Model';
            if (file_exists($app_path . $class . '.php')) {
                require_once ($app_path . $class . '.php');
                if (!class_exists($class, false)) {
                    throw new RuntimeException($app_path . $class . ".php exists, but doesn't declare class " . $class);
                }
                log_message('info', config_item('subclass_prefix') . 'Model class loaded');
            }
        }
        $model = ucfirst($model);
        if (!class_exists($model, false)) {
            foreach ($this->_ci_model_paths as $mod_path) {
                if (!file_exists($mod_path . 'models/' . $path . $model . '.php')) {
                    continue;
                }
                require_once ($mod_path . 'models/' . $path . $model . '.php');
                if (!class_exists($model, false)) {
                    throw new RuntimeException($mod_path . "models/" . $path . $model . ".php exists, but doesn't declare class " . $model);
                }
                break;
            }
            if (!class_exists($model, false)) {
                throw new RuntimeException('Unable to locate the model you have specified: ' . $model);
            }
        } elseif (!is_subclass_of($model, 'CI_Model')) {
            throw new RuntimeException("Class " . $model . " already exists and doesn't extend CI_Model");
        }
        $this->_ci_models[] = $name;
        $model = new $model();
        $CI->$name = $model;
        log_message('info', 'Model "' . get_class($model) . '" initialized');
        return $this;
    }

    public function database($params = '', $return = false, $query_builder = NULL) {
        $CI = & get_instance();
        if ($return === false && $query_builder === NULL && isset($CI->db) && is_object($CI->db) && !empty($CI
                        ->db
                        ->conn_id)) {
            return false;
        }
        require_once (BASEPATH . 'database/DB.php');
        if ($return === true) {
            return DB($params, $query_builder);
        }
        $CI->db = '';
        $CI->db = & DB($params, $query_builder);
        return $this;
    }

    public function dbutil($db = NULL, $return = false) {
        $CI = & get_instance();
        if (!is_object($db) or!($db instanceof CI_DB)) {
            class_exists('CI_DB', false) or $this->database();
            $db = & $CI->db;
        }
        require_once (BASEPATH . 'database/DB_utility.php');
        require_once (BASEPATH . 'database/drivers/' . $db->dbdriver . '/' . $db->dbdriver . '_utility.php');
        $class = 'CI_DB_' . $db->dbdriver . '_utility';
        if ($return === true) {
            return new $class($db);
        }
        $CI->dbutil = new $class($db);
        return $this;
    }

    public function dbforge($db = NULL, $return = false) {
        $CI = & get_instance();
        if (!is_object($db) or!($db instanceof CI_DB)) {
            class_exists('CI_DB', false) or $this->database();
            $db = & $CI->db;
        }
        require_once (BASEPATH . 'database/DB_forge.php');
        require_once (BASEPATH . 'database/drivers/' . $db->dbdriver . '/' . $db->dbdriver . '_forge.php');
        if (!empty($db->subdriver)) {
            $driver_path = BASEPATH . 'database/drivers/' . $db->dbdriver . '/subdrivers/' . $db->dbdriver . '_' . $db->subdriver . '_forge.php';
            if (file_exists($driver_path)) {
                require_once ($driver_path);
                $class = 'CI_DB_' . $db->dbdriver . '_' . $db->subdriver . '_forge';
            }
        } else {
            $class = 'CI_DB_' . $db->dbdriver . '_forge';
        }
        if ($return === true) {
            return new $class($db);
        }
        $CI->dbforge = new $class($db);
        return $this;
    }

    public function view($view, $vars = array(), $return = false) {
        return $this->_ci_load(array(
                    '_ci_view' => $view,
                    '_ci_vars' => $this->_ci_prepare_view_vars($vars),
                    '_ci_return' => $return
        ));
    }

    public function file($path, $return = false) {
        return $this->_ci_load(array(
                    '_ci_path' => $path,
                    '_ci_return' => $return
        ));
    }

    public function vars($vars, $val = '') {
        $vars = is_string($vars) ? array(
            $vars => $val
                ) : $this->_ci_prepare_view_vars($vars);
        foreach ($vars as $key => $val) {
            $this->_ci_cached_vars[$key] = $val;
        }
        return $this;
    }

    public function clear_vars() {
        $this->_ci_cached_vars = array();
        return $this;
    }

    public function get_var($key) {
        return isset($this->_ci_cached_vars[$key]) ? $this->_ci_cached_vars[$key] : NULL;
    }

    public function get_vars() {
        return $this->_ci_cached_vars;
    }

    public function helper($helpers = array()) {
        is_array($helpers) or $helpers = array(
            $helpers
        );
        foreach ($helpers as & $helper) {
            $filename = basename($helper);
            $filepath = ($filename === $helper) ? '' : substr($helper, 0, strlen($helper) - strlen($filename));
            $filename = strtolower(preg_replace('#(_helper)?(\.php)?$#i', '', $filename)) . '_helper';
            $helper = $filepath . $filename;
            if (isset($this->_ci_helpers[$helper])) {
                continue;
            }
            $ext_helper = config_item('subclass_prefix') . $filename;
            $ext_loaded = false;
            foreach ($this->_ci_helper_paths as $path) {
                if (file_exists($path . 'helpers/' . $ext_helper . '.php')) {
                    include_once ($path . 'helpers/' . $ext_helper . '.php');
                    $ext_loaded = true;
                }
            }
            if ($ext_loaded === true) {
                $base_helper = BASEPATH . 'helpers/' . $helper . '.php';
                if (!file_exists($base_helper)) {
                    show_error('Unable to load the requested file: helpers/' . $helper . '.php');
                }
                include_once ($base_helper);
                $this->_ci_helpers[$helper] = true;
                log_message('info', 'Helper loaded: ' . $helper);
                continue;
            }
            foreach ($this->_ci_helper_paths as $path) {
                if (file_exists($path . 'helpers/' . $helper . '.php')) {
                    include_once ($path . 'helpers/' . $helper . '.php');
                    $this->_ci_helpers[$helper] = true;
                    log_message('info', 'Helper loaded: ' . $helper);
                    break;
                }
            }
            if (!isset($this->_ci_helpers[$helper])) {
                show_error('Unable to load the requested file: helpers/' . $helper . '.php');
            }
        }
        return $this;
    }

    public function helpers($helpers = array()) {
        return $this->helper($helpers);
    }

    public function language($files, $lang = '') {
        get_instance()
                ->lang
                ->load($files, $lang);
        return $this;
    }

    public function config($file, $use_sections = false, $fail_gracefully = false) {
        return get_instance()
                        ->config
                        ->load($file, $use_sections, $fail_gracefully);
    }

    public function driver($library, $params = NULL, $object_name = NULL) {
        if (is_array($library)) {
            foreach ($library as $key => $value) {
                if (is_int($key)) {
                    $this->driver($value, $params);
                } else {
                    $this->driver($key, $params, $value);
                }
            }
            return $this;
        } elseif (empty($library)) {
            return false;
        }
        if (!class_exists('CI_Driver_Library', false)) {
            require BASEPATH . 'libraries/Driver.php';
        }
        if (!strpos($library, '/')) {
            $library = ucfirst($library) . '/' . $library;
        }
        return $this->library($library, $params, $object_name);
    }

    public function add_package_path($path, $view_cascade = true) {
        $path = rtrim($path, '/') . '/';
        array_unshift($this->_ci_library_paths, $path);
        array_unshift($this->_ci_model_paths, $path);
        array_unshift($this->_ci_helper_paths, $path);
        $this->_ci_view_paths = array(
            $path . 'views/' => $view_cascade
                ) + $this->_ci_view_paths;
        $config = & $this->_ci_get_component('config');
        $config->_config_paths[] = $path;
        return $this;
    }

    public function get_package_paths($include_base = false) {
        return ($include_base === true) ? $this->_ci_library_paths : $this->_ci_model_paths;
    }

    public function remove_package_path($path = '') {
        $config = & $this->_ci_get_component('config');
        if ($path === '') {
            array_shift($this->_ci_library_paths);
            array_shift($this->_ci_model_paths);
            array_shift($this->_ci_helper_paths);
            array_shift($this->_ci_view_paths);
            array_pop($config->_config_paths);
        } else {
            $path = rtrim($path, '/') . '/';
            foreach (array(
        '_ci_library_paths',
        '_ci_model_paths',
        '_ci_helper_paths'
            ) as $var) {
                if (($key = array_search($path, $this->{$var})) !== false) {
                    unset($this->{$var}[$key]);
                }
            }
            if (isset($this->_ci_view_paths[$path . 'views/'])) {
                unset($this->_ci_view_paths[$path . 'views/']);
            }
            if (($key = array_search($path, $config->_config_paths)) !== false) {
                unset($config->_config_paths[$key]);
            }
        }
        $this->_ci_library_paths = array_unique(array_merge($this->_ci_library_paths, array(
            APPPATH,
            BASEPATH
        )));
        $this->_ci_helper_paths = array_unique(array_merge($this->_ci_helper_paths, array(
            APPPATH,
            BASEPATH
        )));
        $this->_ci_model_paths = array_unique(array_merge($this->_ci_model_paths, array(
            APPPATH
        )));
        $this->_ci_view_paths = array_merge($this->_ci_view_paths, array(
            APPPATH . 'views/' => true
        ));
        $config->_config_paths = array_unique(array_merge($config->_config_paths, array(
            APPPATH
        )));
        return $this;
    }

    protected function _ci_load($_ci_data) {
        foreach (array(
    '_ci_view',
    '_ci_vars',
    '_ci_path',
    '_ci_return'
        ) as $_ci_val) {
            $$_ci_val = isset($_ci_data[$_ci_val]) ? $_ci_data[$_ci_val] : false;
        }
        $file_exists = false;
        if (is_string($_ci_path) && $_ci_path !== '') {
            $_ci_x = explode('/', $_ci_path);
            $_ci_file = end($_ci_x);
        } else {
            $_ci_ext = pathinfo($_ci_view, PATHINFO_EXTENSION);
            $_ci_file = ($_ci_ext === '') ? $_ci_view . '.php' : $_ci_view;
            foreach ($this->_ci_view_paths as $_ci_view_file => $cascade) {
                if (file_exists($_ci_view_file . $_ci_file)) {
                    $_ci_path = $_ci_view_file . $_ci_file;
                    $file_exists = true;
                    break;
                }
                if (!$cascade) {
                    break;
                }
            }
        }
        if (!$file_exists && !file_exists($_ci_path)) {
            show_error('Unable to load the requested file: ' . $_ci_file);
        }
        $_ci_CI = & get_instance();
        foreach (get_object_vars($_ci_CI) as $_ci_key => $_ci_var) {
            if (!isset($this->$_ci_key)) {
                $this->$_ci_key = & $_ci_CI->$_ci_key;
            }
        }
        empty($_ci_vars) or $this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $_ci_vars);
        extract($this->_ci_cached_vars);
        ob_start();
        if (!is_php('5.4') && !ini_get('short_open_tag') && config_item('rewrite_short_tags') === true) {
            echo eval('?>' . preg_replace('/;*\s*\?>/', '; ?>', str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
        } else {
            include ($_ci_path);
        }
        log_message('info', 'File loaded: ' . $_ci_path);
        if ($_ci_return === true) {
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        }
        if (ob_get_level() > $this->_ci_ob_level + 1) {
            ob_end_flush();
        } else {
            $_ci_CI
                    ->output
                    ->append_output(ob_get_contents());
            @ob_end_clean();
        }
        return $this;
    }

    protected function _ci_load_library($class, $params = NULL, $object_name = NULL) {
        $class = str_replace('.php', '', trim($class, '/'));
        if (($last_slash = strrpos($class, '/')) !== false) {
            $subdir = substr($class, 0, ++$last_slash);
            $class = substr($class, $last_slash);
        } else {
            $subdir = '';
        }
        $class = ucfirst($class);
        if (file_exists(BASEPATH . 'libraries/' . $subdir . $class . '.php')) {
            return $this->_ci_load_stock_library($class, $subdir, $params, $object_name);
        }
        if (class_exists($class, false)) {
            $property = $object_name;
            if (empty($property)) {
                $property = strtolower($class);
                isset($this->_ci_varmap[$property]) && $property = $this->_ci_varmap[$property];
            }
            $CI = & get_instance();
            if (isset($CI->$property)) {
                log_message('debug', $class . ' class already loaded. Second attempt ignored.');
                return;
            }
            return $this->_ci_init_library($class, '', $params, $object_name);
        }
        foreach ($this->_ci_library_paths as $path) {
            if ($path === BASEPATH) {
                continue;
            }
            $filepath = $path . 'libraries/' . $subdir . $class . '.php';
            if (!file_exists($filepath)) {
                continue;
            }
            include_once ($filepath);
            return $this->_ci_init_library($class, '', $params, $object_name);
        }
        if ($subdir === '') {
            return $this->_ci_load_library($class . '/' . $class, $params, $object_name);
        }
        log_message('error', 'Unable to load the requested class: ' . $class);
        show_error('Unable to load the requested class: ' . $class);
    }

    protected function _ci_load_stock_library($library_name, $file_path, $params, $object_name) {
        $prefix = 'CI_';
        if (class_exists($prefix . $library_name, false)) {
            if (class_exists(config_item('subclass_prefix') . $library_name, false)) {
                $prefix = config_item('subclass_prefix');
            }
            $property = $object_name;
            if (empty($property)) {
                $property = strtolower($library_name);
                isset($this->_ci_varmap[$property]) && $property = $this->_ci_varmap[$property];
            }
            $CI = & get_instance();
            if (!isset($CI->$property)) {
                return $this->_ci_init_library($library_name, $prefix, $params, $object_name);
            }
            log_message('debug', $library_name . ' class already loaded. Second attempt ignored.');
            return;
        }
        $paths = $this->_ci_library_paths;
        array_pop($paths);
        array_pop($paths);
        array_unshift($paths, APPPATH);
        foreach ($paths as $path) {
            if (file_exists($path = $path . 'libraries/' . $file_path . $library_name . '.php')) {
                include_once ($path);
                if (class_exists($prefix . $library_name, false)) {
                    return $this->_ci_init_library($library_name, $prefix, $params, $object_name);
                }
                log_message('debug', $path . ' exists, but does not declare ' . $prefix . $library_name);
            }
        }
        include_once (BASEPATH . 'libraries/' . $file_path . $library_name . '.php');
        $subclass = config_item('subclass_prefix') . $library_name;
        foreach ($paths as $path) {
            if (file_exists($path = $path . 'libraries/' . $file_path . $subclass . '.php')) {
                include_once ($path);
                if (class_exists($subclass, false)) {
                    $prefix = config_item('subclass_prefix');
                    break;
                }
                log_message('debug', $path . ' exists, but does not declare ' . $subclass);
            }
        }
        return $this->_ci_init_library($library_name, $prefix, $params, $object_name);
    }

    protected function _ci_init_library($class, $prefix, $config = false, $object_name = NULL) {
        if ($config === NULL) {
            $config_component = $this->_ci_get_component('config');
            if (is_array($config_component->_config_paths)) {
                $found = false;
                foreach ($config_component->_config_paths as $path) {
                    if (file_exists($path . 'config/' . strtolower($class) . '.php')) {
                        include ($path . 'config/' . strtolower($class) . '.php');
                        $found = true;
                    } elseif (file_exists($path . 'config/' . ucfirst(strtolower($class)) . '.php')) {
                        include ($path . 'config/' . ucfirst(strtolower($class)) . '.php');
                        $found = true;
                    }
                    if (file_exists($path . 'config/' . ENVIRONMENT . '/' . strtolower($class) . '.php')) {
                        include ($path . 'config/' . ENVIRONMENT . '/' . strtolower($class) . '.php');
                        $found = true;
                    } elseif (file_exists($path . 'config/' . ENVIRONMENT . '/' . ucfirst(strtolower($class)) . '.php')) {
                        include ($path . 'config/' . ENVIRONMENT . '/' . ucfirst(strtolower($class)) . '.php');
                        $found = true;
                    }
                    if ($found === true) {
                        break;
                    }
                }
            }
        }
        $class_name = $prefix . $class;
        if (!class_exists($class_name, false)) {
            log_message('error', 'Non-existent class: ' . $class_name);
            show_error('Non-existent class: ' . $class_name);
        }
        if (empty($object_name)) {
            $object_name = strtolower($class);
            if (isset($this->_ci_varmap[$object_name])) {
                $object_name = $this->_ci_varmap[$object_name];
            }
        }
        $CI = & get_instance();
        if (isset($CI->$object_name)) {
            if ($CI->$object_name instanceof $class_name) {
                log_message('debug', $class_name . " has already been instantiated as '" . $object_name . "'. Second attempt aborted.");
                return;
            }
            show_error("Resource '" . $object_name . "' already exists and is not a " . $class_name . " instance.");
        }
        $this->_ci_classes[$object_name] = $class;
        $CI->$object_name = isset($config) ? new $class_name($config) : new $class_name();
    }

    protected function _ci_autoloader() {
        if (file_exists(APPPATH . 'config/autoload.php')) {
            include (APPPATH . 'config/autoload.php');
        }
        if (file_exists(APPPATH . 'config/' . ENVIRONMENT . '/autoload.php')) {
            include (APPPATH . 'config/' . ENVIRONMENT . '/autoload.php');
        }
        if (!isset($autoload)) {
            return;
        }
        if (isset($autoload['packages'])) {
            foreach ($autoload['packages'] as $package_path) {
                $this->add_package_path($package_path);
            }
        }
        if (count($autoload['config']) > 0) {
            foreach ($autoload['config'] as $val) {
                $this->config($val);
            }
        }
        foreach (array(
    'helper',
    'language'
        ) as $type) {
            if (isset($autoload[$type]) && count($autoload[$type]) > 0) {
                $this->$type($autoload[$type]);
            }
        }
        if (isset($autoload['drivers'])) {
            $this->driver($autoload['drivers']);
        }
        if (isset($autoload['libraries']) && count($autoload['libraries']) > 0) {
            if (in_array('database', $autoload['libraries'])) {
                $this->database();
                $autoload['libraries'] = array_diff($autoload['libraries'], array(
                    'database'
                ));
            }
            $this->library($autoload['libraries']);
        }
        if (isset($autoload['model'])) {
            $this->model($autoload['model']);
        }
    }

    protected function _ci_prepare_view_vars($vars) {
        if (!is_array($vars)) {
            $vars = is_object($vars) ? get_object_vars($vars) : array();
        }
        foreach (array_keys($vars) as $key) {
            if (strncmp($key, '_ci_', 4) === 0) {
                unset($vars[$key]);
            }
        }
        return $vars;
    }

    protected function &_ci_get_component($component) {
        $CI = & get_instance();
        return $CI->$component;
    }

}
