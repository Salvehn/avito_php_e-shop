<?php

declare(strict_types = 1);

namespace Service\Discount;

use Model;

class TotalDiscount implements IDiscount
{
    public const TOTAL_ORDER = 40000;
    public const DISCOUNT_MULTIPLIER = 0.9;

    /**
     * @var float
     */
    private $totalPrice;


    public function __construct(float $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {

        if ($this->totalPrice >= floatval(self::TOTAL_ORDER)){
            $discount = self::DISCOUNT_MULTIPLIER;
        }
        else
            $discount = 1;

        return $discount;
    }
}
