Prestashop Db tables
====================

# Installation #
`composer require cerki/simple_prestashop_persistence`

# Example usage #

``` php
<?php
use SimpleTables\Db\PrestaTable;
class MyExampleTable extends PrestaTable{
  function getTableName(){
    return "mytablename";
  }

  function getTableColumns(){
    return [
    "id" => "INTEGER NOT NULL PRIMARY_KEY",
    "myfield1" => "VARCHAR(255)",
    "myfield2" => "INTEGER NOT NULL"
    ];
  }
}
function my_function(){
 $mytable = new MyExampleTable(); // NOTE you should have prestashop Db class loaded
                                  // so either do it in module/controller or import config.inc.php
 $mytable->saveExistingColumns([
                              "myfield1" => "somedata1"
                              "myfield2" => 2
                              ]);
 $mytable->getBy(["myfield1" => "somedata1"]
 // ["myfield2" => "ASC"] second argument - sorting
 ); // should return [["id" => 1,"myfield1" => "somedata1","myfield2"=>"somedata2"]]
}
```
