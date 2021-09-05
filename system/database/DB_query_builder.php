<?php

defined('BASEPATH') or exit('No direct script access allowed');

abstract class CI_DB_query_builder extends CI_DB_driver {

    protected $return_delete_sql = false;
    protected $reset_delete_data = false;
    protected $qb_select = array();
    protected $qb_distinct = false;
    protected $qb_from = array();
    protected $qb_join = array();
    protected $qb_where = array();
    protected $qb_groupby = array();
    protected $qb_having = array();
    protected $qb_keys = array();
    protected $qb_limit = false;
    protected $qb_offset = false;
    protected $qb_orderby = array();
    protected $qb_set = array();
    protected $qb_set_ub = array();
    protected $qb_aliased_tables = array();
    protected $qb_where_group_started = false;
    protected $qb_where_group_count = 0;
    protected $qb_caching = false;
    protected $qb_cache_exists = array();
    protected $qb_cache_select = array();
    protected $qb_cache_from = array();
    protected $qb_cache_join = array();
    protected $qb_cache_aliased_tables = array();
    protected $qb_cache_where = array();
    protected $qb_cache_groupby = array();
    protected $qb_cache_having = array();
    protected $qb_cache_orderby = array();
    protected $qb_cache_set = array();
    protected $qb_no_escape = array();
    protected $qb_cache_no_escape = array();

    public function select($select = '*', $escape = NULL) {
        if (is_string($select)) {
            $select = explode(',', $select);
        }
        is_bool($escape) or $escape = $this->_protect_identifiers;
        foreach ($select as $val) {
            $val = trim($val);
            if ($val !== '') {
                $this->qb_select[] = $val;
                $this->qb_no_escape[] = $escape;
                if ($this->qb_caching === true) {
                    $this->qb_cache_select[] = $val;
                    $this->qb_cache_exists[] = 'select';
                    $this->qb_cache_no_escape[] = $escape;
                }
            }
        }
        return $this;
    }

    public function select_max($select = '', $alias = '') {
        return $this->_max_min_avg_sum($select, $alias, 'MAX');
    }

    public function select_min($select = '', $alias = '') {
        return $this->_max_min_avg_sum($select, $alias, 'MIN');
    }

    public function select_avg($select = '', $alias = '') {
        return $this->_max_min_avg_sum($select, $alias, 'AVG');
    }

    public function select_sum($select = '', $alias = '') {
        return $this->_max_min_avg_sum($select, $alias, 'SUM');
    }

    protected function _max_min_avg_sum($select = '', $alias = '', $type = 'MAX') {
        if (!is_string($select) or $select === '') {
            $this->display_error('db_invalid_query');
        }
        $type = strtoupper($type);
        if (!in_array($type, array(
                    'MAX',
                    'MIN',
                    'AVG',
                    'SUM'
                ))) {
            show_error('Invalid function type: ' . $type);
        }
        if ($alias === '') {
            $alias = $this->_create_alias_from_table(trim($select));
        }
        $sql = $type . '(' . $this->protect_identifiers(trim($select)) . ') AS ' . $this->escape_identifiers(trim($alias));
        $this->qb_select[] = $sql;
        $this->qb_no_escape[] = NULL;
        if ($this->qb_caching === true) {
            $this->qb_cache_select[] = $sql;
            $this->qb_cache_exists[] = 'select';
        }
        return $this;
    }

    protected function _create_alias_from_table($item) {
        if (strpos($item, '.') !== false) {
            $item = explode('.', $item);
            return end($item);
        }
        return $item;
    }

    public function distinct($val = true) {
        $this->qb_distinct = is_bool($val) ? $val : true;
        return $this;
    }

    public function from($from) {
        foreach ((array) $from as $val) {
            if (strpos($val, ',') !== false) {
                foreach (explode(',', $val) as $v) {
                    $v = trim($v);
                    $this->_track_aliases($v);
                    $this->qb_from[] = $v = $this->protect_identifiers($v, true, NULL, false);
                    if ($this->qb_caching === true) {
                        $this->qb_cache_from[] = $v;
                        $this->qb_cache_exists[] = 'from';
                    }
                }
            } else {
                $val = trim($val);
                $this->_track_aliases($val);
                $this->qb_from[] = $val = $this->protect_identifiers($val, true, NULL, false);
                if ($this->qb_caching === true) {
                    $this->qb_cache_from[] = $val;
                    $this->qb_cache_exists[] = 'from';
                }
            }
        }
        return $this;
    }

    public function join($table, $cond, $type = '', $escape = NULL) {
        if ($type !== '') {
            $type = strtoupper(trim($type));
            if (!in_array($type, array(
                        'LEFT',
                        'RIGHT',
                        'OUTER',
                        'INNER',
                        'LEFT OUTER',
                        'RIGHT OUTER'
                            ), true)) {
                $type = '';
            } else {
                $type .= ' ';
            }
        }
        $this->_track_aliases($table);
        is_bool($escape) or $escape = $this->_protect_identifiers;
        if (!$this->_has_operator($cond)) {
            $cond = ' USING (' . ($escape ? $this->escape_identifiers($cond) : $cond) . ')';
        } elseif ($escape === false) {
            $cond = ' ON ' . $cond;
        } else {
            if (preg_match_all('/\sAND\s|\sOR\s/i', $cond, $joints, PREG_OFFSET_CAPTURE)) {
                $conditions = array();
                $joints = $joints[0];
                array_unshift($joints, array(
                    '',
                    0
                ));
                for ($i = count($joints) - 1, $pos = strlen($cond); $i >= 0; $i--) {
                    $joints[$i][1] += strlen($joints[$i][0]);
                    $conditions[$i] = substr($cond, $joints[$i][1], $pos - $joints[$i][1]);
                    $pos = $joints[$i][1] - strlen($joints[$i][0]);
                    $joints[$i] = $joints[$i][0];
                }
            } else {
                $conditions = array(
                    $cond
                );
                $joints = array(
                    ''
                );
            }
            $cond = ' ON ';
            for ($i = 0, $c = count($conditions); $i < $c; $i++) {
                $operator = $this->_get_operator($conditions[$i]);
                $cond .= $joints[$i];
                $cond .= preg_match("/(\(*)?([\[\]\w\.'-]+)" . preg_quote($operator) . "(.*)/i", $conditions[$i], $match) ? $match[1] . $this->protect_identifiers($match[2]) . $operator . $this->protect_identifiers($match[3]) : $conditions[$i];
            }
        }
        if ($escape === true) {
            $table = $this->protect_identifiers($table, true, NULL, false);
        }
        $this->qb_join[] = $join = $type . 'JOIN ' . $table . $cond;
        if ($this->qb_caching === true) {
            $this->qb_cache_join[] = $join;
            $this->qb_cache_exists[] = 'join';
        }
        return $this;
    }

    public function where($key, $value = NULL, $escape = NULL) {
        return $this->_wh('qb_where', $key, $value, 'AND ', $escape);
    }

    public function or_where($key, $value = NULL, $escape = NULL) {
        return $this->_wh('qb_where', $key, $value, 'OR ', $escape);
    }

    protected function _wh($qb_key, $key, $value = NULL, $type = 'AND ', $escape = NULL) {
        $qb_cache_key = ($qb_key === 'qb_having') ? 'qb_cache_having' : 'qb_cache_where';
        if (!is_array($key)) {
            $key = array(
                $key => $value
            );
        }
        is_bool($escape) or $escape = $this->_protect_identifiers;
        foreach ($key as $k => $v) {
            $prefix = (count($this->$qb_key) === 0 && count($this->$qb_cache_key) === 0) ? $this->_group_get_type('') : $this->_group_get_type($type);
            if ($v !== NULL) {
                if ($escape === true) {
                    $v = $this->escape($v);
                }
                if (!$this->_has_operator($k)) {
                    $k .= ' = ';
                }
            } elseif (!$this->_has_operator($k)) {
                $k .= ' IS NULL';
            } elseif (preg_match('/\s*(!?=|<>|\sIS(?:\s+NOT)?\s)\s*$/i', $k, $match, PREG_OFFSET_CAPTURE)) {
                $k = substr($k, 0, $match[0][1]) . ($match[1][0] === '=' ? ' IS NULL' : ' IS NOT NULL');
            }
            $
                    {
                    $qb_key
                    } = array(
                'condition' => $prefix . $k,
                'value' => $v,
                'escape' => $escape
            );
            $this->{$qb_key}[] = $
                    {
                    $qb_key
                    };
            if ($this->qb_caching === true) {
                $this->{$qb_cache_key}[] = $
                        {
                        $qb_key
                        };
                $this->qb_cache_exists[] = substr($qb_key, 3);
            }
        }
        return $this;
    }

    public function where_in($key = NULL, $values = NULL, $escape = NULL) {
        return $this->_where_in($key, $values, false, 'AND ', $escape);
    }

    public function or_where_in($key = NULL, $values = NULL, $escape = NULL) {
        return $this->_where_in($key, $values, false, 'OR ', $escape);
    }

    public function where_not_in($key = NULL, $values = NULL, $escape = NULL) {
        return $this->_where_in($key, $values, true, 'AND ', $escape);
    }

    public function or_where_not_in($key = NULL, $values = NULL, $escape = NULL) {
        return $this->_where_in($key, $values, true, 'OR ', $escape);
    }

    protected function _where_in($key = NULL, $values = NULL, $not = false, $type = 'AND ', $escape = NULL) {
        if ($key === NULL or $values === NULL) {
            return $this;
        }
        if (!is_array($values)) {
            $values = array(
                $values
            );
        }
        is_bool($escape) or $escape = $this->_protect_identifiers;
        $not = ($not) ? ' NOT' : '';
        if ($escape === true) {
            $where_in = array();
            foreach ($values as $value) {
                $where_in[] = $this->escape($value);
            }
        } else {
            $where_in = array_values($values);
        }
        $prefix = (count($this->qb_where) === 0 && count($this->qb_cache_where) === 0) ? $this->_group_get_type('') : $this->_group_get_type($type);
        $where_in = array(
            'condition' => $prefix . $key . $not . ' IN(' . implode(', ', $where_in) . ')',
            'value' => NULL,
            'escape' => $escape
        );
        $this->qb_where[] = $where_in;
        if ($this->qb_caching === true) {
            $this->qb_cache_where[] = $where_in;
            $this->qb_cache_exists[] = 'where';
        }
        return $this;
    }

    public function like($field, $match = '', $side = 'both', $escape = NULL) {
        return $this->_like($field, $match, 'AND ', $side, '', $escape);
    }

    public function not_like($field, $match = '', $side = 'both', $escape = NULL) {
        return $this->_like($field, $match, 'AND ', $side, 'NOT', $escape);
    }

    public function or_like($field, $match = '', $side = 'both', $escape = NULL) {
        return $this->_like($field, $match, 'OR ', $side, '', $escape);
    }

    public function or_not_like($field, $match = '', $side = 'both', $escape = NULL) {
        return $this->_like($field, $match, 'OR ', $side, 'NOT', $escape);
    }

    protected function _like($field, $match = '', $type = 'AND ', $side = 'both', $not = '', $escape = NULL) {
        if (!is_array($field)) {
            $field = array(
                $field => $match
            );
        }
        is_bool($escape) or $escape = $this->_protect_identifiers;
        $side = strtolower($side);
        foreach ($field as $k => $v) {
            $prefix = (count($this->qb_where) === 0 && count($this->qb_cache_where) === 0) ? $this->_group_get_type('') : $this->_group_get_type($type);
            if ($escape === true) {
                $v = $this->escape_like_str($v);
            }
            switch ($side) {
                case 'none':
                    $v = "'{$v}'";
                    break;
                case 'before':
                    $v = "'%{$v}'";
                    break;
                case 'after':
                    $v = "'{$v}%'";
                    break;
                case 'both':
                default:
                    $v = "'%{$v}%'";
                    break;
            }
            if ($escape === true && $this->_like_escape_str !== '') {
                $v .= sprintf($this->_like_escape_str, $this->_like_escape_chr);
            }
            $qb_where = array(
                'condition' => "{$prefix} {$k} {$not} LIKE {$v}",
                'value' => NULL,
                'escape' => $escape
            );
            $this->qb_where[] = $qb_where;
            if ($this->qb_caching === true) {
                $this->qb_cache_where[] = $qb_where;
                $this->qb_cache_exists[] = 'where';
            }
        }
        return $this;
    }

    public function group_start($not = '', $type = 'AND ') {
        $type = $this->_group_get_type($type);
        $this->qb_where_group_started = true;
        $prefix = (count($this->qb_where) === 0 && count($this->qb_cache_where) === 0) ? '' : $type;
        $where = array(
            'condition' => $prefix . $not . str_repeat(' ', ++$this->qb_where_group_count) . ' (',
            'value' => NULL,
            'escape' => false
        );
        $this->qb_where[] = $where;
        if ($this->qb_caching) {
            $this->qb_cache_where[] = $where;
        }
        return $this;
    }

    public function or_group_start() {
        return $this->group_start('', 'OR ');
    }

    public function not_group_start() {
        return $this->group_start('NOT ', 'AND ');
    }

    public function or_not_group_start() {
        return $this->group_start('NOT ', 'OR ');
    }

    public function group_end() {
        $this->qb_where_group_started = false;
        $where = array(
            'condition' => str_repeat(' ', $this->qb_where_group_count--) . ')',
            'value' => NULL,
            'escape' => false
        );
        $this->qb_where[] = $where;
        if ($this->qb_caching) {
            $this->qb_cache_where[] = $where;
        }
        return $this;
    }

    protected function _group_get_type($type) {
        if ($this->qb_where_group_started) {
            $type = '';
            $this->qb_where_group_started = false;
        }
        return $type;
    }

    public function group_by($by, $escape = NULL) {
        is_bool($escape) or $escape = $this->_protect_identifiers;
        if (is_string($by)) {
            $by = ($escape === true) ? explode(',', $by) : array(
                $by
            );
        }
        foreach ($by as $val) {
            $val = trim($val);
            if ($val !== '') {
                $val = array(
                    'field' => $val,
                    'escape' => $escape
                );
                $this->qb_groupby[] = $val;
                if ($this->qb_caching === true) {
                    $this->qb_cache_groupby[] = $val;
                    $this->qb_cache_exists[] = 'groupby';
                }
            }
        }
        return $this;
    }

    public function having($key, $value = NULL, $escape = NULL) {
        return $this->_wh('qb_having', $key, $value, 'AND ', $escape);
    }

    public function or_having($key, $value = NULL, $escape = NULL) {
        return $this->_wh('qb_having', $key, $value, 'OR ', $escape);
    }

    public function order_by($orderby, $direction = '', $escape = NULL) {
        $direction = strtoupper(trim($direction));
        if ($direction === 'RANDOM') {
            $direction = '';
            $orderby = ctype_digit((string) $orderby) ? sprintf($this->_random_keyword[1], $orderby) : $this->_random_keyword[0];
        } elseif (empty($orderby)) {
            return $this;
        } elseif ($direction !== '') {
            $direction = in_array($direction, array(
                        'ASC',
                        'DESC'
                            ), true) ? ' ' . $direction : '';
        }
        is_bool($escape) or $escape = $this->_protect_identifiers;
        if ($escape === false) {
            $qb_orderby[] = array(
                'field' => $orderby,
                'direction' => $direction,
                'escape' => false
            );
        } else {
            $qb_orderby = array();
            foreach (explode(',', $orderby) as $field) {
                $qb_orderby[] = ($direction === '' && preg_match('/\s+(ASC|DESC)$/i', rtrim($field), $match, PREG_OFFSET_CAPTURE)) ? array(
                    'field' => ltrim(substr($field, 0, $match[0][1])),
                    'direction' => ' ' . $match[1][0],
                    'escape' => true
                        ) : array(
                    'field' => trim($field),
                    'direction' => $direction,
                    'escape' => true
                );
            }
        }
        $this->qb_orderby = array_merge($this->qb_orderby, $qb_orderby);
        if ($this->qb_caching === true) {
            $this->qb_cache_orderby = array_merge($this->qb_cache_orderby, $qb_orderby);
            $this->qb_cache_exists[] = 'orderby';
        }
        return $this;
    }

    public function limit($value, $offset = 0) {
        is_null($value) or $this->qb_limit = (int) $value;
        empty($offset) or $this->qb_offset = (int) $offset;
        return $this;
    }

    public function offset($offset) {
        empty($offset) or $this->qb_offset = (int) $offset;
        return $this;
    }

    protected function _limit($sql) {
        return $sql . ' LIMIT ' . ($this->qb_offset ? $this->qb_offset . ', ' : '') . (int) $this->qb_limit;
    }

    public function set($key, $value = '', $escape = NULL) {
        $key = $this->_object_to_array($key);
        if (!is_array($key)) {
            $key = array(
                $key => $value
            );
        }
        is_bool($escape) or $escape = $this->_protect_identifiers;
        foreach ($key as $k => $v) {
            $this->qb_set[$this->protect_identifiers($k, false, $escape)] = ($escape) ? $this->escape($v) : $v;
        }
        return $this;
    }

    public function get_compiled_select($table = '', $reset = true) {
        if ($table !== '') {
            $this->_track_aliases($table);
            $this->from($table);
        }
        $select = $this->_compile_select();
        if ($reset === true) {
            $this->_reset_select();
        }
        return $select;
    }

    public function get($table = '', $limit = NULL, $offset = NULL) {
        if ($table !== '') {
            $this->_track_aliases($table);
            $this->from($table);
        }
        if (!empty($limit)) {
            $this->limit($limit, $offset);
        }
        $result = $this->query($this->_compile_select());
        $this->_reset_select();
        return $result;
    }

    public function count_all_results($table = '', $reset = true) {
        if ($table !== '') {
            $this->_track_aliases($table);
            $this->from($table);
        }
        $qb_orderby = $this->qb_orderby;
        $qb_cache_orderby = $this->qb_cache_orderby;
        $this->qb_orderby = $this->qb_cache_orderby = array();
        $result = ($this->qb_distinct === true or!empty($this->qb_groupby) or!empty($this->qb_cache_groupby) or $this->qb_limit or $this->qb_offset) ? $this->query($this->_count_string . $this->protect_identifiers('numrows') . "\nFROM (\n" . $this->_compile_select() . "\n) CI_count_all_results") : $this->query($this->_compile_select($this->_count_string . $this->protect_identifiers('numrows')));
        if ($reset === true) {
            $this->_reset_select();
        } else {
            $this->qb_orderby = $qb_orderby;
            $this->qb_cache_orderby = $qb_cache_orderby;
        }
        if ($result->num_rows() === 0) {
            return 0;
        }
        $row = $result->row();
        return (int) $row->numrows;
    }

    public function get_where($table = '', $where = NULL, $limit = NULL, $offset = NULL) {
        if ($table !== '') {
            $this->from($table);
        }
        if ($where !== NULL) {
            $this->where($where);
        }
        if (!empty($limit)) {
            $this->limit($limit, $offset);
        }
        $result = $this->query($this->_compile_select());
        $this->_reset_select();
        return $result;
    }

    public function insert_batch($table, $set = NULL, $escape = NULL, $batch_size = 100) {
        if ($set === NULL) {
            if (empty($this->qb_set)) {
                return ($this->db_debug) ? $this->display_error('db_must_use_set') : false;
            }
        } else {
            if (empty($set)) {
                return ($this->db_debug) ? $this->display_error('insert_batch() called with no data') : false;
            }
            $this->set_insert_batch($set, '', $escape);
        }
        if (strlen($table) === 0) {
            if (!isset($this->qb_from[0])) {
                return ($this->db_debug) ? $this->display_error('db_must_set_table') : false;
            }
            $table = $this->qb_from[0];
        }
        $affected_rows = 0;
        for ($i = 0, $total = count($this->qb_set); $i < $total; $i += $batch_size) {
            if ($this->query($this->_insert_batch($this->protect_identifiers($table, true, $escape, false), $this->qb_keys, array_slice($this->qb_set, $i, $batch_size)))) {
                $affected_rows += $this->affected_rows();
            }
        }
        $this->_reset_write();
        return $affected_rows;
    }

    protected function _insert_batch($table, $keys, $values) {
        return 'INSERT INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES ' . implode(', ', $values);
    }

    public function set_insert_batch($key, $value = '', $escape = NULL) {
        $key = $this->_object_to_array_batch($key);
        if (!is_array($key)) {
            $key = array(
                $key => $value
            );
        }
        is_bool($escape) or $escape = $this->_protect_identifiers;
        $keys = array_keys($this->_object_to_array(reset($key)));
        sort($keys);
        foreach ($key as $row) {
            $row = $this->_object_to_array($row);
            if (count(array_diff($keys, array_keys($row))) > 0 or count(array_diff(array_keys($row), $keys)) > 0) {
                $this->qb_set[] = array();
                return;
            }
            ksort($row);
            if ($escape !== false) {
                $clean = array();
                foreach ($row as $value) {
                    $clean[] = $this->escape($value);
                }
                $row = $clean;
            }
            $this->qb_set[] = '(' . implode(',', $row) . ')';
        }
        foreach ($keys as $k) {
            $this->qb_keys[] = $this->protect_identifiers($k, false, $escape);
        }
        return $this;
    }

    public function get_compiled_insert($table = '', $reset = true) {
        if ($this->_validate_insert($table) === false) {
            return false;
        }
        $sql = $this->_insert($this->protect_identifiers($this->qb_from[0], true, NULL, false), array_keys($this->qb_set), array_values($this->qb_set));
        if ($reset === true) {
            $this->_reset_write();
        }
        return $sql;
    }

    public function insert($table = '', $set = NULL, $escape = NULL) {
        if ($set !== NULL) {
            $this->set($set, '', $escape);
        }
        if ($this->_validate_insert($table) === false) {
            return false;
        }
        $sql = $this->_insert($this->protect_identifiers($this->qb_from[0], true, $escape, false), array_keys($this->qb_set), array_values($this->qb_set));
        $this->_reset_write();
        return $this->query($sql);
    }

    protected function _validate_insert($table = '') {
        if (count($this->qb_set) === 0) {
            return ($this->db_debug) ? $this->display_error('db_must_use_set') : false;
        }
        if ($table !== '') {
            $this->qb_from[0] = $table;
        } elseif (!isset($this->qb_from[0])) {
            return ($this->db_debug) ? $this->display_error('db_must_set_table') : false;
        }
        return true;
    }

    public function replace($table = '', $set = NULL) {
        if ($set !== NULL) {
            $this->set($set);
        }
        if (count($this->qb_set) === 0) {
            return ($this->db_debug) ? $this->display_error('db_must_use_set') : false;
        }
        if ($table === '') {
            if (!isset($this->qb_from[0])) {
                return ($this->db_debug) ? $this->display_error('db_must_set_table') : false;
            }
            $table = $this->qb_from[0];
        }
        $sql = $this->_replace($this->protect_identifiers($table, true, NULL, false), array_keys($this->qb_set), array_values($this->qb_set));
        $this->_reset_write();
        return $this->query($sql);
    }

    protected function _replace($table, $keys, $values) {
        return 'REPLACE INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES (' . implode(', ', $values) . ')';
    }

    protected function _from_tables() {
        return implode(', ', $this->qb_from);
    }

    public function get_compiled_update($table = '', $reset = true) {
        $this->_merge_cache();
        if ($this->_validate_update($table) === false) {
            return false;
        }
        $sql = $this->_update($this->qb_from[0], $this->qb_set);
        if ($reset === true) {
            $this->_reset_write();
        }
        return $sql;
    }

    public function update($table = '', $set = NULL, $where = NULL, $limit = NULL) {
        $this->_merge_cache();
        if ($set !== NULL) {
            $this->set($set);
        }
        if ($this->_validate_update($table) === false) {
            return false;
        }
        if ($where !== NULL) {
            $this->where($where);
        }
        if (!empty($limit)) {
            $this->limit($limit);
        }
        $sql = $this->_update($this->qb_from[0], $this->qb_set);
        $this->_reset_write();
        return $this->query($sql);
    }

    protected function _validate_update($table) {
        if (count($this->qb_set) === 0) {
            return ($this->db_debug) ? $this->display_error('db_must_use_set') : false;
        }
        if ($table !== '') {
            $this->qb_from = array(
                $this->protect_identifiers($table, true, NULL, false)
            );
        } elseif (!isset($this->qb_from[0])) {
            return ($this->db_debug) ? $this->display_error('db_must_set_table') : false;
        }
        return true;
    }

    public function update_batch($table, $set = NULL, $index = NULL, $batch_size = 100) {
        $this->_merge_cache();
        if ($index === NULL) {
            return ($this->db_debug) ? $this->display_error('db_must_use_index') : false;
        }
        if ($set === NULL) {
            if (empty($this->qb_set_ub)) {
                return ($this->db_debug) ? $this->display_error('db_must_use_set') : false;
            }
        } else {
            if (empty($set)) {
                return ($this->db_debug) ? $this->display_error('update_batch() called with no data') : false;
            }
            $this->set_update_batch($set, $index);
        }
        if (strlen($table) === 0) {
            if (!isset($this->qb_from[0])) {
                return ($this->db_debug) ? $this->display_error('db_must_set_table') : false;
            }
            $table = $this->qb_from[0];
        }
        $affected_rows = 0;
        for ($i = 0, $total = count($this->qb_set_ub); $i < $total; $i += $batch_size) {
            if ($this->query($this->_update_batch($this->protect_identifiers($table, true, NULL, false), array_slice($this->qb_set_ub, $i, $batch_size), $index))) {
                $affected_rows += $this->affected_rows();
            }
            $this->qb_where = array();
        }
        $this->_reset_write();
        return $affected_rows;
    }

    protected function _update_batch($table, $values, $index) {
        $ids = array();
        foreach ($values as $key => $val) {
            $ids[] = $val[$index]['value'];
            foreach (array_keys($val) as $field) {
                if ($field !== $index) {
                    $final[$val[$field]['field']][] = 'WHEN ' . $val[$index]['field'] . ' = ' . $val[$index]['value'] . ' THEN ' . $val[$field]['value'];
                }
            }
        }
        $cases = '';
        foreach ($final as $k => $v) {
            $cases .= $k . " = CASE \n" . implode("\n", $v) . "\n" . 'ELSE ' . $k . ' END, ';
        }
        $this->where($val[$index]['field'] . ' IN(' . implode(',', $ids) . ')', NULL, false);
        return 'UPDATE ' . $table . ' SET ' . substr($cases, 0, -2) . $this->_compile_wh('qb_where');
    }

    public function set_update_batch($key, $index = '', $escape = NULL) {
        $key = $this->_object_to_array_batch($key);
        if (!is_array($key)) {
            
        }
        is_bool($escape) or $escape = $this->_protect_identifiers;
        foreach ($key as $k => $v) {
            $index_set = false;
            $clean = array();
            foreach ($v as $k2 => $v2) {
                if ($k2 === $index) {
                    $index_set = true;
                }
                $clean[$k2] = array(
                    'field' => $this->protect_identifiers($k2, false, $escape),
                    'value' => ($escape === false ? $v2 : $this->escape($v2))
                );
            }
            if ($index_set === false) {
                return $this->display_error('db_batch_missing_index');
            }
            $this->qb_set_ub[] = $clean;
        }
        return $this;
    }

    public function empty_table($table = '') {
        if ($table === '') {
            if (!isset($this->qb_from[0])) {
                return ($this->db_debug) ? $this->display_error('db_must_set_table') : false;
            }
            $table = $this->qb_from[0];
        } else {
            $table = $this->protect_identifiers($table, true, NULL, false);
        }
        $sql = $this->_delete($table);
        $this->_reset_write();
        return $this->query($sql);
    }

    public function truncate($table = '') {
        if ($table === '') {
            if (!isset($this->qb_from[0])) {
                return ($this->db_debug) ? $this->display_error('db_must_set_table') : false;
            }
            $table = $this->qb_from[0];
        } else {
            $table = $this->protect_identifiers($table, true, NULL, false);
        }
        $sql = $this->_truncate($table);
        $this->_reset_write();
        return $this->query($sql);
    }

    protected function _truncate($table) {
        return 'TRUNCATE ' . $table;
    }

    public function get_compiled_delete($table = '', $reset = true) {
        $this->return_delete_sql = true;
        $sql = $this->delete($table, '', NULL, $reset);
        $this->return_delete_sql = false;
        return $sql;
    }

    public function delete($table = '', $where = '', $limit = NULL, $reset_data = true) {
        $this->_merge_cache();
        if ($table === '') {
            if (!isset($this->qb_from[0])) {
                return ($this->db_debug) ? $this->display_error('db_must_set_table') : false;
            }
            $table = $this->qb_from[0];
        } elseif (is_array($table)) {
            empty($where) && $reset_data = false;
            foreach ($table as $single_table) {
                $this->delete($single_table, $where, $limit, $reset_data);
            }
            return;
        } else {
            $table = $this->protect_identifiers($table, true, NULL, false);
        }
        if ($where !== '') {
            $this->where($where);
        }
        if (!empty($limit)) {
            $this->limit($limit);
        }
        if (count($this->qb_where) === 0) {
            return ($this->db_debug) ? $this->display_error('db_del_must_use_where') : false;
        }
        $sql = $this->_delete($table);
        if ($reset_data) {
            $this->_reset_write();
        }
        return ($this->return_delete_sql === true) ? $sql : $this->query($sql);
    }

    protected function _delete($table) {
        return 'DELETE FROM ' . $table . $this->_compile_wh('qb_where') . ($this->qb_limit !== false ? ' LIMIT ' . $this->qb_limit : '');
    }

    public function dbprefix($table = '') {
        if ($table === '') {
            $this->display_error('db_table_name_required');
        }
        return $this->dbprefix . $table;
    }

    public function set_dbprefix($prefix = '') {
        return $this->dbprefix = $prefix;
    }

    protected function _track_aliases($table) {
        if (is_array($table)) {
            foreach ($table as $t) {
                $this->_track_aliases($t);
            }
            return;
        }
        if (strpos($table, ',') !== false) {
            return $this->_track_aliases(explode(',', $table));
        }
        if (strpos($table, ' ') !== false) {
            $table = preg_replace('/\s+AS\s+/i', ' ', $table);
            $table = trim(strrchr($table, ' '));
            if (!in_array($table, $this->qb_aliased_tables, true)) {
                $this->qb_aliased_tables[] = $table;
                if ($this->qb_caching === true && !in_array($table, $this->qb_cache_aliased_tables, true)) {
                    $this->qb_cache_aliased_tables[] = $table;
                    $this->qb_cache_exists[] = 'aliased_tables';
                }
            }
        }
    }

    protected function _compile_select($select_override = false) {
        $this->_merge_cache();
        if ($select_override !== false) {
            $sql = $select_override;
        } else {
            $sql = (!$this->qb_distinct) ? 'SELECT ' : 'SELECT DISTINCT ';
            if (count($this->qb_select) === 0) {
                $sql .= '*';
            } else {
                foreach ($this->qb_select as $key => $val) {
                    $no_escape = isset($this->qb_no_escape[$key]) ? $this->qb_no_escape[$key] : NULL;
                    $this->qb_select[$key] = $this->protect_identifiers($val, false, $no_escape);
                }
                $sql .= implode(', ', $this->qb_select);
            }
        }
        if (count($this->qb_from) > 0) {
            $sql .= "\nFROM " . $this->_from_tables();
        }
        if (count($this->qb_join) > 0) {
            $sql .= "\n" . implode("\n", $this->qb_join);
        }
        $sql .= $this->_compile_wh('qb_where') . $this->_compile_group_by() . $this->_compile_wh('qb_having') . $this->_compile_order_by();
        if ($this->qb_limit !== false or $this->qb_offset) {
            return $this->_limit($sql . "\n");
        }
        return $sql;
    }

    protected function _compile_wh($qb_key) {
        if (count($this->$qb_key) > 0) {
            for ($i = 0, $c = count($this->$qb_key); $i < $c; $i++) {
                if (is_string($this->{$qb_key}[$i])) {
                    continue;
                } elseif ($this->{$qb_key}[$i]['escape'] === false) {
                    $this->{$qb_key}[$i] = $this->{$qb_key}[$i]['condition'] . (isset($this->{$qb_key}[$i]['value']) ? ' ' . $this->{$qb_key}[$i]['value'] : '');
                    continue;
                }
                $conditions = preg_split('/((?:^|\s+)AND\s+|(?:^|\s+)OR\s+)/i', $this->{$qb_key}[$i]['condition'], -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
                for ($ci = 0, $cc = count($conditions); $ci < $cc; $ci++) {
                    if (($op = $this->_get_operator($conditions[$ci])) === false or!preg_match('/^(\(?)(.*)(' . preg_quote($op, '/') . ')\s*(.*(?<!\)))?(\)?)$/i', $conditions[$ci], $matches)) {
                        continue;
                    }
                    if (!empty($matches[4])) {
                        $this->_is_literal($matches[4]) or $matches[4] = $this->protect_identifiers(trim($matches[4]));
                        $matches[4] = ' ' . $matches[4];
                    }
                    $conditions[$ci] = $matches[1] . $this->protect_identifiers(trim($matches[2])) . ' ' . trim($matches[3]) . $matches[4] . $matches[5];
                }
                $this->{$qb_key}[$i] = implode('', $conditions) . (isset($this->{$qb_key}[$i]['value']) ? ' ' . $this->{$qb_key}[$i]['value'] : '');
            }
            return ($qb_key === 'qb_having' ? "\nHAVING " : "\nWHERE ") . implode("\n", $this->$qb_key);
        }
        return '';
    }

    protected function _compile_group_by() {
        if (count($this->qb_groupby) > 0) {
            for ($i = 0, $c = count($this->qb_groupby); $i < $c; $i++) {
                if (is_string($this->qb_groupby[$i])) {
                    continue;
                }
                $this->qb_groupby[$i] = ($this->qb_groupby[$i]['escape'] === false or $this->_is_literal($this->qb_groupby[$i]['field'])) ? $this->qb_groupby[$i]['field'] : $this->protect_identifiers($this->qb_groupby[$i]['field']);
            }
            return "\nGROUP BY " . implode(', ', $this->qb_groupby);
        }
        return '';
    }

    protected function _compile_order_by() {
        if (empty($this->qb_orderby)) {
            return '';
        }
        for ($i = 0, $c = count($this->qb_orderby); $i < $c; $i++) {
            if (is_string($this->qb_orderby[$i])) {
                continue;
            }
            if ($this->qb_orderby[$i]['escape'] !== false && !$this->_is_literal($this->qb_orderby[$i]['field'])) {
                $this->qb_orderby[$i]['field'] = $this->protect_identifiers($this->qb_orderby[$i]['field']);
            }
            $this->qb_orderby[$i] = $this->qb_orderby[$i]['field'] . $this->qb_orderby[$i]['direction'];
        }
        return "\nORDER BY " . implode(', ', $this->qb_orderby);
    }

    protected function _object_to_array($object) {
        if (!is_object($object)) {
            return $object;
        }
        $array = array();
        foreach (get_object_vars($object) as $key => $val) {
            if (!is_object($val) && !is_array($val) && $key !== '_parent_name') {
                $array[$key] = $val;
            }
        }
        return $array;
    }

    protected function _object_to_array_batch($object) {
        if (!is_object($object)) {
            return $object;
        }
        $array = array();
        $out = get_object_vars($object);
        $fields = array_keys($out);
        foreach ($fields as $val) {
            if ($val !== '_parent_name') {
                $i = 0;
                foreach ($out[$val] as $data) {
                    $array[$i++][$val] = $data;
                }
            }
        }
        return $array;
    }

    public function start_cache() {
        $this->qb_caching = true;
        return $this;
    }

    public function stop_cache() {
        $this->qb_caching = false;
        return $this;
    }

    public function flush_cache() {
        $this->_reset_run(array(
            'qb_cache_select' => array(),
            'qb_cache_from' => array(),
            'qb_cache_join' => array(),
            'qb_cache_where' => array(),
            'qb_cache_groupby' => array(),
            'qb_cache_having' => array(),
            'qb_cache_orderby' => array(),
            'qb_cache_set' => array(),
            'qb_cache_exists' => array(),
            'qb_cache_no_escape' => array(),
            'qb_cache_aliased_tables' => array()
        ));
        return $this;
    }

    protected function _merge_cache() {
        if (count($this->qb_cache_exists) === 0) {
            return;
        } elseif (in_array('select', $this->qb_cache_exists, true)) {
            $qb_no_escape = $this->qb_cache_no_escape;
        }
        foreach (array_unique($this->qb_cache_exists) as $val) {
            $qb_variable = 'qb_' . $val;
            $qb_cache_var = 'qb_cache_' . $val;
            $qb_new = $this->$qb_cache_var;
            for ($i = 0, $c = count($this->$qb_variable); $i < $c; $i++) {
                if (!in_array($this->{$qb_variable}[$i], $qb_new, true)) {
                    $qb_new[] = $this->{$qb_variable}[$i];
                    if ($val === 'select') {
                        $qb_no_escape[] = $this->qb_no_escape[$i];
                    }
                }
            }
            $this->$qb_variable = $qb_new;
            if ($val === 'select') {
                $this->qb_no_escape = $qb_no_escape;
            }
        }
    }

    protected function _is_literal($str) {
        $str = trim($str);
        if (empty($str) or ctype_digit($str) or (string) (float) $str === $str or in_array(strtoupper($str), array(
                    'TRUE',
                    'FALSE'
                        ), true)) {
            return true;
        }
        static $_str;
        if (empty($_str)) {
            $_str = ($this->_escape_char !== '"') ? array(
                '"',
                "'"
                    ) : array(
                "'"
            );
        }
        return in_array($str[0], $_str, true);
    }

    public function reset_query() {
        $this->_reset_select();
        $this->_reset_write();
        return $this;
    }

    protected function _reset_run($qb_reset_items) {
        foreach ($qb_reset_items as $item => $default_value) {
            $this->$item = $default_value;
        }
    }

    protected function _reset_select() {
        $this->_reset_run(array(
            'qb_select' => array(),
            'qb_from' => array(),
            'qb_join' => array(),
            'qb_where' => array(),
            'qb_groupby' => array(),
            'qb_having' => array(),
            'qb_orderby' => array(),
            'qb_aliased_tables' => array(),
            'qb_no_escape' => array(),
            'qb_distinct' => false,
            'qb_limit' => false,
            'qb_offset' => false
        ));
    }

    protected function _reset_write() {
        $this->_reset_run(array(
            'qb_set' => array(),
            'qb_set_ub' => array(),
            'qb_from' => array(),
            'qb_join' => array(),
            'qb_where' => array(),
            'qb_orderby' => array(),
            'qb_keys' => array(),
            'qb_limit' => false
        ));
    }

}
