<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Service\Billing\Card;
use Service\Billing\IBilling;
use Service\Communication\Email;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\Discount\ItemDiscount;
use Service\Discount\NullObject;
use Service\Discount\BirthdayDiscount;
use Service\Discount\TotalDiscount;



use Service\User\ISecurity;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
function debug_log($object = null, $label = null)
{
    $message = json_encode($object, JSON_PRETTY_PRINT);
    $label = "Debug" . ($label ? " ($label): " : ': ');
    echo "<script>console.log(\"$label\", $message);</script>";
}
class Basket
{
    /**
     * Сессионный ключ списка всех продуктов корзины
     */
    private const LAST_ORDER = 'lastorder';

    private const BASKET_DATA_KEY = 'basket';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Добавляем товар в заказ
     *
     * @param int $product
     *
     * @return void
     */

     private function combineDiscount($product)
     {
         $discount = (new ItemDiscount())->getInfo($product->getId());

         $out=['product'=>$product,'discount'=>$discount];
         return $out;
     }

    public function addProduct(int $product): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        if (!in_array($product, $basket, true)) {
            $basket[] = $product;
            $this->session->set(static::BASKET_DATA_KEY, $basket);
        }
    }

    /**
     * Проверяем, лежит ли продукт в корзине или нет
     *
     * @param int $productId
     *
     * @return bool
     */
    public function isProductInBasket(int $productId): bool
    {
        return in_array($productId, $this->getProductIds(), true);
    }

    /**
     * Получаем информацию по всем продуктам в корзине
     *
     * @return Model\Entity\Product[]
     */
    public function getProductsInfo(): array
    {
        $productIds = $this->getProductIds();

        $productList = $this->getProductRepository()->search($productIds);

        $finalList = array_map([$this,'combineDiscount'],$productList);

        return $finalList;
    }

    public function getTotalPrice($finalList)
    {
        $price = 0;
        $finalPrice = 0;
        foreach ($finalList as $item) {

            if((new NullObject($item['discount']))->checkDiscount()){
                $price += $item['product']->getPrice()*$item['discount']->getDiscount();
            }else{

                $price += $item['product']->getPrice();
            }

        }
        $finalPrice = $price;
        $isLogged = (new Security($this->session))->isLogged();

        if($isLogged){
            $user = (new Security($this->session))->getUser();
            //debug_log($user,'USER');

            $finalPrice = $finalPrice*(new BirthdayDiscount($user))->getDiscount();
        }

        $finalPrice = $finalPrice*(new TotalDiscount($finalPrice))->getDiscount();
        $discount = $price - $finalPrice;
        return ['price'=>$price,'discount'=>$discount,'finalPrice'=>$finalPrice];
    }

    /**
     * Оформление заказа
     *
     * @return void
     */
    public function checkout()
    {
        // Здесь должна быть некоторая логика выбора способа платежа
        $billing = new Card();

        // Здесь должна быть некоторая логика получения информации о скидки пользователя


        // Здесь должна быть некоторая логика получения способа уведомления пользователя о покупке
        $communication = new Email();

        $security = new Security($this->session);
        list('discount' => $discount, 'finalPrice' => $finalPrice) = $this->getTotalPrice($this->getProductsInfo());
        return $this->checkoutProcess($discount, $finalPrice, $security, $communication);
    }

    /**
     * Проведение всех этапов заказа
     *
     * @param IDiscount $discount,
     * @param IBilling $billing,
     * @param ISecurity $security,
     * @param ICommunication $communication
     * @return void
     */
    public function checkoutProcess(

        float $discount,
        float $finalPrice,
        ISecurity $security,
        ICommunication $communication
    ) {

        $products = $this->getProductsInfo();
        debug_log($finalPrice,'finalPrice');
        //не работает
        //$billing->pay($finalPrice);

        debug_log($discount,'discount');
        $user = $security->getUser();
        $communication->process($user, 'checkout_template');
        $this->setLastOrder($finalPrice);
        return ['products'=>$products,'discount'=>$discount,'finalPrice'=>$finalPrice];
    }

    /**
     * Фабричный метод для репозитория Product
     *
     * @return Model\Repository\Product
     */
    protected function getProductRepository(): Model\Repository\Product
    {
        return new Model\Repository\Product();
    }


    private function setLastOrder($lastOrder)
    {

        return $this->session->set(LAST_ORDER_DATA_KEY,$lastOrder);
    }
    public function getLastOrder()
    {

        return $this->session->get(LAST_ORDER_DATA_KEY);
    }
    /**
     * Получаем список id товаров корзины
     *
     * @return array
     */
    private function getProductIds(): array
    {
        return $this->session->get(static::BASKET_DATA_KEY, []);
    }
}
