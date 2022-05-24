<?php
use PHPUnit\Framework\TestCase;
require_once(__DIR__."/../Bingo.php");

class BingoTest extends TestCase{
    private $bingo;

    public function setUp():void{
        $this->bingo = new Bingo();
    }

    public function testMethods(){
        $methods = get_class_methods($this->bingo);
        $this->assertEquals(4,count($methods));
        foreach ($methods as $key => $method) {
            $this->assertTrue(method_exists($this->bingo, $method));
        }
    }

    public function testNCards(){
        $quantity = 4;
        $cards = $this->bingo->generateCards($quantity);
        $this->assertEquals($quantity,count($cards));
        foreach ($cards as $i => $rows) {
            $this->assertEquals("array", gettype($rows));
            $this->assertEquals(6, count($rows));
            foreach ($rows as $ii => $columns) {
                $this->assertEquals(5, count($columns));
            }
        }
    }

    public function testObtainLetterAndNumber(){
        $call = $this->bingo->callNumber();
        $this->assertEquals("string",gettype($call->letter));
        $this->assertEquals("integer",gettype($call->letterPosition));
        $this->assertEquals("integer",gettype($call->number));
    }

    public function testBingo(){
        $cards = $this->bingo->generateCards(4);
        $isWinner = $this->bingo->bingo($cards[0]);
        $this->assertEquals("boolean",gettype($isWinner));
    }
}