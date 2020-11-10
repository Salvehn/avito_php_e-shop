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

    /**
     * @param float $orderPrice
     */
    public function __construct(?float $totaPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {
        if ($this->totalPrice >= self::TOTAL_ORDER){
            $discount = self::DISCOUNT_AMOUNT;
        }
        else
            $discount = 1;

        return $discount;
    }
}
