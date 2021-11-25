<?php

require_once('Player.php');
require_once('Deck.php');

const HAND_RANK = [
    HIGH_CARD => 1,
    PAIR => 2,
    STRAIGHT => 3,
];


class Game
{
    public function __construct(private string $name, private int $drawNum)
    {
    }
    public function start()
    {
        $deck = new Deck();
        //プレイヤーを登録する
        $player = new Player($this->name);
        $cards = $player->drawCards($deck, $this->drawNum);
        return $cards;
    }
}
