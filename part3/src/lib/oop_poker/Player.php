<?php

require_once('Deck.php');

class Player
{

    public function __construct(private string $name)
    {
    }
    public function drawCards(Deck $deck, int $drawNum)
    {
        // TODO:仮実装
        return $deck->drawCards($drawNum);
    }
}
