<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib//oop_poker/PokerCardTest.php');

class PokerCardTest extends TestCase
{
    public function testgetRank()
    {   
        $card = new PokerCard('C10');
        $this->assertSame(9, $card->getRank());
    }
}