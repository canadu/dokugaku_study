<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib//oop_poker/Deck.php');
class DeckTest extends TestCase
{
    function testdrawCards()
    {
        $deck =  new Deck;
        $cards = $deck->drawCards(2);
        $this->assertSame(2, count($cards));
    }
}
