<?php

class PokerGame
{
	function __construct(protected array $game)
	{
	}
    function start()
    {
        return $this->game;
    }
}
