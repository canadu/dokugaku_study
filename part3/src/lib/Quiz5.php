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
//エースは１番強いので14として扱う
define('CARD', [
    '2' => 2, '3' => 3, '4' => 4,
    '5' => 5, '6' => 6, '7' => 7,
    '8' => 8, '9' => 9, '10' => 10,
    'J' => 11, 'Q' => 12, 'K' => 13,
    'A' => 14
]);
define('ROLE',[
    'high card' => 0,
    'pair' => 1,
    'straight' => 2,
]);
const START_LENGTH = 1;
const DRAW = 0;
const USER1 = 1;
const USER2 = 2;

function isPair(array $cardsNo): bool 
{
    if ($cardsNo[0] === $cardsNo[1]) {
        return true;
    } else {
        return false;
    }
}

function isStraight(array $cardsNo): bool 
{
    $rtnBool = false;
    //A を含むストレート は、A-2 と K-A
    if ($cardsNo[0] === CARD['A'] && ($cardsNo[1] === CARD['K'] || $cardsNo[1] === CARD['2'])) {
        $rtnBool = true;
    } elseif ($cardsNo[1] === CARD['A'] && ($cardsNo[0] === CARD['K'] || $cardsNo[0] === CARD['2'])) {
        $rtnBool = true;
    } else {
        if ($cardsNo[0] === ($cardsNo[1] - 1) || $cardsNo[0] === ($cardsNo[1] + 1)) {
            $rtnBool = true;
        } 
    }
    return $rtnBool;
}

function getNo(string $card1, string $card2): array 
{
    //カード番号のみを取得する
    $card1no = substr($card1, START_LENGTH, strlen($card1));
    $card2no = substr($card2, START_LENGTH, strlen($card2));
    return [CARD[$card1no], CARD[$card2no]];
}

function getRole(array $cardsNo): int
{
    //取り敢えずハイガードを設定
    $intRole = ROLE['high card'];
    //ペアかどうか？
    if (isPair($cardsNo)) {
        $intRole = ROLE['pair'];
    }
    if (isStraight($cardsNo)) {
        $intRole = ROLE['straight'];
    }
    return $intRole;
}

function showDown(string $p1c1, string $p1c2, string $p2c1, string $p2c2): array
{   
    //数値を取得する
    $p1CardsNo = getNo($p1c1, $p1c2);
    $p2CardsNo = getNo($p2c1, $p2c2);
    
    //それぞれの役を決定する
    $p1Role = getRole($p1CardsNo);
    $p2Role = getRole($p2CardsNo);

    //勝敗を決める
    if($p1Role !== $p2Role) {
        //役が異なる場合
        if ($p1Role > $p2Role) {
            //user1の方が役が強い
            $winUser = USER1;
        } else {
            //user2の方が役が強い
            $winUser = USER2;
        }
    } else {
        //役が同じ場合

        //ハイガードの場合はどちらかのカードで勝敗を決める
        


        $p1max = max($p1CardsNo);
        $p2max = max($p2CardsNo);
        if ($p1max === $p2max) {
            //数字も同じ
            $winUser = DRAW;
        } else {
            if ($p1max > $p2max) {
                //user1の方が数字が強い
                $winUser = USER1;
            } else {
                //user2の方が数字が強い
                $winUser = USER2;
            }
        }
    }
    //戻り値を設定
    // $user1Key = array_keys(ROLE, $p1Role)[0];
    // $user2Key = array_keys(ROLE, $p2Role)[0];
    // print_r($user1Key) . PHP_EOL;
    // print_r($user2Key) . PHP_EOL;

    $arReturn = array(array_keys(ROLE, $p1Role)[0], array_keys(ROLE, $p2Role)[0], $winUser);
    print_r($arReturn);
    return $arReturn;
}

//showDown('CK', 'DJ', 'C10', 'H10');  //=> ['high card', 'pair', 2]
// showDown('CK', 'DJ', 'C3', 'H4') . PHP_EOL;   //=> ['high card', 'straight', 2]
// showDown('C3', 'H4', 'DK', 'SK') . PHP_EOL;    //=> ['straight', 'pair', 1]
// showDown('HJ', 'SK', 'DQ', 'D10') . PHP_EOL;   //=> ['high card', 'high card', 1]
 showDown('H9', 'SK', 'DK', 'D10') . PHP_EOL;   //=> ['high card', 'high card', 2]
//showDown('H3', 'S5', 'D5', 'D3') . PHP_EOL;    //=> ['high card', 'high card', 0]
// showDown('CA', 'DA', 'C2', 'D2') . PHP_EOL;    //=> ['pair', 'pair', 1]
// showDown('CK', 'DK', 'CA', 'DA') . PHP_EOL;    //=> ['pair', 'pair', 2]
// showDown('C4', 'D4', 'H4', 'S4') . PHP_EOL;    //=> ['pair', 'pair', 0]
// showDown('SA', 'DK', 'C2', 'CA') . PHP_EOL;    //=> ['straight', 'straight', 1]
// showDown('C2', 'CA', 'S2', 'D3') . PHP_EOL;    //=> ['straight', 'straight', 2]
// showDown('S2', 'D3', 'C2', 'H3') . PHP_EOL;    //=> ['straight', 'straight', 0]