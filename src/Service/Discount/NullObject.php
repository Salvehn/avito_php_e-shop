<?php

declare(strict_types = 1);

namespace Service\Discount;
use Model\Entity\Discount;
class NullObject implements IDiscount
{
    private $discount;

    public function __construct(?Discount $discount)
    {
        $this->discount = $discount;
    }
    public function checkDiscount(): bool
    {
        if (is_null($this->discount)){
            return false;
        }
        return true;
    }
    /**
     * @inheritdoc
     */
    public function getDiscount(): float
    {


        return $discount;
    }
}
