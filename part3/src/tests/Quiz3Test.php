<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/Quiz3.php');

// クラス名とファイル名を揃える
final class Quiz3Test extends TestCase
{
    public function testCalc()
    {
        $this->expectOutputString('1298');
        echo calc('21:00',[1, 1, 1, 3, 5, 7, 8, 9, 10]);
    }
}
