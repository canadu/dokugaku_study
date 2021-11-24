<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../../lib/oop_VendingMachine/Item.php');

class ItemTest extends TestCase
{
    public function testGetPrice()
    {
        $item = new Item('cola');
        $this->assertSame(150, $item->getPrice());
    }

    public function testGetName()
    {
        $item = new Item('cola');
        $this->assertSame('cola', $item->getName());
    }
}