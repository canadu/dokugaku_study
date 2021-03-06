<?php

// クイズ】ツーカードポーカーを単一責任の原則で設計しよう

// ◯お題
// ツーカードポーカーを単一責任の原則で設計しましょう。下記の仕様を追加します。
// プログラムを実行すると、与えられたカードのランクを返すようにします
// テスト駆動で開発しましょう。

// ◯仕様
// カードのランクは、2が1、3が2、...Kが12、Aが13とします。
// プログラムの入力値として「プレイヤー1のカードの配列、プレイヤー2のカードの配列」を取ります。
//プログラムの返り値として [プレイヤー1のカードランクの配列, プレイヤー2のカードランクの配列] を返します。

// ◯テスト例
// PokerGameTest のテスト例のみ記載します。他のクラスは単一責任の原則に基づいて設計してみてください。

require_once('PokerPlayer.php');
require_once('PokerHandEvaluator.php');
require_once('PokerTwoCardRule.php');
require_once('PokerThreeCardRule.php');

class PokerGame
{
    public function __construct(private array $cards1, private array $cards2)
    {
    }

    public function start(): array
    {
        $hands = [];
        foreach ([$this->cards1, $this->cards2] as $cards) {
            $pokerCards = array_map(fn ($card) => new PokerCard($card), $cards);
            $rule = $this->getRule($cards);
            $handEvaluator = new PokerHandEvaluator($rule);
            $hands[] = $handEvaluator->getHand($pokerCards);
        }
        return $hands;
    }

    private function getRule(array $cards): PokerRule
    {
        $rule = new PokerTwoCardRule();
        if (count($cards) === 3) {
            $rule = new PokerThreeCardRule();
        }
        return $rule;
    }
}
