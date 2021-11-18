<?php

// ◯お題
// 自動販売機プログラムを単一責任の原則に基づいて設計しましょう。下記の仕様を追加します。
// 押したボタンに応じて、サイダーかコーラが出るようにしましょう。サイダーは100円、コーラは150円とします。
//100円以外のコインは入れられない仕様はそのままです
// 他の飲み物も追加しましょう
// テスト駆動で開発しましょう。
// 今回は設計にトライしてもらいたいので、テスト例は省略します。

require_once('VendingBuyer.php');
$buyer =  new Buyer;
$machine =  new VendingMachine();
$machine->depositCoin([100]);
$machine->kindDrink = 'cider';
$drink = $buyer->pressButton($machine);
var_dump($drink);
?>