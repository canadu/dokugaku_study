<?php

require_once 'config.php';

echo $_SERVER['REQUEST_URI'];
if ($_SERVER['REQUEST_URI'] === '/poll/login') {
    require_once 'views/login.php';
} elseif ($_SERVER['REQUEST_URI'] === '/poll/register') {
    require_once 'views/register.php';
} else {
    //header('Location: index.php');
}
