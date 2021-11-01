<?php

use PHPUnit\Framework\TestCase;

// クラス名とファイル名を揃える
final class Quiz2Test extends TestCase
{
    public function testCalc(): void
    {
        require_once(__DIR__ . '/../lib/Quiz2.php');
        $output = '1.7' . PHP_EOL . '1 45 2' . PHP_EOL . '2 30 1' . PHP_EOL . '5 25 1';
        $input = ['0' => 'lib/Quiz2.php', '1' => 1, '2' => 30, '3' => 5, '4' => 25, '5' => 2, '6' => 30, '7' => 1, '8' => 15];
        $this->assertSame($output, exeCute($input));
    }
}
