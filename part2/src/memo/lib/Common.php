<?php

use function PHPUnit\Framework\isEmpty;

function h(string $char) :string {
    return htmlspecialchars($char);   
}

/**
 *前後にある半角全角スペースを削除する関数 
 */
function spaceTrim ($str) {
	// 行頭
	$str = preg_replace('/^[ 　]+/u', '', $str);
	// 末尾
	$str = preg_replace('/[ 　]+$/u', '', $str);
	return $str;
}