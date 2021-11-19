<?php  

use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../../lib/oop_VendingMachine/VendingBuyer.php');
//require_once(__DIR__ . '/../../lib/oop_VendingMachine/VendingMachine.php');

class VendingBuyerTest extends TestCase
{
    public function testpressButton() {
        $vendingMachine = new VendingMachine();
        $vendingBuyer = new Buyer();
        
        $vendingMachine->kindDrink = 'cider';
        $vendingMachine->depositCoin([100]);
        $this->assertSame('cider', $vendingBuyer->pressButton($vendingMachine));

        $vendingMachine->kindDrink = 'cola';
        $vendingMachine->depositCoin([100, 100]);
        $this->assertSame('cola', $vendingBuyer->pressButton($vendingMachine));
    }
}
