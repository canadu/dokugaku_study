<?php

// require_once('Game.php');
// $game =  new Game('田中', 2);
// $game->start();

require_once('PokerGame.php');
$game = new PokerGame(['CA', 'DA'], ['C10', 'H10']);
$game->start();