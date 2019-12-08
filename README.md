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

# Updating columns #
You can update existing columns by calling 
``` php
$mytable->updateTableWithColumns([
                                "myfield3" => "BOOL" // add a new field
                                "myfield1" => "VARCHAR(1024) NOT NULL" // update existing field
                                ]); 
```

# Method list #

``` php
function updateTableWithColumns($columns);
function dropTable();
function deleteBy($data); // Similar to getBy
function getBy($data,$order=NULL);
function saveExistingColumns($assoc_array); // NOTE saves a new instance if primary key is not included or doesn't exists, otherwise updates entry
function save($item) // normal insert throws error if primary key exists 
function getAll();
function getColumnNames();
```

# Technicalities #
  * It Checks if table exists and creates a new one if it doesn't on each `new` call
  * It creates table with utf8 utf8_unicode_ci collation
