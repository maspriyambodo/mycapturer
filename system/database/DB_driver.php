<?php

defined('BASEPATH') or exit('No direct script access allowed');

abstract class CI_DB_driver {

    public $dsn;
    public $username;
    public $password;
    public $hostname;
    public $database;
    public $dbdriver = 'mysqli';
    public $subdriver;
    public $dbprefix = '';
    public $char_set = 'utf8';
    public $dbcollat = 'utf8_general_ci';
    public $encrypt = false;
    public $swap_pre = '';
    public $port = NULL;
    public $pconnect = false;
    public $conn_id = false;
    public $result_id = false;
    public $db_debug = false;
    public $benchmark = 0;
    public $query_count = 0;
    public $bind_marker = '?';
    public $save_queries = true;
    public $queries = array();
    public $query_times = array();
    public $data_cache = array();
    public $trans_enabled = true;
    public $trans_strict = true;
    protected $_trans_depth = 0;
    protected $_trans_status = true;
    protected $_trans_failure = false;
    public $cache_on = false;
    public $cachedir = '';
    public $cache_autodel = false;
    public $CACHE;
    protected $_protect_identifiers = true;
    protected $_reserved_identifiers = array(
        '*'
    );
    protected $_escape_char = '"';
    protected $_like_escape_str = " ESCAPE '%s' ";
    protected $_like_escape_chr = '!';
    protected $_random_keyword = array(
        'RAND()',
        'RAND(%d)'
    );
    protected $_count_string = 'SELECT COUNT(*) AS ';

    public function __construct($params) {
        if (is_array($params)) {
            foreach ($params as $key => $val) {
                $this->$key = $val;
            }
        }
        log_message('info', 'Database Driver Class Initialized');
    }

    public function initialize() {
        if ($this->conn_id) {
            return true;
        }
        $this->conn_id = $this->db_connect($this->pconnect);
        if (!$this->conn_id) {
            if (!empty($this->failover) && is_array($this->failover)) {
                foreach ($this->failover as $failover) {
                    foreach ($failover as $key => $val) {
                        $this->$key = $val;
                    }
                    $this->conn_id = $this->db_connect($this->pconnect);
                    if ($this->conn_id) {
                        break;
                    }
                }
            }
            if (!$this->conn_id) {
                log_message('error', 'Unable to connect to the database');
                if ($this->db_debug) {
                    $this->display_error('db_unable_to_connect');
                }
                return false;
            }
        }
        return $this->db_set_charset($this->char_set);
    }

    public function db_connect() {
        return true;
    }

    public function db_pconnect() {
        return $this->db_connect(true);
    }

    public function reconnect() {
        
    }

    public function db_select() {
        return true;
    }

    public function error() {
        return array(
            'code' => NULL,
            'message' => NULL
        );
    }

    public function db_set_charset($charset) {
        if (method_exists($this, '_db_set_charset') && !$this->_db_set_charset($charset)) {
            log_message('error', 'Unable to set database connection charset: ' . $charset);
            if ($this->db_debug) {
                $this->display_error('db_unable_to_set_charset', $charset);
            }
            return false;
        }
        return true;
    }

    public function platform() {
        return $this->dbdriver;
    }

    public function version() {
        if (isset($this->data_cache['version'])) {
            return $this->data_cache['version'];
        }
        if (false === ($sql = $this->_version())) {
            return ($this->db_debug) ? $this->display_error('db_unsupported_function') : false;
        }
        $query = $this->query($sql)->row();
        return $this->data_cache['version'] = $query->ver;
    }

    protected function _version() {
        return 'SELECT VERSION() AS ver';
    }

    public function query($sql, $binds = false, $return_object = NULL) {
        if ($sql === '') {
            log_message('error', 'Invalid query: ' . $sql);
            return ($this->db_debug) ? $this->display_error('db_invalid_query') : false;
        } elseif (!is_bool($return_object)) {
            $return_object = !$this->is_write_type($sql);
        }
        if ($this->dbprefix !== '' && $this->swap_pre !== '' && $this->dbprefix !== $this->swap_pre) {
            $sql = preg_replace('/(\W)' . $this->swap_pre . '(\S+?)/', '\\1' . $this->dbprefix . '\\2', $sql);
        }
        if ($binds !== false) {
            $sql = $this->compile_binds($sql, $binds);
        }
        if ($this->cache_on === true && $return_object === true && $this->_cache_init()) {
            $this->load_rdriver();
            if (false !== ($cache = $this
                    ->CACHE
                    ->read($sql))) {
                return $cache;
            }
        }
        if ($this->save_queries === true) {
            $this->queries[] = $sql;
        }
        $time_start = microtime(true);
        if (false === ($this->result_id = $this->simple_query($sql))) {
            if ($this->save_queries === true) {
                $this->query_times[] = 0;
            }
            if ($this->_trans_depth !== 0) {
                $this->_trans_status = false;
            }
            $error = $this->error();
            log_message('error', 'Query error: ' . $error['message'] . ' - Invalid query: ' . $sql);
            if ($this->db_debug) {
                while ($this->_trans_depth !== 0) {
                    $trans_depth = $this->_trans_depth;
                    $this->trans_complete();
                    if ($trans_depth === $this->_trans_depth) {
                        log_message('error', 'Database: Failure during an automated transaction commit/rollback!');
                        break;
                    }
                }
                return $this->display_error(array(
                            'Error Number: ' . $error['code'],
                            $error['message'],
                            $sql
                ));
            }
            return false;
        }
        $time_end = microtime(true);
        $this->benchmark += $time_end - $time_start;
        if ($this->save_queries === true) {
            $this->query_times[] = $time_end - $time_start;
        }
        $this->query_count++;
        if ($return_object !== true) {
            if ($this->cache_on === true && $this->cache_autodel === true && $this->_cache_init()) {
                $this
                        ->CACHE
                        ->delete();
            }
            return true;
        }
        $driver = $this->load_rdriver();
        $RES = new $driver($this);
        if ($this->cache_on === true && $this->_cache_init()) {
            $CR = new CI_DB_result($this);
            $CR->result_object = $RES->result_object();
            $CR->result_array = $RES->result_array();
            $CR->num_rows = $RES->num_rows();
            $CR->conn_id = NULL;
            $CR->result_id = NULL;
            $this
                    ->CACHE
                    ->write($sql, $CR);
        }
        return $RES;
    }

    public function load_rdriver() {
        $driver = 'CI_DB_' . $this->dbdriver . '_result';
        if (!class_exists($driver, false)) {
            require_once (BASEPATH . 'database/DB_result.php');
            require_once (BASEPATH . 'database/drivers/' . $this->dbdriver . '/' . $this->dbdriver . '_result.php');
        }
        return $driver;
    }

    public function simple_query($sql) {
        if (!$this->conn_id) {
            if (!$this->initialize()) {
                return false;
            }
        }
        return $this->_execute($sql);
    }

    public function trans_off() {
        $this->trans_enabled = false;
    }

    public function trans_strict($mode = true) {
        $this->trans_strict = is_bool($mode) ? $mode : true;
    }

    public function trans_start($test_mode = false) {
        if (!$this->trans_enabled) {
            return false;
        }
        return $this->trans_begin($test_mode);
    }

    public function trans_complete() {
        if (!$this->trans_enabled) {
            return false;
        }
        if ($this->_trans_status === false or $this->_trans_failure === true) {
            $this->trans_rollback();
            if ($this->trans_strict === false) {
                $this->_trans_status = true;
            }
            log_message('debug', 'DB Transaction Failure');
            return false;
        }
        return $this->trans_commit();
    }

    public function trans_status() {
        return $this->_trans_status;
    }

    public function trans_begin($test_mode = false) {
        if (!$this->trans_enabled) {
            return false;
        } elseif ($this->_trans_depth > 0) {
            $this->_trans_depth++;
            return true;
        }
        $this->_trans_failure = ($test_mode === true);
        if ($this->_trans_begin()) {
            $this->_trans_status = true;
            $this->_trans_depth++;
            return true;
        }
        return false;
    }

    public function trans_commit() {
        if (!$this->trans_enabled or $this->_trans_depth === 0) {
            return false;
        } elseif ($this->_trans_depth > 1 or $this->_trans_commit()) {
            $this->_trans_depth--;
            return true;
        }
        return false;
    }

    public function trans_rollback() {
        if (!$this->trans_enabled or $this->_trans_depth === 0) {
            return false;
        } elseif ($this->_trans_depth > 1 or $this->_trans_rollback()) {
            $this->_trans_depth--;
            return true;
        }
        return false;
    }

    public function compile_binds($sql, $binds) {
        if (empty($this->bind_marker) or strpos($sql, $this->bind_marker) === false) {
            return $sql;
        } elseif (!is_array($binds)) {
            $binds = array(
                $binds
            );
            $bind_count = 1;
        } else {
            $binds = array_values($binds);
            $bind_count = count($binds);
        }
        $ml = strlen($this->bind_marker);
        if ($c = preg_match_all("/'[^']*'|\"[^\"]*\"/i", $sql, $matches)) {
            $c = preg_match_all('/' . preg_quote($this->bind_marker, '/') . '/i', str_replace($matches[0], str_replace($this->bind_marker, str_repeat(' ', $ml), $matches[0]), $sql, $c), $matches, PREG_OFFSET_CAPTURE);
            if ($bind_count !== $c) {
                return $sql;
            }
        } elseif (($c = preg_match_all('/' . preg_quote($this->bind_marker, '/') . '/i', $sql, $matches, PREG_OFFSET_CAPTURE)) !== $bind_count) {
            return $sql;
        }
        do {
            $c--;
            $escaped_value = $this->escape($binds[$c]);
            if (is_array($escaped_value)) {
                $escaped_value = '(' . implode(',', $escaped_value) . ')';
            }
            $sql = substr_replace($sql, $escaped_value, $matches[0][$c][1], $ml);
        } while ($c !== 0);
        return $sql;
    }

    public function is_write_type($sql) {
        return (bool) preg_match('/^\s*"?(SET|INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|TRUNCATE|LOAD|COPY|ALTER|RENAME|GRANT|REVOKE|LOCK|UNLOCK|REINDEX|MERGE)\s/i', $sql);
    }

    public function elapsed_time($decimals = 6) {
        return number_format($this->benchmark, $decimals);
    }

    public function total_queries() {
        return $this->query_count;
    }

    public function last_query() {
        return end($this->queries);
    }

    public function escape($str) {
        if (is_array($str)) {
            $str = array_map(array(&$this,
                'escape'
                    ), $str);
            return $str;
        } elseif (is_string($str) or (is_object($str) && method_exists($str, '__toString'))) {
            return "'" . $this->escape_str($str) . "'";
        } elseif (is_bool($str)) {
            return ($str === false) ? 0 : 1;
        } elseif ($str === NULL) {
            return 'NULL';
        }
        return $str;
    }

    public function escape_str($str, $like = false) {
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = $this->escape_str($val, $like);
            }
            return $str;
        }
        $str = $this->_escape_str($str);
        if ($like === true) {
            return str_replace(array(
                $this->_like_escape_chr,
                '%',
                '_'
                    ), array(
                $this->_like_escape_chr . $this->_like_escape_chr,
                $this->_like_escape_chr . '%',
                $this->_like_escape_chr . '_'
                    ), $str);
        }
        return $str;
    }

    public function escape_like_str($str) {
        return $this->escape_str($str, true);
    }

    protected function _escape_str($str) {
        return str_replace("'", "''", remove_invisible_characters($str, false));
    }

    public function primary($table) {
        $fields = $this->list_fields($table);
        return is_array($fields) ? current($fields) : false;
    }

    public function count_all($table = '') {
        if ($table === '') {
            return 0;
        }
        $query = $this->query($this->_count_string . $this->escape_identifiers('numrows') . ' FROM ' . $this->protect_identifiers($table, true, NULL, false));
        if ($query->num_rows() === 0) {
            return 0;
        }
        $query = $query->row();
        $this->_reset_select();
        return (int) $query->numrows;
    }

    public function list_tables($constrain_by_prefix = false) {
        if (isset($this->data_cache['table_names'])) {
            return $this->data_cache['table_names'];
        }
        if (false === ($sql = $this->_list_tables($constrain_by_prefix))) {
            return ($this->db_debug) ? $this->display_error('db_unsupported_function') : false;
        }
        $this->data_cache['table_names'] = array();
        $query = $this->query($sql);
        foreach ($query->result_array() as $row) {
            if (!isset($key)) {
                if (isset($row['table_name'])) {
                    $key = 'table_name';
                } elseif (isset($row['TABLE_NAME'])) {
                    $key = 'TABLE_NAME';
                } else {
                    $key = array_keys($row);
                    $key = array_shift($key);
                }
            }
            $this->data_cache['table_names'][] = $row[$key];
        }
        return $this->data_cache['table_names'];
    }

    public function table_exists($table_name) {
        return in_array($this->protect_identifiers($table_name, true, false, false), $this->list_tables());
    }

    public function list_fields($table) {
        if (false === ($sql = $this->_list_columns($table))) {
            return ($this->db_debug) ? $this->display_error('db_unsupported_function') : false;
        }
        $query = $this->query($sql);
        $fields = array();
        foreach ($query->result_array() as $row) {
            if (!isset($key)) {
                if (isset($row['column_name'])) {
                    $key = 'column_name';
                } elseif (isset($row['COLUMN_NAME'])) {
                    $key = 'COLUMN_NAME';
                } else {
                    $key = key($row);
                }
            }
            $fields[] = $row[$key];
        }
        return $fields;
    }

    public function field_exists($field_name, $table_name) {
        return in_array($field_name, $this->list_fields($table_name));
    }

    public function field_data($table) {
        $query = $this->query($this->_field_data($this->protect_identifiers($table, true, NULL, false)));
        return ($query) ? $query->field_data() : false;
    }

    public function escape_identifiers($item) {
        if ($this->_escape_char === '' or empty($item) or in_array($item, $this->_reserved_identifiers)) {
            return $item;
        } elseif (is_array($item)) {
            foreach ($item as $key => $value) {
                $item[$key] = $this->escape_identifiers($value);
            }
            return $item;
        } elseif (ctype_digit($item) or $item[0] === "'" or ($this->_escape_char !== '"' && $item[0] === '"') or strpos($item, '(') !== false) {
            return $item;
        }
        static $preg_ec = array();
        if (empty($preg_ec)) {
            if (is_array($this->_escape_char)) {
                $preg_ec = array(
                    preg_quote($this->_escape_char[0], '/'),
                    preg_quote($this->_escape_char[1], '/'),
                    $this->_escape_char[0],
                    $this->_escape_char[1]
                );
            } else {
                $preg_ec[0] = $preg_ec[1] = preg_quote($this->_escape_char, '/');
                $preg_ec[2] = $preg_ec[3] = $this->_escape_char;
            }
        }
        foreach ($this->_reserved_identifiers as $id) {
            if (strpos($item, '.' . $id) !== false) {
                return preg_replace('/' . $preg_ec[0] . '?([^' . $preg_ec[1] . '\.]+)' . $preg_ec[1] . '?\./i', $preg_ec[2] . '$1' . $preg_ec[3] . '.', $item);
            }
        }
        return preg_replace('/' . $preg_ec[0] . '?([^' . $preg_ec[1] . '\.]+)' . $preg_ec[1] . '?(\.)?/i', $preg_ec[2] . '$1' . $preg_ec[3] . '$2', $item);
    }

    public function insert_string($table, $data) {
        $fields = $values = array();
        foreach ($data as $key => $val) {
            $fields[] = $this->escape_identifiers($key);
            $values[] = $this->escape($val);
        }
        return $this->_insert($this->protect_identifiers($table, true, NULL, false), $fields, $values);
    }

    protected function _insert($table, $keys, $values) {
        return 'INSERT INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES (' . implode(', ', $values) . ')';
    }

    public function update_string($table, $data, $where) {
        if (empty($where)) {
            return false;
        }
        $this->where($where);
        $fields = array();
        foreach ($data as $key => $val) {
            $fields[$this->protect_identifiers($key)] = $this->escape($val);
        }
        $sql = $this->_update($this->protect_identifiers($table, true, NULL, false), $fields);
        $this->_reset_write();
        return $sql;
    }

    protected function _update($table, $values) {
        foreach ($values as $key => $val) {
            $valstr[] = $key . ' = ' . $val;
        }
        return 'UPDATE ' . $table . ' SET ' . implode(', ', $valstr) . $this->_compile_wh('qb_where') . $this->_compile_order_by() . ($this->qb_limit !== false ? ' LIMIT ' . $this->qb_limit : '');
    }

    protected function _has_operator($str) {
        return (bool) preg_match('/(<|>|!|=|\sIS NULL|\sIS NOT NULL|\sEXISTS|\sBETWEEN|\sLIKE|\sIN\s*\(|\s)/i', trim($str));
    }

    protected function _get_operator($str) {
        static $_operators;
        if (empty($_operators)) {
            $_les = ($this->_like_escape_str !== '') ? '\s+' . preg_quote(trim(sprintf($this->_like_escape_str, $this->_like_escape_chr)), '/') : '';
            $_operators = array(
                '\s*(?:<|>|!)?=\s*',
                '\s*<>?\s*',
                '\s*>\s*',
                '\s+IS NULL',
                '\s+IS NOT NULL',
                '\s+EXISTS\s*\(.*\)',
                '\s+NOT EXISTS\s*\(.*\)',
                '\s+BETWEEN\s+',
                '\s+IN\s*\(.*\)',
                '\s+NOT IN\s*\(.*\)',
                '\s+LIKE\s+\S.*(' . $_les . ')?',
                '\s+NOT LIKE\s+\S.*(' . $_les . ')?'
            );
        }
        return preg_match('/' . implode('|', $_operators) . '/i', $str, $match) ? $match[0] : false;
    }

    public function call_function($function) {
        $driver = ($this->dbdriver === 'postgre') ? 'pg_' : $this->dbdriver . '_';
        if (false === strpos($driver, $function)) {
            $function = $driver . $function;
        }
        if (!function_exists($function)) {
            return ($this->db_debug) ? $this->display_error('db_unsupported_function') : false;
        }
        return (func_num_args() > 1) ? call_user_func_array($function, array_slice(func_get_args(), 1)) : call_user_func($function);
    }

    public function cache_set_path($path = '') {
        $this->cachedir = $path;
    }

    public function cache_on() {
        return $this->cache_on = true;
    }

    public function cache_off() {
        return $this->cache_on = false;
    }

    public function cache_delete($segment_one = '', $segment_two = '') {
        return $this->_cache_init() ? $this
                        ->CACHE
                        ->delete($segment_one, $segment_two) : false;
    }

    public function cache_delete_all() {
        return $this->_cache_init() ? $this
                        ->CACHE
                        ->delete_all() : false;
    }

    protected function _cache_init() {
        if (!class_exists('CI_DB_Cache', false)) {
            require_once (BASEPATH . 'database/DB_cache.php');
        } elseif (is_object($this->CACHE)) {
            return true;
        }
        $this->CACHE = new CI_DB_Cache($this);
        return true;
    }

    public function close() {
        if ($this->conn_id) {
            $this->_close();
            $this->conn_id = false;
        }
    }

    protected function _close() {
        $this->conn_id = false;
    }

    public function display_error($error = '', $swap = '', $native = false) {
        $LANG = & load_class('Lang', 'core');
        $LANG->load('db');
        $heading = $LANG->line('db_error_heading');
        if ($native === true) {
            $message = (array) $error;
        } else {
            $message = is_array($error) ? $error : array(
                str_replace('%s', $swap, $LANG->line($error))
            );
        }
        $trace = debug_backtrace();
        foreach ($trace as $call) {
            if (isset($call['file'], $call['class'])) {
                if (DIRECTORY_SEPARATOR !== '/') {
                    $call['file'] = str_replace('\\', '/', $call['file']);
                }
                if (strpos($call['file'], BASEPATH . 'database') === false && strpos($call['class'], 'Loader') === false) {
                    $message[] = 'Filename: ' . str_replace(array(
                                APPPATH,
                                BASEPATH
                                    ), '', $call['file']);
                    $message[] = 'Line Number: ' . $call['line'];
                    break;
                }
            }
        }
        $error = & load_class('Exceptions', 'core');
        echo $error->show_error($heading, $message, 'error_db');
        exit(8);
    }

    public function protect_identifiers($item, $prefix_single = false, $protect_identifiers = NULL, $field_exists = true) {
        if (!is_bool($protect_identifiers)) {
            $protect_identifiers = $this->_protect_identifiers;
        }
        if (is_array($item)) {
            $escaped_array = array();
            foreach ($item as $k => $v) {
                $escaped_array[$this->protect_identifiers($k)] = $this->protect_identifiers($v, $prefix_single, $protect_identifiers, $field_exists);
            }
            return $escaped_array;
        }
        if (strcspn($item, "()'") !== strlen($item)) {
            return $item;
        }
        $item = preg_replace('/\s+/', ' ', trim($item));
        if ($offset = strripos($item, ' AS ')) {
            $alias = ($protect_identifiers) ? substr($item, $offset, 4) . $this->escape_identifiers(substr($item, $offset + 4)) : substr($item, $offset);
            $item = substr($item, 0, $offset);
        } elseif ($offset = strrpos($item, ' ')) {
            $alias = ($protect_identifiers) ? ' ' . $this->escape_identifiers(substr($item, $offset + 1)) : substr($item, $offset);
            $item = substr($item, 0, $offset);
        } else {
            $alias = '';
        }
        if (strpos($item, '.') !== false) {
            $parts = explode('.', $item);
            if (!empty($this->qb_aliased_tables) && in_array($parts[0], $this->qb_aliased_tables)) {
                if ($protect_identifiers === true) {
                    foreach ($parts as $key => $val) {
                        if (!in_array($val, $this->_reserved_identifiers)) {
                            $parts[$key] = $this->escape_identifiers($val);
                        }
                    }
                    $item = implode('.', $parts);
                }
                return $item . $alias;
            }
            if ($this->dbprefix !== '') {
                if (isset($parts[3])) {
                    $i = 2;
                } elseif (isset($parts[2])) {
                    $i = 1;
                } else {
                    $i = 0;
                }
                if ($field_exists === false) {
                    $i++;
                }
                $ec = '(?<ec>' . preg_quote(is_array($this->_escape_char) ? $this->_escape_char[0] : $this->_escape_char) . ')?';
                isset($ec[0]) && $ec .= '?';
                if ($this->swap_pre !== '' && preg_match('#^' . $ec . preg_quote($this->swap_pre) . '#', $parts[$i])) {
                    $parts[$i] = preg_replace('#^' . $ec . preg_quote($this->swap_pre) . '(\S+?)#', '\\1' . $this->dbprefix . '\\2', $parts[$i]);
                } else {
                    preg_match('#^' . $ec . preg_quote($this->dbprefix) . '#', $parts[$i]) or $parts[$i] = $this->dbprefix . $parts[$i];
                }
                $item = implode('.', $parts);
            }
            if ($protect_identifiers === true) {
                $item = $this->escape_identifiers($item);
            }
            return $item . $alias;
        }
        if ($this->dbprefix !== '') {
            if ($this->swap_pre !== '' && strpos($item, $this->swap_pre) === 0) {
                $item = preg_replace('/^' . $this->swap_pre . '(\S+?)/', $this->dbprefix . '\\1', $item);
            } elseif ($prefix_single === true && strpos($item, $this->dbprefix) !== 0) {
                $item = $this->dbprefix . $item;
            }
        }
        if ($protect_identifiers === true && !in_array($item, $this->_reserved_identifiers)) {
            $item = $this->escape_identifiers($item);
        }
        return $item . $alias;
    }

    protected function _reset_select() {
        
    }

}
