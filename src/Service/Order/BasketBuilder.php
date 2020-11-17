<?php


namespace Service\Order;

use Service\User\ISecurity;
use Service\Billing\IBilling;
use Service\Discount\IDiscount;
use Service\Communication\ICommunication;

class BasketBuilder
{
    /**
     * @var float
     */
    private $finalPrice;

    /**
     * @var float
     */
    private $discount;

    /**
     * @var ISecurity
     */
    private $security;

    /**
     * @var IBilling
     */
    private $billing;

    /**
     * @var ICommunication
     */
    private $communication;

    /**
     * @return float
     */
    public function getFinalPrice(): float
    {
        return $this->finalPrice;
    }

    /**
     * @param float $finalPrice
     * @return BasketBuilder
     */
    public function setFinalPrice(float $finalPrice): BasketBuilder
    {
        $this->finalPrice = $finalPrice;
        return $this;
    }

    /**
     * @return IDiscount
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @param IDiscount $discount
     * @return BasketBuilder
     */
    public function setDiscount($discount): BasketBuilder
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return ISecurity
     */
    public function getSecurity(): ISecurity
    {
        return $this->security;
    }

    /**
     * @param ISecurity $security
     * @return BasketBuilder
     */
    public function setSecurity(ISecurity $security): BasketBuilder
    {
        $this->security = $security;
        return $this;
    }

    /**
     * @return IBilling
     */
    public function getBilling(): IBilling
    {
        return $this->billing;
    }

    /**
     * @param IBilling $billing
     * @return BasketBuilder
     */
    public function setBilling(IBilling $billing): BasketBuilder
    {
        $this->billing = $billing;
        return $this;
    }

    /**
     * @return ICommunication
     */
    public function getCommunication(): ICommunication
    {
        return $this->communication;
    }

    /**
     * @param ICommunication $communication
     * @return BasketBuilder
     */
    public function setCommunication(ICommunication $communication): BasketBuilder
    {
        $this->communication = $communication;
        return $this;
    }

    public function build(): CheckoutProcess
    {
        return new CheckoutProcess($this);
    }
}
