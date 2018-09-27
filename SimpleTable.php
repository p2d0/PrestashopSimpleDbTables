<?php
include_once __DIR__ . '/vendor/autoload.php';
namespace SimpleTables;
abstract class SimpleTable{

    function __construct($db)
    {
        $this->db = $db;
        $this->createTableIfNotExists();
        $this->builder = new Helpers\QueryBuilder();
    }

    abstract protected function getTableName();
    abstract protected function getTableColumns();

    function getColumnNames(){
        return array_keys($this->getTableColumns());
    }

    function getAll(){
        $result = $this->db->query(
            'SELECT * FROM ' . $this->getTableName()
        );
        if ($result)
            return $result;
        return [];
    }

    function save($item){
        $this->builder->insertOrUpdateInto($this->getTableName())
            ->values($item);
        $q = $this->builder->build();
        $this->db->execute($q);
    }

    function saveExistingColumns($assoc_array){
        $array_to_save = [];
        foreach($this->getTableColumns() as $key => $value){
            if(isset($assoc_array[$key]))
                $array_to_save[$key] = $assoc_array[$key];
        }
        $this->save($array_to_save);
    }

    function getBy($data,$order=NULL){
        $q = $this->builder->selectEverythingFrom($this->getTableName())
                ->where($data);
        if($order)
            $q->order($order);
        $q = $q->build();
        return $this->db->query($q);
    }


    function deleteBy($data){
        $q = $this->builder->deleteFrom($this->getTableName())
                ->where($data)->build();
        return $this->db->execute($q);
    }

    function dropTable(){
        $this->db->drop($this->getTableName());
    }

    private function createTableIfNotExists(){
        $q = 'CREATE TABLE IF NOT EXISTS ' . $this->getTableName() . '(';
        foreach ($this->getTableColumns() as $key => $value) {
            $q .= $key . ' ' . $value . ',';
        }
        $q = substr($q,0,-1);
        $q .= ') CHARACTER SET utf8 COLLATE utf8_unicode_ci';
        return $this->db->execute($q);
    }

    function updateTableWithColumns($columns){
        $modify_columns = $this->getDuplicateColumns($columns);
        $columns = $this->removeDuplicateColumns($columns);
        $q = 'ALTER TABLE ' . $this->getTableName() . ' ';
        foreach($columns as $key => $value){
            $query = $q . 'ADD '.$key.' '.$value;
            $this->db->execute($query);
        }
        foreach($modify_columns as $key => $value){
            $query = $q . ' MODIFY '.$key. ' '.$value;
            $this->db->execute($query);
        }
    }

    function removeDuplicateColumns($columns){
        $q = 'DESCRIBE '.$this->getTableName();
        $db_columns = $this->db->query($q);
        foreach($db_columns as $db_column){
            if(isset($columns[$db_column['Field']]))
                unset($columns[$db_column['Field']]);
        }
        return $columns;
    }

    function getDuplicateColumns($columns){
        $q = 'DESCRIBE '.$this->getTableName();
        $db_columns = $this->db->query($q);
        $new_columns = [];
        foreach($db_columns as $db_column){
            // TODO too much IFS conditionals
            if(isset($columns[$db_column['Field']]) && strpos($columns[$db_column['Field']],'PRIMARY') == false && strpos($columns[$db_column['Field']],'CHECK') == false)
               $new_columns[$db_column['Field']] = $columns[$db_column['Field']];
        }
        return $new_columns;
    }
}