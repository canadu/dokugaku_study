<?php  

use PHPUnit\Framework\TestCase;
require_once(__DIR__ . '/../../lib/oop_VendingMachine/VendingMachine.php');

class VendingMachineTest extends TestCase
{
    public function testDepositCoin()
    {
        $vendingMachine = new VendingMachine();
        $this->assertSame(0, $vendingMachine->depositCoin([0]));
        $this->assertSame(100, $vendingMachine->depositCoin([100]));
        $this->assertSame(200, $vendingMachine->depositCoin([100, 100]));
    }

    public function testpurchaseDrink() {
        $vendingMachine = new VendingMachine();

        $vendingMachine->kindDrink = 'cider';
        $vendingMachine->depositCoin([100]);
        $this->assertSame('cider', $vendingMachine->purchaseDrink($vendingMachine));

        $vendingMachine->kindDrink = 'cola';
        $vendingMachine->depositCoin([100, 100]);
        $this->assertSame('cola', $vendingMachine->purchaseDrink($vendingMachine));
    }
}

?>
