<?php

require_once 'config.php';

echo $_SERVER['REQUEST_URI'] . "<br>";
echo 'ファイルパス: >' . __FILE__ . "<br>";

if ($_SERVER['REQUEST_URI'] === '/poll/login') {
    require_once 'views/login.php';
} elseif ($_SERVER['REQUEST_URI'] === '/poll/register') {
    require_once 'views/register.php';
} elseif($_SERVER['REQUEST_URI'] === '/poll/') {
    require_once 'views/home.php';
}
