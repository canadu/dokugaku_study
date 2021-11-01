<?php

use PHPUnit\Framework\TestCase;

// クラス名とファイル名を揃える
final class MathTest extends TestCase
{
    public function testDouble()
    {
        require_once(__DIR__ . '/../lib/Math.php');
        $this->assertSame(4, double(2));
    }
}
