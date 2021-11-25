<?php

// ◯お題

// 自動販売機プログラムで以下の仕様変更がありました。
// １、カップコーヒー（カップに注ぐコーヒー）のアイスとホットも選択できるようにします。値段はどちらも100円です
// ２、カップの在庫管理も行ってください。カップコーヒーが一つ注文されるとカップも在庫から一つ減ります。自動販売機が保持できるカップ数は最大100個とします
// ３、カップを追加できるようにしてください

require_once(__DIR__ . '/Item.php');

class VendingMachine
{
    private int $depositedCoin = 0;
    private int $cupNumber = 0;

    private const MAX_CUP_NUMBER = 100;

    //入金する
    public function depositCoin(int $coinAmount): int
    {
        if ($coinAmount === 100) {
            $this->depositedCoin += $coinAmount;
        }
        return $this->depositedCoin;
    }

    public function pressButton(Item $item): string
    {
        //値段を取得する
        $price = $item->getPrice();
        $cupNumber = $item->getCupNumber();
        
        //入金額がジュースの値段以上の場合、入金額からジュース金額を引く
        if ($this->depositedCoin >= $price && $this->cupNumber >= $cupNumber) {
            $this->depositedCoin -= $price;
            $this->cupNumber -= $cupNumber;
            return $item->getName();
        } else {
            return '';
        }
    }

    public function addCup(int $num): int
    {
        $cupNumber = $this->cupNumber + $num;
        if ($cupNumber > self::MAX_CUP_NUMBER) {
            $cupNumber = self::MAX_CUP_NUMBER;
        }
        $this->cupNumber = $cupNumber;
        return $this->cupNumber;

    }

}