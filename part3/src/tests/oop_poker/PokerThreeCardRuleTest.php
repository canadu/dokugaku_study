<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_poker/PokerThreeCardRule.php');

class PokerThreeCardRuleTest extends TestCase
{
    public function testGetHand()
    {
        $rule = new PokerThreeCardRule();
        $this->assertSame('high card', $rule->getHand([new PokerCard('H5'), new PokerCard('C7'), new PokerCard('C9')]));
        $this->assertSame('high card', $rule->getHand([new PokerCard('HK'), new PokerCard('CA'), new PokerCard('C2')]));
        $this->assertSame('pair', $rule->getHand([new PokerCard('H10'), new PokerCard('C10'), new PokerCard('CJ')]));
        $this->assertSame('straight', $rule->getHand([new PokerCard('DA'), new PokerCard('S2'), new PokerCard('C3')]));
        $this->assertSame('straight', $rule->getHand([new PokerCard('DA'), new PokerCard('SQ'), new PokerCard('SK')]));
        $this->assertSame('three of a kind', $rule->getHand([new PokerCard('DA'), new PokerCard('SA'), new PokerCard('DA')]));
    }
}
