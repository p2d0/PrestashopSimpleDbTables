<?php

namespace SimpleTables\Db;
abstract class  AbstractDatabase {
   function query($q){
       $result = $this->getDb()->query($q);
       if($result && $result->rowCount() > 0){
           return $result->fetchAll(PDO::FETCH_ASSOC);
       };
        return [];
   }
   function drop($table_name){
       $this->getDb()->query('
        DROP TABLE IF EXISTS '.$table_name);
   }
    function execute($q){
        $this->getDb()->query($q);
    }
   function insert($q){
       $this->execute($q);
   }
   function update($q){
       $this->execute($q); 
   }
   function delete($q){
       $this->execute($q);
   }
   function createTable($q){
       return $this->getDb()->query($q);
   }
   abstract function query($q);
}