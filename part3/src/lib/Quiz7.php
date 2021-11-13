<?php
// 「ツーカードポーカー」に「カードの枚数を3枚に変更して」と仕様変更が発生しました。

// ・ツーカードポーカーのファイルをコピーして新規ファイルを作成しましょう
// ・カード枚数を3枚に変更しましょう
// ・役の仕様は下記に変更します。役は番号が大きくなるほど強くなります

// 1、ハイカード：以下の役が一つも成立していない

// 2、ペア：2枚のカードが同じ数字

// 3、ストレート：3枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2-3 と Q-K-A の2つ。
//    ただし、K-A-2 のランクの組み合わせはストレートとはみなさない

// 4、スリーカード：3枚のカードが同じ数字・2つの手札について、強さは以下に従います
// 5、2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
// 6、2つの手札の役が同じ場合、各カードの数値によって強さを比較する
// 　 ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強)
// 　 ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、二番目に強いカード同士を比較する。左記が同じ数字の場合、三番目に強いランクを持つカード同士を比較する。左記が同じランクの場合は引き分け
// 　 ・ペア：ペアの数字を比較する。左記が同じランクの場合、ペアではない3枚目同士のランクを比較する。左記が同じランクの場合は引き分け
// 　 ・ストレート：一番強い数字を比較する (ただし、A-2-3 の組み合わせの場合、3 を一番強い数字とする。Q-K-A が最強、A-2-3 が最弱)。一番強いランクが同じ場合は引き分け
// 　 ・スリーカード：スリーカードの数字を比較する。スリーカードのランクが同じ場合は引き分け
// それぞれの役と勝敗を判定するプログラムを作成ください。

// ◯仕様

// それぞれの役と勝敗を判定するshowメソッドを定義してください。
// showメソッドは引数として、プレイヤー1のカード、プレイヤー1のカード、プレイヤー1のカード、プレイヤー2のカード、プレイヤー2のカード、プレイヤー2のカードを取ります。
// カードはH1〜H13（ハート）、S1〜S13（スペード）、D1〜D13（ダイヤ）、C1〜C13（クラブ）、となります。ただし、Jは11、Qは12、Kは13、Aは1とします。
// showメソッドは返り値として、プレイヤー1の役、プレイヤー2の役、勝利したプレイヤーの番号、を返します。引き分けの場合、プレイヤーの番号は0とします。

// ◯実行例

// show('CK', 'DJ', 'H9', 'C10', 'H10', 'D3')  //=> ['high card', 'pair', 2]
// show('CK', 'DA', 'H2', 'C3', 'H4', 'S5')     //=> ['high card', 'straight', 2]
// show('CK', 'DJ', 'H9', 'C3', 'H3', 'S3')     //=> ['high card', 'three card', 2]
// show('C3', 'H4', 'S5', 'DK', 'SK', 'D10')    //=> ['straight', 'pair', 1]
// show('C3', 'H3', 'S3', 'DK', 'SK', 'D10')    //=> ['three card', 'pair', 1]
// show('C3', 'H3', 'S3', 'DK', 'SJ', 'DQ')     //=> ['three card', 'straight', 1]
// show('HJ', 'SK', 'D9', 'DQ', 'D10', 'H8')    //=> ['high card', 'high card', 1]
// show('H9', 'SK', 'H7', 'DK', 'D10', 'H5')    //=> ['high card', 'high card', 2]
// show('H9', 'SK', 'H7', 'DK', 'D9', 'H5')     //=> ['high card', 'high card', 1]
// show('H3', 'S5', 'C7', 'D5', 'S7', 'D3')     //=> ['high card', 'high card', 0]
// show('CA', 'DA', 'DK', 'C2', 'D2', 'C3')     //=> ['pair', 'pair', 1]
// show('CK', 'DK', 'SA', 'CA', 'DA', 'SK')     //=> ['pair', 'pair', 2]
// show('C4', 'D4', 'S7', 'H4', 'S4', 'C6')     //=> ['pair', 'pair', 1]
// show('C4', 'D4', 'S7', 'H4', 'S4', 'C7')     //=> ['pair', 'pair', 0]
// show('SA', 'DK', 'DQ', 'CA', 'C2', 'D3')     //=> ['straight', 'straight', 1]
// show('SA', 'DK', 'DQ', 'CK', 'CQ', 'DJ')     //=> ['straight', 'straight', 1]
// show('S2', 'H3', 'D4', 'CA', 'C2', 'D3')     //=> ['straight', 'straight', 1]
// show('S2', 'S3', 'S4', 'C2', 'C3', 'D4')     //=> ['straight', 'straight', 0]
// show('S2', 'C2', 'D2', 'CA', 'HA', 'SA')     //=> ['three card', 'three card', 2]
// show('SK', 'CK', 'DK', 'CA', 'HA', 'SA')     //=> ['three card', 'three card', 2]
// show('S2', 'C2', 'D2', 'C3', 'H3', 'S3')     //=> ['three card', 'three card', 2]


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

function show(string $card11, string $card12, string $card13, string $card21, string $card22, string $card23): array
{s
    //カードのランクを取得する
    $cardRanks = convertToCardRanks([$card11, $card12, $card13, $card21, $card22, $card23]);
    //プレイヤー毎に配列を分割
    $playerCardRanks = array_chunk($cardRanks, 3);
    // print_r($playerCardRanks);
    //プレイヤー毎に役を取得する
    $hands = array_map(fn ($playerCardRanks) => checkHand($playerCardRanks[0], $playerCardRanks[1], $playerCardRanks[2]), $playerCardRanks);
    //勝者を決定する
    $winner = decideWinner($hands[0], $hands[1]);
    print_r([$hands[0]['name'], $hands[1]['name'], $winner]);
    return [$hands[0]['name'], $hands[1]['name'], $winner];
    // return ['high card', 'pair', 2];
}

function convertToCardRanks(array $cards): array
{
    return array_map(fn ($card) => CARD_RANK[substr($card, 1, strlen($card) - 1)], $cards);
}
function checkHand(int $cardRank1, int $cardRank2, int $cardRank3): array
{
    //役を決定する
    //$sortCardRank = arsort([$cardRank1, $cardRank2, $cardRank3], SORT_NUMERIC);
    $arrayCardRank = array($cardRank1, $cardRank2, $cardRank3);
    rsort($arrayCardRank, SORT_NUMERIC);
    // print_r($arrayCardRank);

    $primary = $arrayCardRank[0];
    // var_dump($primary) . PHP_EOL;
    $secondary = $arrayCardRank[1];
    // var_dump($secondary) . PHP_EOL;
    $third = $arrayCardRank[2];
    // var_dump($third) . PHP_EOL;
    $name = HIGH_CARD;

    if (isStraight($primary, $secondary, $third)) {
        //ストレートの場合
        $name = STRAIGHT;
        if (isStraightChangeMinMaxCase($primary, $secondary, $third)) {
            //A-2-3の組み合わせの場合は３が一番強くなるので順番を入れ替え
            $primary = $cardRank2;
            $secondary = $cardRank1;
            $third = $cardRank1;
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
function isStraight(int $cardRank1, int $cardRank2, int $cardRank3): bool
{
    //$sortCardRank = arsort([$cardRank1, $cardRank2, $cardRank3], SORT_NUMERIC);
    // 3、ストレート：3枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2-3 と Q-K-A の2つ。
    //    ただし、K-A-2 のランクの組み合わせはストレートとはみなさない

    if (isStraigthExceptCase($cardRank1, $cardRank2, $cardRank3)) {
        //K-A-2の場合
        return false;
    } elseif (abs($cardRank1 - $cardRank2) === 1 && abs($cardRank2 - $cardRank3 === 1)) {
        return true;
    } else {
        if (isStraightChangeMinMaxCase($cardRank1, $cardRank2, $cardRank3)) {
            //A-2-3の場合
            return true;
        }
        return false;
    }
}
function isStraigthExceptCase(int $cardRank1, int $cardRank2, int $cardRank3): bool
{
    //K-A-2の組み合わせはストレートとは見なさない
    return abs($cardRank1 - $cardRank2) === 1 && abs($cardRank2 - $cardRank3 == 11);
}
function isStraightChangeMinMaxCase(int $cardRank1, int $cardRank2, int $cardRank3): bool
{
    //A-2-3の場合
    return (abs($cardRank1 - $cardRank2) === 11 && abs($cardRank2 - $cardRank3 === 1));
}
function isMinMax(int $cardRank1, int $cardRank2): bool
{
    //var_dump(max(CARD_RANK)) . PHP_EOL;
    //var_dump(min(CARD_RANK)) . PHP_EOL;
    return abs(abs($cardRank1 - $cardRank2)) === (max(CARD_RANK) - min(CARD_RANK));
}
function isPair(int $cardRank1, int $cardRank2, int $cardRank3): bool
{
    if (($cardRank1 === $cardRank2) || ($cardRank1 === $cardRank3) || ($cardRank2 === $cardRank3)) {
        return true;
    } else return false;
}
function isThree(int $cardRank1, int $cardRank2, int $cardRank3): bool
{
    return ($cardRank1 === $cardRank2)  && ($cardRank2 === $cardRank3);
}
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
