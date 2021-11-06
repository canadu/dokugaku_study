<?php

// あなたは小さなパン屋を営んでいました。一日の終りに売上の集計作業を行います。
// 商品は10種類あり、それぞれ金額は以下の通りです（税抜）。

// 1、100
// 2、120
// 3、150
// 4、250
// 5、80
// 6、120
// 7、100
// 8、180
// 9、50
// 10、300

// 一日の売上の合計（税込み）と、販売個数の最も多い商品番号と販売個数の最も少ない商品番号を求めてください。

// ◯インプット
// 入力は以下の形式で与えられます。

// 販売した商品番号 販売個数 販売した商品番号 販売個数 ...

// ※ただし、販売した商品番号は1〜10の整数とする。

// ◯アウトプット

// 売上の合計
// 販売個数の最も多い商品番号
// 販売個数の最も少ない商品番号

// ※ただし、税率は10%とする。
// ※また、販売個数の最も多い商品と販売個数の最も少ない商品について、販売個数が同数の商品が存在する場合、それら全ての商品番号を記載すること。

// ◯インプット例

// 1 10 2 3 5 1 7 5 10 1

// ◯アウトプット例

// 2464
// 1
// 5 10

// ◯実行コマンド例
// php quiz.php 1 10 2 3 5 1 7 5 10 1

const SPLIT_LENGTH = 2;
const MODE_MAX = 0;
const MODE_MIN = 1;
define('MENUES', array('1' => 100, '2' => 120, '3' => 150, '4' => 250, '5' => 80, '6' => 120, '7' => 100, '8' => 180, '9' => 50, '10' => 300));

//入力値を返す
function getInput()
{
    $inputs = $_SERVER['argv'];
    return $inputs;
}

//商品番号毎に販売個数を取得する
function editData($inputs)
{
    $sumData = [];
    $forEachOrders = array_chunk(array_slice($inputs, 1), SPLIT_LENGTH);
    //商品毎の購入個数を足し算
    foreach ($forEachOrders as $order) {
        $menuNo = $order[0]; //購入メニュー番号
        $piece = $order[1]; //購入個数
        $sumData[$menuNo] += $piece;
    }
    return $sumData;
}

//メニュー番号を返す
function outputMenuNo(array $sumData, int $mode): string
{
    $outputNo = '';
    switch ($mode) {
        case MODE_MAX:
            //一番売れたメニュー番号を出力
            $menus = array_keys($sumData, max($sumData));
            break;
        case MODE_MIN:
            //一番売れなかったメニュー番号を出力
            $menus = array_keys($sumData, min($sumData));
            break;
    }

    foreach ($menus as $menu) {
        $outputNo = trim($outputNo . ' ' . $menu);
    }
    return $outputNo;
}

//販売金額を計算する
function outputCalcData($sumData)
{

    $total = 0;

    foreach ($sumData as $key => $value) {
        $total += MENUES[$key] * $value;
    }
    $total = ($total * 1.1);
    echo $total . PHP_EOL;

    $outputNo = outputMenuNo($sumData, MODE_MAX);
    echo $outputNo . PHP_EOL;

    $outputNo = outputMenuNo($sumData, MODE_MIN);
    echo $outputNo . PHP_EOL;
}

//入力値を受け取る
$inputs = getInput();

//商品データを分割する
$sumData = editData($inputs);

//計算して出力する
outputCalcData($sumData);
