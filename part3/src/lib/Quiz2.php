<?php

// 【クイズ】テレビの視聴時間

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

const SPLIT_LENGTH = 2;

//講義を受けてからのプログラミング
function getArgument(): array
{
    $argument =  $_SERVER['argv'];
    return $argument;
}

function groupChannelViewingPeriods(array $arguments): array
{
    $chanViewingPeriods = [];
    $arraySplit = array_chunk(array_slice($arguments, 1), SPLIT_LENGTH);
    foreach ($arraySplit as $split) {
        $chan = $split[0];
        $min = $split[1];
        //視聴時間を配列に格納する
        $mins = array($min);
        if (array_key_exists($chan, $chanViewingPeriods)) {
            //同じキーにマージする
            $mins = array_merge($chanViewingPeriods[$chan], $mins);
        }
        $chanViewingPeriods[$chan] = $mins;
    }
    return $chanViewingPeriods;
}

function calculateTotalHour(array $chanViewingPeriods): float
{
    $viewingTimes = [];
    foreach ($chanViewingPeriods as $period) {
        $viewingTimes = array_merge($viewingTimes, $period);
    }

    //実はこれ一行でsumを求めることも出来る ...は配列を展開しているよ
    //array_sum(array_merge(...$chanViewingPeriods));
    $totalMin = array_sum($viewingTimes);
    return round($totalMin / 60, 1);
}

function display(array $chanViewingPeriods): void
{
    $totalHour = calculateTotalHour($chanViewingPeriods);
    echo $totalHour . PHP_EOL;
    foreach ($chanViewingPeriods as $chan => $mins) {
        echo $chan . ' ' . array_sum($mins) . ' ' . count($mins) . PHP_EOL;
    }
}

function exeCute(array $arguments)
{
    //$arguments = getArgument();
    //入力値から扱いやすいように配列を分解する
    $chanViewingPeriods = groupChannelViewingPeriods($arguments);
    display($chanViewingPeriods);
}
exeCute($_SERVER['argv']);