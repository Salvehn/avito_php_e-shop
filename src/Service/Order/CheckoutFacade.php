<?php
 declare(strict_types=1);

 namespace Service\Order;

 use Service\Billing\Card;
 use Service\Communication\Email;
 use Service\User\Security;
 use Symfony\Component\HttpFoundation\Session\SessionInterface;

 class CheckoutFacade
 {
     /**
      * @var SessionInterface
      */
     private $session;

     /**
      * FacadeCheckout constructor.
      * @param SessionInterface $session
      */
     public function __construct(SessionInterface $session)
     {
         $this->session = $session;
     }

     /**
      * @param BasketBuilder $basketBuilder
      * @throws \Service\Billing\Exception\BillingException
      * @throws \Service\Communication\Exception\CommunicationException
      */
     public function checkoutProcess(BasketBuilder $basketBuilder):void
     {
         $basketBuilder->build()->checkoutProcess($this->getBasket()->getProductsInfo());
     }

     /**
      * Оформление заказа
      *
      * @return void
      * @throws \Service\Billing\Exception\BillingException
      * @throws \Service\Communication\Exception\CommunicationException
      */
     public function checkout(): void
     {
         list('discount' => $discount, 'finalPrice' => $finalPrice) = $this->getBasket()->getTotalPrice($this->getBasket()->getProductsInfo());
         $basketBuilder = new BasketBuilder();

         $basketBuilder->setFinalPrice($finalPrice)
             ->setDiscount($discount)
             ->setSecurity(new Security($this->session))
             ->setBilling(new Card())
             ->setCommunication(new Email());

         $checkoutProcess = $basketBuilder->build();
         $checkoutProcess->checkoutProcess($this->getBasket()->getProductsInfo());
     }

     /**
      * Фабричный метод для Basket
      *
      * @return Basket
      */
     protected function getBasket(): Basket
     {
         return new Basket($this->session);
     }
 }
