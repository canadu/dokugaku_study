<?php

// 【クイズ】自動販売機にアクセス権を付けよう

// ◯お題
// 自動販売機のプログラムにプロパティと定数、メソッドにアクセス権を付けましょう。下記の仕様を追加します。
// 100円コインを入れてボタンを押すとサイダーが出るようにしましょう。サイダーが出ると入れた金額から100円が減ります。100円以外のコインは入れられません
// テスト駆動で開発しましょう。

// ◯テスト例
// 次のテストが通るようにコードを書きましょう。

use VendingMachine as GlobalVendingMachine;

class VendingMachine
{
    private const PRICE_OF_DRINK = 100;
    private int $depositCoin = 0;

    public function depositCoin(int $money): int
    {
        if ($money === 100) {
            $this->depositCoin += $money;
        }
        return $this->depositCoin;
    }

    function pressButton(): string
    {
        if ($this->depositCoin >= $this::PRICE_OF_DRINK) {
            $this->depositCoin -= $this::PRICE_OF_DRINK;
            return 'cider';
        } else {
            return '';
        }
    }
}
$vendingMachine = new VendingMachine();
$vendingMachine->depositCoin(100);
echo $vendingMachine->pressButton();
