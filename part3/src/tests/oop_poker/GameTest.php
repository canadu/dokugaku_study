<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib//oop_poker/Game.php');
class GameTest extends TestCase
{
    function testStart()
    {
        $game =  new Game('田中', 2);
        $result = $game->start();
        $this->assertSame(2, count($result));
    }
}
