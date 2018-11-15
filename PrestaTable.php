<?php
namespace SimpleTables;
use SimpleTables\Db\PrestaDb;
class PrestaTable extends SimpleTable{
    function __construct(){
        parent::__construct(new PrestaDb());
    }
}
