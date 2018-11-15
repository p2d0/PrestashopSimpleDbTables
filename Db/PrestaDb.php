<?php
namespace SimpleTables\Db;
class PrestaDb extends AbstractDatabase{
    function getDb(){
        return \Db::getInstance();
    }
}
