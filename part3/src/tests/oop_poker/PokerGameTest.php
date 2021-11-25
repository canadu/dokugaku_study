<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib//oop_poker/PokerGame.php');

class PokerGameTest extends TestCase
{
    public function testStart()
    {
        $game = new PokerGame(['CA', 'DA'], ['C10', 'H10']);
        $this->assertSame(['pair', 'straight'], $game->start());
    }

}