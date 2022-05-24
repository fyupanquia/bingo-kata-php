<?php

class Bingo {
    function __construct() {
        $this->ROWS = 5;
        $this->COLUMNS = 5;
        $this->letters = ["B", "I", "N", "G", "O"];
        $this->BOUNDS = $this->generateBounds();
        $this->calls = array();
   }

    protected function generateBounds(){
        $steps = 15;
        $MIN = 1;
        $MAX = 15;
        $BOUNDS = array();
        for ($i=0; $i < 5; $i++) { 
            $object = new stdClass();
            
            $object->MIN = $MIN;
            $object->MAX = $MAX;
            $BOUNDS[] = $object;
            $MAX += $steps;
            $MIN += $steps;
        }
        return $BOUNDS;
    }

   protected  function getNumberBetween($min, $max){
        return rand($min,$max);
    }
   protected  function findCall($letterPosition, $number){
        foreach ($this->calls as $key => $call) {
            if($call->letterPosition==$letterPosition && $call->number==$number){
                return $call;
            }
        }
    }

    function generateCards($quantity){
        $cards = array();
        for ($i=0; $i < $quantity; $i++) { 
            $card = array();
            $card[] = $this->letters;
            for ($row=1; $row <= $this->ROWS; $row++) { 
                $dataRow = array();
                for ($column=0; $column < $this->COLUMNS; $column++) { 
                    if(!($column==3 && $row==3)){
                        $dataRow[] = $this->getNumberBetween($this->BOUNDS[$column]->MIN, $this->BOUNDS[$column]->MAX);
                    } else {
                        $dataRow[] = "X";
                    }
                }
                $card[] = $dataRow;
            }
            $cards[] = $card;
        }
        return $cards;
    }

    function callNumber(){
        if(count($this->calls) >= $this->BOUNDS[count($this->BOUNDS) -1]->MAX) {
            return;
        }
        $letterPosition = $this->getNumberBetween(0, count($this->letters) -1);
        $number = $this->getNumberBetween($this->BOUNDS[$letterPosition]->MIN, $this->BOUNDS[$letterPosition]->MAX);
        $call = new stdClass;
        $call->letter = $this->letters[$letterPosition];
        $call->letterPosition = $letterPosition;
        $call->number = $number;

        if($this->findCall($letterPosition, $number)) {
            return $this->callNumber();
        }
        
        $this->calls[] = $call;
        return $call;
    }
    function bingo($card){
        if (count($this->calls) < ($this->ROWS * $this->COLUMNS - 1)){ 
            return False; 
        }
        
        for ($row=0; $row < count($card); $row++) { 
            for ($column=0; $column < count($card[$row]); $column++) { 
                if(!$this->findCall($column, $card[$row][$column])){
                    return False;
                }
            }
        }

        return True;
    }
}

$b = new Bingo();
//$call = $b->callNumber();
//print_r(gettype($call->letterPosition));

$cards = $b->generateCards(3);
$card = $cards[0];
print_r($card);
//print_r(gettype($b->bingo($card)));

//print_r(get_class_methods($b));