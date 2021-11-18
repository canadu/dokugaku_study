<?php

class VendingMachine{

    private const PRICE_OF_DRINK_CIDER = 100;
    private const PRICE_OF_DRINK_COLA = 200;

    private const DRINK_NAME_COLA = 'cola';
    private const DRINK_NAME_CIDER = 'cider';

    public string $kindDrink = '';
    public int $depositCoin = 0;

    // public function __construct(private string $kindDrink) 
    // {        
    // }

    public function depositCoin(array $moneys): int
    {
        $this->depositCoin = 0;
        foreach($moneys as $money) {
            if ($money === 100) {
                $this->depositCoin += $money;
            }
        }
        return $this->depositCoin;
    }

    public function purchaseDrink(VendingMachine $machine): string
    {
        if ($machine->kindDrink === $this::DRINK_NAME_CIDER) {
            //サイダー
            if ($machine->depositCoin >= $this::PRICE_OF_DRINK_CIDER) {
                $machine->depositCoin -= $this::PRICE_OF_DRINK_CIDER;
                return $this::DRINK_NAME_CIDER;
            } else {
                return '';
            }
            $machine->depositCoin -= $this::PRICE_OF_DRINK_CIDER;
        } elseif ($machine->kindDrink === $this::DRINK_NAME_COLA) {
            //コーラ
            if ($machine->depositCoin >= $this::PRICE_OF_DRINK_COLA) {
                $machine->depositCoin -= $this::PRICE_OF_DRINK_COLA;
                return $this::DRINK_NAME_COLA;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
}

?>