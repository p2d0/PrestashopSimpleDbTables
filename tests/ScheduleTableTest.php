<?php
require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/mocks/mockDb.php";
use PHPUnit\Framework\TestCase;
use EasyModule\Gateways\ScheduleTable;

class ScheduleTableTest extends TestCase{
    function setUp()
    {
        $this->mockDb = new MockDb();
        $this->gateway = new ScheduleTable($this->mockDb);
    }
    function tearDown(){
        $this->gateway->dropTable();
    }

    function test_saving_date(){
        $this->gateway->save([
            'start' => "2018-01-01 00:00:01"
        ]);
        $result = $this->gateway->getBy(['id'=>1])[0]['start']; // TODO getBy not too claer maybe findBy or something
        $expected = "2018-01-01 00:00:01";
        $this->assertEquals($result,$expected);
    }
}
