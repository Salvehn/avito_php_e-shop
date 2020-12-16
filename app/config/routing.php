<?php

use Controller\MainController;
use Controller\OrderCheckoutController;
use Controller\OrderInfoController;
use Controller\ProductDescListController;
use Controller\ProductListController;
use Controller\ProductInfoController;
use Controller\ProductSocialController;
use Controller\UserAuthController;
use Controller\UserLogoutController;
use Controller\UserListController;
use Controller\UserProfileController;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add(
    'index',
    new Route('/', ['_controller' => [MainController::class, 'indexAction']])
);

$routes->add(
    'product_list',
    new Route('/product/list', ['_controller' => [ProductListController::class, 'listAction']])
);
$routes->add(
    'user_list',
    new Route('/user/list', ['_controller' => [UserListController::class, 'listAction']])
);
$routes->add(
    'user_profile',
    new Route('/user/profile', ['_controller' => [UserProfileController::class, 'profileAction']])
);
$routes->add(
    'product_desc_list',
    new Route('/product/desclist', ['_controller' => [ProductDescListController::class, 'listDescAction']])
);
$routes->add(
    'product_info',
    new Route('/product/info/{id}', ['_controller' => [ProductInfoController::class, 'infoAction']])
);
$routes->add(
    'product_into_social_network',
    new Route('/product/social/{network}', ['_controller' => [ProductSocialController::class, 'postAction']])
);

$routes->add(
    'order_info',
    new Route('/order/info', ['_controller' => [OrderInfoController::class, 'infoAction']])
);
$routes->add(
    'order_checkout',
    new Route('/order/checkout', ['_controller' => [OrderCheckoutController::class, 'checkoutAction']])
);

$routes->add(
    'user_authentication',
    new Route('/user/authentication', ['_controller' => [\Controller\UserAuthController::class, 'authenticationAction']])
);
$routes->add(
    'logout',
    new Route('/user/logout', ['_controller' => [\Controller\UserLogoutController::class, 'logoutAction']])
);

return $routes;
