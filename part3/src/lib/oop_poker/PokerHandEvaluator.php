<?php

require_once('PokerCard.php');
require_once('PokerRule.php');

class PokerHandEvaluator
{
    public function __construct(private PokerRule $rule)
    {
    }

    public function getHand(array $pokerCards)
    {
        return $this->rule->getHand($pokerCards);
    }
}
