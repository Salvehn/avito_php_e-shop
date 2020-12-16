<?php

declare(strict_types=1);

namespace Controller;

use Framework\Render;
use Service\Order\Basket;
use Service\Order\CheckoutFacade;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderCheckoutController
{
   use Render;

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

        (new CheckoutFacade($request->getSession()))->checkout();

        return $this->render('order/checkout.html.php');
    }
}
