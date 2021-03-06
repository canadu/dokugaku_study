<?php

// クイズ】ツーカードポーカーにアクセス権を付けよう

// ◯お題
// ツーカードポーカーのプロパティやメソッドにアクセス権を付けましょう。下記仕様を追加します。
// プレイヤーの人数を2人に変更しましょう
// プログラムを実行すると、与えられた2人のカードをそのまま返します
// テスト駆動で開発しましょう。
// ◯仕様
// プログラムの入力値として「プレイヤー1のカードの配列、プレイヤー2のカードの配列」を取ります。プログラムの返り値として「プレイヤー1のカードの配列、プレイヤー2のカードの配列」を返します
// ◯テスト例
// 次のテストが通るようにコードを書きましょう。

class PokerGame
{
	function __construct(protected array $p1cards, protected array $p2cards)
	{
	}
    function start(): array
    {
        return [$this->p1cards, $this->p2cards];
    }
}
