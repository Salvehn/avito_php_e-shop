<?php


namespace Service\Order;

use Service\User\ISecurity;
use Service\Billing\IBilling;
use Service\Discount\IDiscount;
use Service\Communication\ICommunication;

class CheckoutProcess
{
    /**
     * @var float
     */
    private $finalPrice;

    /**
     * @var IDiscount
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

    public function __construct(BasketBuilder $builder)
    {
        $this->finalPrice = $builder->getFinalPrice();
        $this->discount = $builder->getDiscount();
        $this->security = $builder->getSecurity();
        $this->billing = $builder->getBilling();
        $this->communication = $builder->getCommunication();
    }

    /**
     * Проведение всех этапов заказа
     *
     * @param Model\Entity\Product[]
     * @return array order info
     */
    public function checkoutProcess(array $products): array
    {
        //$percentLeft = 1 - ($this->discount->getDiscount() / 100);

        $finalPrice = $this->finalPrice;

        $this->billing->pay($finalPrice);

        $user = $this->security->getUser();

        $this->communication->process($user, 'checkout_template');
        
        return ['productList' => $products, 'discount' => $this->discount, 'finalPrice' => $finalPrice];
    }
}
