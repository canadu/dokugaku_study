<?php

// ◯お題
// 自動販売機プログラムを単一責任の原則に基づいて設計しましょう。下記の仕様を追加します。
// 押したボタンに応じて、サイダーかコーラが出るようにしましょう。サイダーは100円、コーラは150円とします。
//100円以外のコインは入れられない仕様はそのままです
// 他の飲み物も追加しましょう
// テスト駆動で開発しましょう。
// 今回は設計にトライしてもらいたいので、テスト例は省略します。
require_once(__DIR__ . '/VendingMachine.php');
require_once(__DIR__ . '/CupDrink.php');

$machine  = new VendingMachine();
$machine->depositCoin(150);
$machine->addCup(1);
$hotCupCoffee = new CupDrink('hot cup coffee');
var_dump($machine->pressButton($hotCupCoffee));
