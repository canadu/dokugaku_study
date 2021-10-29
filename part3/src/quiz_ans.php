<?php

// 【クイズ】テレビの視聴時間 答え合わせ

// ◯お題
// あなたはテレビが好きすぎて、プログラミングの学習が捗らないことに悩んでいました。
// テレビをやめれば学習時間が増えることは分かっているのですけど、テレビをすぐに辞めることができないでいます。
// そこで、一日のテレビの視聴分数を記録することから始めようと思い、プログラムを書くことにしました。
// テレビを見るたびにチャンネルごとの視聴分数をメモしておき、一日の終わりに記録します。テレビの合計視聴時間と、チャンネルごとの視聴分数と視聴回数を出力してください。

// ◯インプット
// 入力は以下の形式で与えられます。

// テレビのチャンネル 視聴分数 テレビのチャンネル 視聴分数 ...

// ただし、同じチャンネルを複数回見た時は、それぞれ分けて記録すること。

// チャンネル：数値を指定すること。1〜12の範囲とする（1ch〜12ch）
// 視聴分数：分数を指定すること。1〜1440の範囲とする

// ◯アウトプット
// テレビの合計視聴時間
// テレビのチャンネル 視聴分数 視聴回数
// テレビのチャンネル 視聴分数 視聴回数
// ...

// ただし、閲覧したチャンネルだけ出力するものとする。

// 視聴時間：時間数を出力すること。小数点一桁までで、端数は四捨五入すること

// ◯インプット例
// 1 30 5 25 2 30 1 15

// ◯アウトプット例
// 1.7
// 1 45 2
// 2 30 1
// 5 25 1

// ◯実行コマンド例
// php quiz.php 1 30 5 25 2 30 1 15

/*
タスク分解する
1、データ構造を決める
2、入力値を取得する
3、データを処理しやすい形に変換する
4、合計時間を算出する
5、チャンネルごとの視聴分数と視聴回数を算出する
6、表示する
*/
const SPLIT_LENGTH = 2;

function getInput()
{
    $argument = array_slice($_SERVER['argv'], 1);
    return array_chunk($argument, SPLIT_LENGTH);
}

function groupChannelViewingPeriods(array $inputs): array
{
    $chViewingPeriods = [];
    foreach ($inputs as $input) {
        $chan = $input[0];
        $min = $input[1];
        $mins = array($min);
        if (array_key_exists($chan, $chViewingPeriods)) {
            $mins = array_merge($chViewingPeriods[$chan], $mins);
        }
        $chViewingPeriods[$chan] = $mins;
    }
    return $chViewingPeriods;
}

function calculateTotalHour(array $chViewingPeriods): float
{
    $viewingTimes = [];
    foreach ($chViewingPeriods as $period) {
        $viewingTimes = array_merge($viewingTimes, $period);
    }
    //実はこれ一行でsumを求めることも出来る ...は配列を展開しているよ
    //array_sum(array_merge(...$chViewingPeriods));
    $totalMin = array_sum($viewingTimes);
    return round($totalMin / 60, 1);
}

function display(array $chViewingPeriods): void
{
    //4、合計時間を算出する
    $totalHour = calculateTotalHour($chViewingPeriods);
    echo $totalHour . PHP_EOL;
    foreach ($chViewingPeriods as $chan => $mins) {
        echo $chan . ' ' . array_sum($mins) . ' ' . count($mins) . PHP_EOL;
    }
}

//2、入力値を取得する
$inputs = getInput();
//3、データを処理しやすい形に変換する
$chViewingPeriods = groupChannelViewingPeriods($inputs);
// var_dump($chViewingPeriods);
display($$chViewingPeriods);
