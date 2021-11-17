<?php

use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../lib/poker/PokerQuiz2.php');
class PokerGameTest2 extends TestCase
{
    public function testStart()
    {
        $clsPoker = new PokerGame(['CA', 'DA'], ['C10', 'H10']);
        $this->assertSame([['CA', 'DA'], ['C10', 'H10']], $clsPoker->start());
    }
}
