<?php

require_once('VendingMachine.php');

class Buyer
{
    public function pressButton(VendingMachine $machine) : string {
        return $machine->purchaseDrink($machine);
    }
}

?>