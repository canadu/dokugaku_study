<?php

// 【クイズ】ツーカードポーカー

// ◯お題

// 2枚の手札でポーカーを行います。ルールは次の通りです。

// ・プレイヤーは2人です
// ・各プレイヤーはトランプ2枚を与えられます
// ・ジョーカーはありません
// ・与えられたカードから、役を判定します。役は番号が大きくなるほど強くなります

// 1、ハイカード：以下の役が一つも成立していない

// 2、ペア：2枚のカードが同じ数字
// 3、ストレート：2枚のカードが連続している。A は 2 と K の両方と連続しているとみなし、A を含むストレート は、A-2 と K-A の2つです

// ・2つの手札について、強さは以下に従います
// 4、2つの手札の役が異なる場合、より上位の役を持つ手札が強いものとする
// 5、2つの手札の役が同じ場合、各カードの数値によって強さを比較する
// 　 ・（弱）2, 3, 4, 5, 6, 7, 8, 9, 10, J, Q, K, A (強)
// 　 ・ハイカード：一番強い数字同士を比較する。左記が同じ数字の場合、もう一枚のカード同士を比較する
// 　 ・ペア：ペアの数字を比較する
// 　 ・ストレート：一番強い数字を比較する (ただし、A-2 の組み合わせの場合、2 を一番強い数字とする。K-A が最強、A-2 が最弱)
// 　 ・数値が同じ場合：引き分け
// 　
// それぞれの役と勝敗を判定するプログラムを作成ください。
// ◯仕様

// それぞれの役と勝敗を判定するshowDownメソッドを定義してください。
// showDownメソッドは引数として、プレイヤー1のカード、プレイヤー1のカード、プレイヤー2のカード、プレイヤー2のカードを取ります。
// カードはH1〜H13（ハート）、S1〜S13（スペード）、D1〜D13（ダイヤ）、C1〜C13（クラブ）、となります。ただし、Jは11、Qは12、Kは13、Aは1とします。
// showDownメソッドは返り値として、プレイヤー1の役、プレイヤー2の役、勝利したプレイヤーの番号、を返します。引き分けの場合、プレイヤーの番号は0とします。

// showDown('CK', 'DJ', 'C10', 'H10')  //=> ['high card', 'pair', 2]
// showDown('CK', 'DJ', 'C3', 'H4')    //=> ['high card', 'straight', 2]
// showDown('C3', 'H4', 'DK', 'SK')    //=> ['straight', 'pair', 1]
// showDown('HJ', 'SK', 'DQ', 'D10')   //=> ['high card', 'high card', 1]
// showDown('H9', 'SK', 'DK', 'D10')   //=> ['high card', 'high card', 2]
// showDown('H3', 'S5', 'D5', 'D3')    //=> ['high card', 'high card', 0]
// showDown('CA', 'DA', 'C2', 'D2')    //=> ['pair', 'pair', 1]
// showDown('CK', 'DK', 'CA', 'DA')    //=> ['pair', 'pair', 2]
// showDown('C4', 'D4', 'H4', 'S4')    //=> ['pair', 'pair', 0]
// showDown('SA', 'DK', 'C2', 'CA')    //=> ['straight', 'straight', 1]
// showDown('C2', 'CA', 'S2', 'D3')    //=> ['straight', 'straight', 2]
// showDown('S2', 'D3', 'C2', 'H3')    //=> ['straight', 'straight', 0]
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
//解説
//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
const CARDS = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
const HIGH_CARD = 'high card';
const PAIR = 'pair';
const STRAIGHT = 'straight';
const HAND_RANK = [
    HIGH_CARD => 1,
    PAIR => 2,
    STRAIGHT => 3,
];


define('CARD_RANK', (function () {
    $cardRanks = [];
    foreach (CARDS as $index => $card) {
        $cardRanks[$card] = $index;
    }
    return $cardRanks;
})());


function showDown(string $card11, string $card12, string $card21, string $card22): array
{
    $cardRanks = convertToCardRanks([$card11, $card12, $card21, $card22]);
    $playerCardRanks = array_chunk($cardRanks, 2);
    $hands = array_map(fn ($playerCardRanks) => checkHand($playerCardRanks[0], $playerCardRanks[1]), $playerCardRanks);
    $winner = decideWinner($hands[0], $hands[1]);
    return [$hands[0]['name'], $hands[1]['name'], $winner];
}
function convertToCardRanks(array $cards): array
{
    return array_map(fn ($card) => CARD_RANK[substr($card, 1, strlen($card) - 1)], $cards);
}
function checkHand(int $cardRank1, int $cardRank2): array
{
    $primary = max($cardRank1, $cardRank2);
    $secondary = min($cardRank1, $cardRank2);
    $name = HIGH_CARD;
    if (isStraight($cardRank1, $cardRank2)) {
        $name = STRAIGHT;
        if (isMinMax($cardRank1, $cardRank2)) {
            $primary = min(CARD_RANK);
            $secondary = max(CARD_RANK);
        }
    } elseif (isPair($cardRank1, $cardRank2)) {
        $name = PAIR;
    }
    return [
        'name' => $name,
        'rank' => HAND_RANK[$name],
        'primary' => $primary,
        'secondary' => $secondary,
    ];
}
function isStraight(int $cardRank1, int $cardRank2): bool
{
    return abs($cardRank1 - $cardRank2) === 1 || isMinMax($cardRank1, $cardRank2);
}
function isMinMax(int $cardRank1, int $cardRank2): bool
{
    return abs(abs($cardRank1 - $cardRank2)) === (max(CARD_RANK) - min(CARD_RANK));
}
function isPair(int $cardRank1, int $cardRank2): bool
{
    return $cardRank1 === $cardRank2;
}
function decideWinner(array $hand1, array $hand2): int
{
    foreach (['rank', 'primary', 'secondary'] as $k) {
        if ($hand1[$k] > $hand2[$k]) {
            return 1;
        }
        if ($hand1[$k] < $hand2[$k]) {
            return 2;
        }
    }
    return 0;
}

//＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
//エースは１番強いので基本14として扱うが、カードの組み合わせによっては弱くなる
// define('CARD', [
//     '2' => 2, '3' => 3, '4' => 4,
//     '5' => 5, '6' => 6, '7' => 7,
//     '8' => 8, '9' => 9, '10' => 10,
//     'J' => 11, 'Q' => 12, 'K' => 13,
//     'A' => 14
// ]);

// define('ROLE', [
//     'high card' => 0,
//     'pair' => 1,
//     'straight' => 2,
// ]);

// const START_LENGTH = 1;
// const DRAW = 0;
// const USER1 = 1;
// const USER2 = 2;

// /**
//  * @param array<int> $cardsNo
//  * @return bool
//  */
// function isPair(array $cardsNo): bool
// {
//     if ($cardsNo[0] === $cardsNo[1]) {
//         return true;
//     } else {
//         return false;
//     }
// }

// /**
//  * @param array<int> $cardsNo
//  * @return bool
//  */
// function isStraight(array $cardsNo): bool
// {
//     $rtnBool = false;
//     //A を含むストレート は、A-2 と K-A
//     if ($cardsNo[0] === CARD['A'] && ($cardsNo[1] === CARD['K'] || $cardsNo[1] === CARD['2'])) {
//         $rtnBool = true;
//     } elseif ($cardsNo[1] === CARD['A'] && ($cardsNo[0] === CARD['K'] || $cardsNo[0] === CARD['2'])) {
//         $rtnBool = true;
//     } else {
//         if ($cardsNo[0] === ($cardsNo[1] - 1) || $cardsNo[0] === ($cardsNo[1] + 1)) {
//             $rtnBool = true;
//         }
//     }
//     return $rtnBool;
// }

// /**
//  * @param string $card1
//  * @param string $card2
//  * @return array<int, int>
//  */
// function getNo(string $card1, string $card2): array
// {
//     //カード番号のみを取得する
//     $card1no = substr($card1, START_LENGTH, strlen($card1));
//     $card2no = substr($card2, START_LENGTH, strlen($card2));
//     return [CARD[$card1no], CARD[$card2no]];
// }

// /**
//  * @param array<int> $cardsNo
//  * @return int
//  */
// function getRole(array $cardsNo): int
// {
//     //取り敢えずハイガードを設定
//     $intRole = ROLE['high card'];
//     //ペアかどうか？
//     if (isPair($cardsNo)) {
//         $intRole = ROLE['pair'];
//     }
//     if (isStraight($cardsNo)) {
//         $intRole = ROLE['straight'];
//     }
//     return $intRole;
// }

// /**
//  * @param array<int> $cardsNo
//  * @return int
//  */
// function getMaxNo($cardsNo): int
// {
//     //A(14)と2の組み合わせの場合、max値は2とする
//     if ($cardsNo[0] === CARD['A'] && $cardsNo[1] === CARD['2']) {
//         return CARD['2'];
//     } elseif ($cardsNo[1] === CARD['A'] && $cardsNo[0] === CARD['2']) {
//         return CARD['2'];
//     } else {
//         return max($cardsNo);
//     }
// }

// /**
//  * @param array<string, array<int, int>|int> $user1
//  * @param array<string, array<int, int>|int> $user2
//  * @return int
//  */

// function getWinuser(array $user1, array $user2): int
// {
//     //勝敗を決める
//     if ($user1['role'] !== $user2['role']) {
//         //役が異なる場合
//         $winUser = $user1['role'] > $user2['role'] ? USER1 : USER2;
//     } else {
//         //役が同じとなる場合
//         print_r(array($user1['card']));

//         $user1Max = getMaxNo(($user1['card']));
//         $user2Max = getMaxNo(($user2['card']));
//         if ($user1Max === $user2Max) {
//             if (($user1['role'] === ROLE['high card'])) {
//                 $user1Min = min($user1['card']);
//                 $user2Min = min($user2['card']);
//                 if ($user1Min === $user2Min) {
//                     $winUser = DRAW;
//                 } else {
//                     $winUser = $user1Min > $user2Min ? USER1 : USER2;
//                 }
//             } else {
//                 //数字も同じ
//                 $winUser = DRAW;
//             }
//         } else {
//             $winUser = $user1Max > $user2Max ? USER1 : USER2;
//         }
//     }
//     return $winUser;
// }

// /**
//  * @param string $p1c1
//  * @param string $p1c2
//  * @param string $p2c1
//  * @param string $p2c2
//  * @return array <int, int|string>
//  */
// function showDown(string $p1c1, string $p1c2, string $p2c1, string $p2c2): array
// {
//     //数値を取得する
//     $p1CardsNo = getNo($p1c1, $p1c2);
//     $p2CardsNo = getNo($p2c1, $p2c2);
//     //それぞれの役を決定する
//     $p1Role = getRole($p1CardsNo);
//     $p2Role = getRole($p2CardsNo);
//     $user1 = array('card' => $p1CardsNo, 'role' => $p1Role);
//     $user2 = array('card' => $p2CardsNo, 'role' => $p2Role);
//     //勝敗を決めます
//     $winUser = getWinuser($user1, $user2);
//     $arReturn = array(array_keys(ROLE, $p1Role)[0], array_keys(ROLE, $p2Role)[0], $winUser);
//     return $arReturn;
// }
