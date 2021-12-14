<?php

use function PHPUnit\Framework\isEmpty;

function h(string $char) :string {
    return htmlspecialchars($char);   
}