<?php

// 【クイズ】スリーカードポーカーへの仕様変更

// スリーカードポーカーに仕様変更が入りました。ツーカードポーカーとスリーカードポーカー、両方のルールに対応できるようにする必要が発生しました。
// 各プレイヤーに配られたカードの枚数が2枚ずつのときはツーカードポーカーとして処理し、配られたカードの枚数が3枚ずつのときはスリーカードポーカーとして処理します。
// スリーカードポーカーのプログラム、もしくはツーカードポーカーのプログラムをコピーして新規ファイルを作成し、そのファイルをツーカードポーカーとスリーカードポーカーの両方に対応させてください。

// ◯お題

// プレイヤーは2人です
// 各プレイヤーはトランプ2枚もしくは3枚を与えられます
// ジョーカーはありません
// 与えられたカードから、役を判定します。役は番号が大きくなるほど強くなります
// -- トランプ2枚のとき --

// ハイカード：以下の役が一つも成立していない
// ペア：2枚のカードが同じ数字
// ストレート：2枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2 と K-A の2つです
// ・2つの手札について、強さは以下に従います
// 2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
// 2つの手札の役が同じ場合、各カードの数値によって強さを比較する
// 　 ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強)
// 　 ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、もう一枚のカード同士を比較する
// 　 ・ペア：ペアの数字を比較する
// 　 ・ストレート：一番強い数字を比較する (ただし、A-2 の組み合わせの場合、2 を一番強い数字とする。K-A が最強、A-2 が最弱)
// 　 ・数値が同じ場合：引き分け
// -- トランプ3枚のとき --

// ハイカード：以下の役が一つも成立していない
// ペア：2枚のカードが同じ数字
// ストレート：3枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2-3 と Q-K-A の2つ。ただし、K-A-2 のランクの組み合わせはストレートとはみなさない
// スリーカード：3枚のカードが同じ数字
// ・2つの手札について、強さは以下に従います
// 2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
// 2つの手札の役が同じ場合、各カードの数値によって強さを比較する
// 　 ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強)
// 　 ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、二番目に強いカード同士を比較する。左記が同じ数字の場合、三番目に強いランクを持つカード同士を比較する。左記が同じランクの場合は引き分け
// 　 ・ペア：ペアの数字を比較する。左記が同じランクの場合、ペアではない3枚目同士のランクを比較する。左記が同じランクの場合は引き分け
// 　 ・ストレート：一番強い数字を比較する (ただし、A-2-3 の組み合わせの場合、3 を一番強い数字とする。Q-K-A が最強、A-2-3 が最弱)。一番強いランクが同じ場合は引き分け
// 　 ・スリーカード：スリーカードの数字を比較する。スリーカードのランクが同じ場合は引き分け
// それぞれの役と勝敗を判定するプログラムを作成ください。

// ◯仕様

// それぞれの役と勝敗を判定するshowResultメソッドを定義してください。
// showResultメソッドは引数として、プレイヤー1のカードの配列、プレイヤー2のカードの配列を取ります。
// カードはH1〜H13（ハート）、S1〜S13（スペード）、D1〜D13（ダイヤ）、C1〜C13（クラブ）、となります。ただし、Jは11、Qは12、Kは13、Aは1とします。
// showResultメソッドは返り値として、プレイヤー1の役、プレイヤー2の役、勝利したプレイヤーの番号、を返します。引き分けの場合、プレイヤーの番号は0とします。

use function PHPUnit\Framework\isNull;

const CARDS = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
const HIGH_CARD = 'high card';
const PAIR = 'pair';
const STRAIGHT = 'straight';
const THREE = 'three card';
const HAND_RANK = [
    HIGH_CARD => 1,
    PAIR => 2,
    STRAIGHT => 3,
    THREE => 4,
];
define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARDS as $index => $card) {
        $cardRanks[$card] = $index;
    }
    return $cardRanks;
})());
/**
 * @param array<int> $user1
 * @param array<int> $user2
 * @return array<int, mixed>
 */
function showResult(array $user1, array $user2): array
{
    //スプリット番号を取得する
    $splitNo = count($user1);
    $mergeCards = array_merge($user1, $user2);
    //カードのランクを取得する
    $cardRanks = convertToCardRanks($mergeCards);
    //プレイヤー毎に配列を分割
    $playerCardRanks = array_chunk($cardRanks, $splitNo);
    //プレイヤー毎に役を取得する
    $hands = array_map(fn ($playerCardRanks) => checkHand($playerCardRanks), $playerCardRanks);
    $winner = decideWinner($hands[0], $hands[1]);
    return [$hands[0]['name'], $hands[1]['name'], $winner];
}
/**
 * @param array<string|int> $cards
 * @return array<int>
 */
function convertToCardRanks(array $cards): array
{
    return array_map(fn ($card) => CARD_RANK[substr($card, 1, strlen($card) - 1)], $cards);
}
/**
 * @param array<int> $playerCardRanks)
 * @return array<string, int|string>
 */
function checkHand(array $playerCardRanks): array
{
    //役を決定する
    rsort($playerCardRanks, SORT_NUMERIC);
    $idx = 0;
    $primary = -1;
    $secondary = -1;
    $third = -1;
    foreach ($playerCardRanks as $playerCardRank) {
        switch ($idx) {
            case 0:
                $primary = $playerCardRank;
                break;
            case 1:
                $secondary = $playerCardRank;
                break;
            case 2:
                $third = $playerCardRank;
                break;
        }
        $idx++;
    }
    $name = HIGH_CARD;
    // var_dump(isStraight($primary, $secondary, $third));
    if (isStraight($primary, $secondary, $third)) {
        //ストレートの場合
        $name = STRAIGHT;
        if ($third === -1) {
            //カードが２枚の時
            if (isMinMax($primary, $secondary)) {
                //A-2の組み合わせの場合は最大値と最小値を入れ替え
                $primary = min(CARD_RANK);
                $secondary = max(CARD_RANK);
            }
        } else {
            //カードが３枚の時
            if (isStraightChangeMinMaxCase($primary, $secondary, $third)) {
                //A-2-3の組み合わせの場合は３が一番強くなるので順番を入れ替え
                //入れ替えのため一時配列に格納する
                $arrayRankStorage = array($primary, $secondary, $third);
                $primary = $arrayRankStorage[1];
                $secondary = $arrayRankStorage[2];
                $third = $arrayRankStorage[0];
            }
        }
    } elseif (isThree($primary, $secondary, $third)) {
        //スリーカードの場合
        $name = THREE;
    } elseif (isPair($primary, $secondary, $third)) {
        //ペアーの場合
        $name = PAIR;
    }
    return [
        'name' => $name,
        'rank' => HAND_RANK[$name],
        'primary' => $primary,
        'secondary' => $secondary,
        'third' => $third,
    ];
}
/**
 * @param int $cardRank1
 * @param int $cardRank2
 * @param int $cardRank3
 * @return bool
 */
function isStraight(int $cardRank1, int $cardRank2, int $cardRank3 = -1): bool
{
    if ($cardRank3 === -1) {
        //カードが２枚のとき
        return abs($cardRank1 - $cardRank2) === 1 || isMinMax($cardRank1, $cardRank2);
    } else {
        //カードが3枚のとき
        if (isStraightExceptCase($cardRank1, $cardRank2, $cardRank3)) {
            //K-A-2の場合
            return false;
        } elseif (abs($cardRank1 - $cardRank2) === 1 && abs($cardRank2 - $cardRank3) === 1) {
            return true;
        } else {
            if (isStraightChangeMinMaxCase($cardRank1, $cardRank2, $cardRank3)) {
                //A-2-3の場合
                return true;
            }
            return false;
        }
    }
}
/**
 * @param int $cardRank1
 * @param int $cardRank2
 * @param int $cardRank3
 * @return bool
 */
function isStraightExceptCase(int $cardRank1, int $cardRank2, int $cardRank3): bool
{
    //K-A-2の組み合わせはストレートとは見なさない
    return abs($cardRank1 - $cardRank2) === 1 && abs($cardRank2 - $cardRank3) == 11;
}
/**
 * @param int $cardRank1
 * @param int $cardRank2
 * @param int $cardRank3
 * @return bool
 */
function isStraightChangeMinMaxCase(int $cardRank1, int $cardRank2, int $cardRank3): bool
{
    //A-2-3の場合
    return abs($cardRank1 - $cardRank2) === 11 && abs($cardRank2 - $cardRank3) === 1;
}
/**
 * @param int $cardRank1
 * @param int $cardRank2
 * @return bool
 */
function isMinMax(int $cardRank1, int $cardRank2): bool
{
    //var_dump(max(CARD_RANK)) . PHP_EOL;
    //var_dump(min(CARD_RANK)) . PHP_EOL;
    return abs(abs($cardRank1 - $cardRank2)) === (max(CARD_RANK) - min(CARD_RANK));
}
/**
 * @param int $cardRank1
 * @param int $cardRank2
 * @param int $cardRank3
 * @return bool
 */
function isPair(int $cardRank1, int $cardRank2, int $cardRank3 = -1): bool
{
    if ($cardRank3 === -1) {
        //カードが2枚のとき
        return $cardRank1 === $cardRank2;
    } else {
        //カードが3枚のとき
        if (($cardRank1 === $cardRank2) || ($cardRank1 === $cardRank3) || ($cardRank2 === $cardRank3)) {
            return true;
        } else {
            return false;
        }
    }
}
/**
 * @param int $cardRank1
 * @param int $cardRank2
 * @param int $cardRank3
 * @return bool
 */
function isThree(int $cardRank1, int $cardRank2, int $cardRank3 = -1): bool
{
    if ($cardRank3 === -1) {
        //カードが２枚の時
        return false;
    } else {
        //カードが3枚の時
        return ($cardRank1 === $cardRank2)  && ($cardRank2 === $cardRank3);
    }
}
/**
 * @param array<string, int|string> $hand1
 * @param array<string, int|string> $hand2
 * @return int
 */
function decideWinner(array $hand1, array $hand2): int
{
    //勝者を決定する
    foreach (['rank', 'primary', 'secondary', 'third'] as $k) {
        if ($hand1[$k] > $hand2[$k]) {
            return 1;
        }
        if ($hand1[$k] < $hand2[$k]) {
            return 2;
        }
    }
    return 0;
}
