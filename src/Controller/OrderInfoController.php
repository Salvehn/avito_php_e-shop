<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\Order\Basket;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderInfoController
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

             $lastOrder = (new Basket($request->getSession()))->getLastOrder();

         }
         return $this->render('order/info.html.php', ['finalList' => $productList, 'isLogged' => $isLogged,'finalPrice'=>$finalPrice,'lastOrder'=>$lastOrder]);
     }
}
