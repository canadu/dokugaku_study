<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../lib/Quiz2.php');

// クラス名とファイル名を揃える
final class Quiz2Test extends TestCase
{
    public function testCalc()
    {
        $output = <<< EOT
        1.7
        1 45 2
        5 25 1
        2 30 1
        
        EOT;
        $input = ['0' => './lib/Quiz2.php', '1' => 1, '2' => 30, '3' => 5, '4' => 25, '5' => 2, '6' => 30, '7' => 1, '8' => 15];
        $this->expectOutputString($output);
        exeCute($input);
    }
}
