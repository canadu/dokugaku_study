<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/PokerTwoCardRule.php');

class PokerTwoCardRuleTest extends TestCase
{
    public function testGetHand()
    {
        $rule = new PokerTwoCardRule();
        $this->assertSame('high card', $rule->getHand([new PokerCard('H5'), new PokerCard('C7')]));
        $this->assertSame('pair', $rule->getHand([new PokerCard('H10'), new PokerCard('C10')]));
        $this->assertSame('straight', $rule->getHand([new PokerCard('DA'), new PokerCard('S2')]));
        $this->assertSame('straight', $rule->getHand([new PokerCard('DA'), new PokerCard('SK')]));
    }
}
