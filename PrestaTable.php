<?php
namespace SimpleTables;
use SimpleTables\Db\PrestaDb;
abstract class PrestaTable extends SimpleTable{
    function __construct(){
        parent::__construct(new PrestaDb());
    }
}
