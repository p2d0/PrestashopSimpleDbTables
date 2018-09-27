<?php

class MockDb{
    const servername = "localhost"; // TODO move mock db to a real mock not a db
    const username = "root";
    const password = "";
    const dbname = "testDb";
   function __construct()
   {
       try{
        $conn = new PDO("mysql:host=".$this::servername.
        ";dbname=".$this::dbname,
        $this::username,
        $this::password
       );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $conn;
       }
       catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
       }
   } 

   function execute($q){
       $this->db->query($q);
   }

   function query($q){
       $result = $this->db->query($q);
       if($result && $result->rowCount() > 0){
           return $result->fetchAll(PDO::FETCH_ASSOC);
       };
        return [];
   }
   function drop($table_name){
       $this->db->query('
        DROP TABLE IF EXISTS '.$table_name);
   }
}