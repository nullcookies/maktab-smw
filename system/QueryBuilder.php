<?php

namespace system;

defined('BASEPATH') OR exit('No direct script access allowed');

class QueryBuilder {
    
    private $db;
    private $dbParams;
    private $lastQuery;
    private $q_params = [];
    private $q_select = [];
    private $q_from = [];
    private $q_table = false;
    private $q_join = [];
    private $q_group = [];
    public $q_where = [];
    private $q_where_in = [];
    private $q_order = [];
    private $q_limit = false;
    private $q_offset = false;

    public function __construct($dbParams = []) {
        $this->db = $dbParams;
        $this->db = DataBase::getInstance($dbParams);
    }

    public function params($params = []) {
        
        if(is_array($params) && $params != fals){
            $this->q_params = $params;
        }

        return $this;
    }

    public function select ($select = '*') {
        if (is_string($select)){
            $select = explode(',', $select);
        }

        foreach ($select as $value){
            $value = trim($value);

            if ($value !== ''){
                $this->q_select[] = $value;
            }
        }

        return $this;
    }

    public function from($from) {
        if (is_string($from)){
            $from = explode(',', $from);
        }
        foreach ($from as $value) {
            
            $value = trim($value);

            $this->q_from[] = $value;
        }

        return $this;
    }

    public function limit($limit) {
        
        $this->q_limit = (int)$limit;

        return $this;
    }

    public function offset($offset) {
        
        $this->q_offset = (int)$offset;

        return $this;
    }


    //where [key, value, combiner] or [[key, value, combiner], ...]
    public function where($param1, $param2 = false, $param3 = false) {
        
        if(is_string($param1)){
            $newParam1 = [$param1, $param2, $param3];
            $param1 = [$newParam1];
        }

        if(is_array($param1)){
            foreach ($param1 as $value) {
                foreach($value as $k => $v){
                    if(!is_array($v)){
                        $value[$k] = trim($v);
                    }
                }
                if($value[0] != false && $value[1] !== false && $value[1] !== null && $value[1] !== ''){
                    if(!isset($value[2])) {
                        $value[2] = 'AND';
                    }
                    if($value[2] != 'AND' && $value[2] != 'OR'){
                        $value[2] = 'AND';
                    }

                    $this->q_where[] = [$value[0], $value[1], $value[2]];
                }
            }
        }

        return $this;
    }

    public function whereIn($from) {
        

        return $this;
    }

    public function group($group) {
        
        $this->q_group[] = $group;

        return $this;
    }

    //order [key, value] or [[key, value], ...]
    public function order($param1, $param2 = false) {
        if(is_string($param1)){
            $newParam1 = [$param1, $param2];
            $param1 = [$newParam1];
        }
        if(is_array($param1)){
            foreach ($param1 as $value) {
                if(is_array($value)){
                    if(is_string($value[0]) && $value[0] != ''){
                        $v_param1 = trim($value[0]);
                        $v_param2 = (bool)$value[1];
                        if($v_param1 != false){
                            $this->q_order[] = $v_param1 . (($v_param2) ? ' DESC' : ' ASC');
                        }
                    }
                }
            }
        }

        return $this;
    }

    public function join($table, $condition, $type = 'LEFT') {
        if(is_string($table)){
            $table = trim($table);
            if($table){
                if(is_string($type)){
                    $type = trim($type);
                    if($type){
                        $type = strtoupper(trim($type));
                        if ( ! in_array($type, array('LEFT', 'RIGHT', 'OUTER', 'INNER', 'LEFT OUTER', 'RIGHT OUTER'), true)){
                            $type = '';
                        }
                    }
                }
                if(is_string($condition)){
                    $condition = trim($condition);
                    if($condition){
                        $condition = ' ON ' . $condition;
                        $this->q_join[] = ' ' . $type . ' JOIN ' . $table . ' ' . $condition . ' ';
                    }
                }
            }
        }

        return $this;
    }


    //returns PDOStatement class
    public function get($table = '', $params = []) {
        $sql = $this->getSelectSql($table);
        $this->lastQuery = $sql;
        
        if(!$params){
            $params = $this->q_params;
        }
        $this->reset();
        $sth = $this->db->prepare($sql);
        if(!$sth->execute($params)){
            if(ENVIRONMENT == 'dev'){
                var_dump($sth->errorInfo());
                var_dump($sql);
            }
        }
        
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        
        return $sth;
    }
    public function count($table = '', $params = []) {
        $sql = $this->getSelectSql($table);
        $this->lastQuery = $sql;
        
        if(!$params){
            $params = $this->q_params;
        }
        $this->reset();
        $sth = $this->db->prepare($sql);
        if(!$sth->execute($params)){
            if(ENVIRONMENT == 'dev'){
                var_dump($sth->errorInfo());
                var_dump($sql);
            }
        }
        return $sth->rowCount();
    }

    public function getStatement($table = '', $params = []) {
        $sql = $this->getSelectSql($table);
        $this->reset();
        return $sql;
    }

    //returns PDOStatement class or false
    public function insert($table = '', $row = [], $params = []) {
        $checkSql = true;
        if(!$table || !$row){
            $checkSql = false;
        }

        $sql_params = [];
        
        $sql = 'INSERT INTO ' . $table . ' ';
        $sql .= ' (';
        foreach ($row as $key => $value) {
            $sql .= $key . ',';
        }
        $sql = substr($sql, 0, -1);
        $sql .= ') ';

        $sql .= ' VALUES ';
        $sql .= ' (';
        foreach ($row as $key => $value) {
            $sql_params[] = $value;
            $sql .= '?,';
        }
        $sql = substr($sql, 0, -1);
        $sql .= ') ';
        $sql .= ';';

        if(!$params){
            $params = $this->q_params;
        }
        $params = array_merge($sql_params, $params);
        $this->lastQuery = $sql;
        $this->reset();
        
        if($checkSql){
            $sth = $this->db->prepare($sql);
            if(!$sth->execute($params)){
                if(ENVIRONMENT == 'dev'){
                    //file_put_contents('log.txt', $sth->errorInfo());
                    //file_put_contents('log1.txt', $sql);
                    var_dump($sth->errorInfo());
                    var_dump($sql);
                    var_dump($params);
                }
                return false;
            }

            return $sth;
        }
        else{
            return false;
        }
        
    }

    //returns PDOStatement class or false
    public function update($table = '', $row = [], $params = []) {
        $checkSql = true;
        if(!$table || !$row){
            $checkSql = false;
        }
        if(count($this->q_where) == 0){
            $checkSql = false;
        }


        $sql_params = [];
        $sql = 'UPDATE ' . $table . ' SET ';
        foreach ($row as $key => $value) {
            $sql .= ' ' . preg_replace('#[^a-z0-9_]#', '', $key) . ' = ?,';
            $sql_params[] = $value;
        }
        $sql = substr($sql, 0, -1);
        
        $sql .= $this->getWhere();
        $sql .= ';';

        if(!$params){
            $params = $this->q_params;
        }
        $params = array_merge($sql_params, $params);
        $this->lastQuery = $sql;
        $this->reset();

        if($checkSql){
            $sth = $this->db->prepare($sql);
            if(!$sth->execute($params)){
                if(ENVIRONMENT == 'dev'){
                    var_dump($sth->errorInfo());
                    var_dump($sql);
                }
                return false;
            }
            return $sth;
        }
        else{
            return false;
        }
        
    }

    //returns PDOStatement class or false
    public function insertUpdate($table = '', $row = [], $params = []) {
        $checkSql = true;
        if(!$table || !$row){
            $checkSql = false;
        }

        $sql_params = [];
        
        $sql = 'INSERT INTO ' . $table . ' ';
        $sql .= ' (';
        foreach ($row as $key => $value) {
            $sql .= $key . ',';
        }
        $sql = substr($sql, 0, -1);
        $sql .= ') ';

        $sql .= ' VALUES ';
        $sql .= ' (';
        foreach ($row as $key => $value) {
            $sql_params[] = $value;
            $sql .= '?,';
        }
        $sql = substr($sql, 0, -1);
        $sql .= ') ';
        $sql .= ' ON DUPLICATE KEY ';
        $sql .= ' UPDATE ';
        foreach ($row as $key => $value) {
            $sql_params[] = $value;
            $sql .= ' ' . $key .  '=?,';
        }
        $sql = substr($sql, 0, -1);
        
        $sql .= $this->getWhere();
        $sql .= ';';


        if(!$params){
            $params = $this->q_params;
        }
        $params = array_merge($sql_params, $params);
        $this->lastQuery = $sql;
        $this->reset();

        if($checkSql){
            $sth = $this->db->prepare($sql);
            if(!$sth->execute($params)){
                if(ENVIRONMENT == 'dev'){
                    var_dump($sth->errorInfo());
                    var_dump($sql);
                }
                return false;
            }

            return $sth;
        }
        else{
            return false;
        }
        
    }

    //returns PDOStatement class or false
    public function delete($table = '', $params = []) {
        $checkSql = true;
        if(!$table){
            $checkSql = false;
        }
        if(count($this->q_where) == 0){
            $checkSql = false;
        }


        $sql_params = [];
        $sql = 'DELETE FROM ' . $table . ' ';
        
        $sql .= $this->getWhere();
        $sql .= ';';

        if(!$params){
            $params = $this->q_params;
        }
        $this->lastQuery = $sql;
        $this->reset();

        if($checkSql){
            $sth = $this->db->prepare($sql);
            if(!$sth->execute($params)){
                if(ENVIRONMENT == 'dev'){
                    var_dump($sth->errorInfo());
                    var_dump($sql);
                }
                return false;
            }

            return $sth;
        }
        else{
            return false;
        }
        
    }

    public function lastInsertId($name = NULL){
        return $this->db->lastInsertId($name);
    }

    public function query($statement) {
        return $this->db->query($statement);
    }

    public function prepare($statement, $driver_options = []) {
        return $this->db->prepare($statement, $driver_options);
    }

    public function getSelectSql($table = '') {
        if($table){
            if (is_string($table)){
                $table = explode(',', $table);
            }

            foreach ($table as $value){
                $value = trim($value);
                if ($value !== ''){
                    $this->q_from[] = $value;
                }
            }
        }

        $sql = $this->getSelect();
        return $sql;
    }

    public function lastQuery(){
        return $this->lastQuery;
    }

    public function reset() {
        $this->q_params = [];
        $this->q_select = [];
        $this->q_from = [];
        $this->q_table = false;
        $this->q_join = [];
        $this->q_group = [];
        $this->q_where = [];
        $this->q_where_in = [];
        $this->q_order = [];
        $this->q_limit = false;
        $this->q_offset = false;
    }

    private function getWhere() {
        $sql = '';
        if(count($this->q_where) > 0){
            $sql_where_start = ' WHERE ';
            foreach($this->q_where as $key => $value){
                $whereIn = false;

                $checkValue = explode(' ', $value[0], 2);
                $whereKey = $value[0];
                $whereValue = $value[1];
                $whereSign = '=';
                if(isset($checkValue[1]) && $checkValue[1] != false){
                    if(in_array($checkValue[1], ['=', '!=', '>', '<', '>=', '<=', 'IN', 'NOT IN'])){
                        $whereKey = $checkValue[0];
                        $whereSign = $checkValue[1];
                        if(in_array($checkValue[1], ['IN', 'NOT IN']) && is_array($whereValue)){
                            if(!count($whereValue)){
                                $whereValue[] = '000_no_value_000';
                            }
                            $getWhereValue = '(';
                            foreach($whereValue as $whereValueValue){
                                $getWhereValue .= '\'' . htmlspecialchars($whereValueValue, ENT_QUOTES) . '\',';
                            }
                            $getWhereValue = substr($getWhereValue, 0, -1);
                            $getWhereValue .= ')';
                            $whereValue = $getWhereValue;
                            $whereIn = true;
                        }
                    }
                }
                if($whereValue == '?'){
                    $whereValue = '?';
                }
                else{
                    if($whereIn){
                        //$whereValue = str_replace('\'', '', $whereValue);
                    }
                    else{
                        $whereValue = '\'' . str_replace('\'', '', $whereValue) . '\'';
                    }
                    
                }

                if($key == 0){
                    $sql .= ' ' . $whereKey . ' ' . $whereSign . ' ' . $whereValue . ' ';
                }
                else{
                    $sql .= ' ' . $value[2] . ' ' . $whereKey . ' ' . $whereSign . ' ' . $whereValue . ' ';
                }
            }
            if($sql != ''){
                $sql = $sql_where_start . $sql;
            }
        }
        return $sql;
    }

    private function getSelect() {
        
        $sql = 'SELECT ';

        if (count($this->q_select) > 0){
            $sql .= ' ' . implode(', ', $this->q_select) . ' ';
        }
        else{
            $sql .= ' * ';
        }

        if (count($this->q_from) > 0) {
            $sql .= ' FROM ';
            $sql .= ' ' . implode(', ', $this->q_from) . ' ';
        }
        else{
            return false;
        }

        
        if (count($this->q_join) > 0){
            $sql .= ' ' . implode(' ', $this->q_join) . ' ';
        }        

        if (count($this->q_where) > 0){
            $sql .= $this->getWhere();
        }

        if (count($this->q_group) > 0){
            $sql .= ' GROUP BY ';
            $sql .= ' ' . implode(', ', $this->q_group) . ' ';
        }

        if (count($this->q_order) > 0){
            $sql .= ' ORDER BY ';
            $sql .= ' ' . implode(', ', $this->q_order) . ' ';
        }
        
        

        // LIMIT
        if ($this->q_limit){
            $sql .= ' LIMIT ' . (($this->q_offset !== false) ? ((int)$this->q_offset . ', ') : '') . (int)$this->q_limit;
        }

        return $sql;
    }

    
	
}

