<?php

declare(strict_types = 1);

namespace Controller;

use Framework\Render;
use Service\Order\Basket;
use Service\User\Security;
use Model\Entity\Discount;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
function debug_log($object = null, $label = null)
{
    $message = json_encode($object, JSON_PRETTY_PRINT);
    $label = "Debug" . ($label ? " ($label): " : ': ');
    echo "<script>console.log(\"$label\", $message);</script>";
}
class OrderController
{
    use Render;

    /**
     * Корзина
     *
     * @param Request $request
     * @return Response
     */

    public function infoAction(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            return $this->redirect('order_checkout');
        }
        $isLogged = (new Security($request->getSession()))->isLogged();
        $productList = (new Basket($request->getSession()))->getProductsInfo();
        list('finalPrice'=>$finalPrice) = ((new Basket($request->getSession()))->getTotalPrice($productList));

        $lastOrder = null;
        if($isLogged){
            debug_log($lastOrder,'lastOrder1');
            $lastOrder = (new Basket($request->getSession()))->getLastOrder();
            debug_log($lastOrder,'lastOrder2');
        }
        return $this->render('order/info.html.php', ['finalList' => $productList, 'isLogged' => $isLogged,'finalPrice'=>$finalPrice,'lastOrder'=>$lastOrder]);
    }

    /**
     * Оформление заказа
     *
     * @param Request $request
     * @return Response
     */
    public function checkoutAction(Request $request): Response
    {
        $isLogged = (new Security($request->getSession()))->isLogged();
        if (!$isLogged) {
            return $this->redirect('user_authentication');
        }

        (new Basket($request->getSession()))->checkout();

        return $this->render('order/checkout.html.php');
    }
}
