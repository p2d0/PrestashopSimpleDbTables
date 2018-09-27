<?php
namespace EasyModule\Gateways\Helpers;
class QueryBuilder{
    function __construct(){
        $this->query = '';
    }
    function insertOrUpdateInto($table_name){
        $this->query .= 'INSERT INTO ' . $table_name;
        return $this;
    }

    function assocToString($assoc){
        $string = '';
        foreach($assoc as $key => $item){
            $string .= $this->sanitize($key) . '="' . $this->sanitize($item) . '",'; 
        };
        return rtrim($string,',');
    }
    function sanitize($string){
        $tmp = htmlentities($string);
        return $tmp;
    }
    function sanitize_array($items){
        $new_array = [];
        foreach ($items as $key) {
        $tmp = htmlentities($key,ENT_COMPAT,'utf-8');
        array_push($new_array,$tmp);
        }
        return $new_array;
    }

    function values($assoc_array){
        $this->query .= '(' . implode(',',array_keys($assoc_array)) . ') ';
        $this->query .= 'VALUES ("' . implode('","',$this->sanitize_array(array_values($assoc_array))) . '") ';
        $this->query .= 'ON DUPLICATE KEY UPDATE ' . $this->assocToString($assoc_array);
        return $this;
    }

    function order($order){
        $q = 'ORDER BY ';
        foreach ($order as $key => $value) {
            $q .= $key . ',';
        }
        $q = substr($q,0,-1);
        $q .= ' ' . reset($order); 
        $this->query .= $q;
        return $this;
    }

    function selectEverythingFrom($table_name){
        $this->query .= 'SELECT * FROM ' . $table_name;
        return $this;
    }

    function deleteFrom($table_name){
        $this->query = 'DELETE FROM ' . $table_name;
        return $this;
    }

    function where($data){
        $this->query .= ' WHERE ';
        foreach ($data as $key => $value) {
            $e = $key . ' = "'.$value.'" AND ';
            $this->query .= $e;
        };
        $this->query = substr($this->query,0,-4);
        return $this;
    }

    function build(){
        $q = $this->query;
        $this->query = '';
        return $q;
    }
}