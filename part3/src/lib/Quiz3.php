<?php
// 【クイズ】スーパーの支払金額

// ◯お題
// スーパーで買い物したときの支払金額を計算するプログラムを書きましょう。
// 以下の商品リストがあります。先頭の数字は商品番号です。金額は税抜です。

// 1 玉ねぎ 100円
// 2 人参 150円
// 3 りんご 200円
// 4 ぶどう 350円
// 5 牛乳 180円
// 6 卵 220円
// 7 唐揚げ弁当 440円
// 8 のり弁 380円
// 9 お茶 80円
// 10 コーヒー 100円

// また、以下の条件を満たすと割引されます。

// a. 玉ねぎは3つ買うと50円引き
// b. 玉ねぎは5つ買うと100円引き
// c. 弁当と飲み物を一緒に買うと20円引き（ただし適用は一組ずつ）
// d. お弁当は20〜23時はタイムセールで半額

// 合計金額（税込み）を求めてください。

// ◯仕様
// 金額を計算するcalc関数を定義してください。
// calcメソッドは「購入時刻 商品番号 商品番号 商品番号 ...」を引数に取り、合計金額（税込み）を返します。
// 購入時刻はHH:MM形式（例. 20:00）とし、商品番号は1〜10の整数とします。
// 同時に買える商品は20個までです。また、購入時刻は9〜23時です。

// ◯実行例
// calc('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10])  //=> 1298
define('ARTICLE', [1=>'100',2=>'150',3=>'200',4=>'350',5=>'180',6=>'220',7=>'440',8=>'380',9=>'80',10=>'100']);
$blnSale = false;
$onionCount = 0;
const ONION_NO = 1;// 玉ねぎ
const KA_BENTO_NO = 7;//唐揚げ弁当
const NO_BENTO_NO = 8;//のり弁当
const TEA_NO = 9;//お茶
const COFFEE_NO = 10;//コーヒー

//購入時刻がセール時間内かどうか確認する
function chekSaletime(string $argTime):bool {
    //タイムセール時間内かチェックする
    $dateFrom = strtotime('20:00');
    $dateTo = strtotime('23:00');
    $nowTime = strtotime($argTime);
    if ($dateFrom <= $nowTime && $nowTime <= $dateTo) {
        return (bool)true;
    } else {
        return (bool)false;
    }
}

//玉ねぎ分を減額するために計算を行う
function onionCalc(int $cnt):float {
    $disCount = 0;
    if (($cnt % 5) === 0) {  
      $disCount = floor($cnt / 5) * 100; 
    } elseif (($cnt % 3) === 0) {
      //50円の割引
      $disCount = floor($cnt / 3) * 50;
    }
    return $disCount;
}

function calc(string $argTime, array $argNos) :string {
    
    $total = 0;
    
    //セールか確認する
    if (chekSaletime($argTime)) {
        $blnSale = true;
    }

    foreach($argNos as $argNo) {
        switch ($argNo) {
            case ONION_NO:
                $onionCount += 1;
                //減額は後で行う
                $total += ARTICLE[$argNo];
                break;
            case KA_BENTO_NO:
            case NO_BENTO_NO:
                if ($blnSale) {
                    //セールの場合
                    $total += ARTICLE[$argNo] / 2;
                } else {    
                    //セールでない場合
                    $total += ARTICLE[$argNo];
                }
                break; 
            case TEA_NO:
            case COFFEE_NO:
                $total += ARTICLE[$argNo];
                break;
            default:
                $total += ARTICLE[$argNo];
        }
    }
    //玉ねぎ分の減額を行う
    $total -= onionCalc($onionCount);
    //消費税の計算を行う
    $total *= 1.1;
    return $total; 
}

//実行
echo calc('21:00', [1, 1, 1, 3, 5, 7, 8, 9, 10]) . PHP_EOL;