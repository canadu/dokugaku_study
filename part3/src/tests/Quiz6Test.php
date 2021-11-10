<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/Quiz6.php');

// クラス名とファイル名を揃える
class Quiz6Test extends TestCase
{
    public function testconvertToNumber()
    {
        $this->assertSame(['7'], convertToNumber('C7'));
        $this->assertSame(['3', '10', 'A'], convertToNumber('H3', 'S10', 'DA'));
    }
}