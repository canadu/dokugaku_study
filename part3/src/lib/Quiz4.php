<?php

// 次郎と春子はHIT&BLOWで遊んでいます。ルールは以下の通りです。
// 1、出題者は重複した数を含まない4桁の数を決める
// 2、回答者は4桁の数を予想する
// 3、出題者は解答者の予想を判定する。数と桁の両方が同じならヒット、数だけが同じで桁が異なればブローと呼ぶ。
//    例えば正解が1234で回答が2135なら「1ヒット、2ブロー」となる
// 4、2-3を繰り返し、4桁の数が完全に同じになるまでの回数で勝負を決める
//    次郎と春子は遊ぶうちに計算を毎回行うのが面倒になったため、ヒット数とブロー数を算出するプログラムを作成することにしました。
//    正解と回答を入力し、ヒット数とブロー数を出力するプログラムを作成しましょう。
// ◯仕様
// ヒット数とブロー数を判定するjudgeメソッドを定義してください。
// judgeメソッドは正解と回答を引数に受け取り、ヒット数とブロー数の配列を返します。
// 正解と回答は4桁の整数、ヒット数とブロー数は0〜4の整数とします。
// ◯実行例
// judge(5678, 5678) //=> [4, 0]
// judge(5678, 7612) //=> [1, 1]
// judge(5678, 8756) //=> [0, 4]
// judge(5678, 1234) //=> [0, 0]
/**
 * @param int $argCorrect
 * @param int $argAnswer
 * @return array<int> $arReturn
 */
function judge(int $argCorrect, int $argAnswer): array
{
    //正解
    $arCorrects = str_split((string)$argCorrect);
    //答え
    $arAnswers = str_split((string)$argAnswer);
    $icnt = 0;
    $jcnt = 0;
    $hitCnt = 0;
    $blowCnt = 0;
    foreach ($arAnswers as $arAnswer) {
        if ($arAnswer === $arCorrects[$icnt]) {
            //Hitの確認
            $hitCnt += 1;
        } else {
            //blowの確認
            foreach ($arCorrects as $arCorrect) {
                if ($arCorrect === $arAnswer) {
                    $blowCnt += 1;
                }
                $jcnt++;
            }
        }
        $icnt++;
        //初期化
        $jcnt = 0;
    }
    $arReturn = array($hitCnt,$blowCnt);
    return $arReturn;
}

//回答例
// function judge(int $answer, int $guess): array
// {
//     $hit = 0;
//     $blow = 0;
//     $arrayGuess = str_split((string) $guess);
//     foreach ($arrayGuess as $index => $guessElem) {
//         if (isHit($guessElem, $answer, $index)) {
//             $hit++;
//         }

//         if (isBlow($guessElem, $answer, $index)) {
//             $blow++;
//         }
//     }

//     return [$hit, $blow];
// }

// function isHit(string $letter, int $answer, int $index): bool
// {
//     return str_split((string) $answer)[$index] === $letter;
// }

// function isBlow(string $letter, int $answer, int $index): bool
// {
//     if (isHit($letter, $answer, $index)) {
//         return false;
//     }

//     return in_array($letter, str_split((string) $answer), true);
// }
