<?php

declare(strict_types=1);
namespace Framework;

class RegisterRoutesReceiver
{
    public function operation($routeCollection, $containerBuilder, $dir)
    {
        $routeCollection = require $dir . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routing.php';
        $containerBuilder->set('route_collection', $routeCollection);
        return array($routeCollection, $containerBuilder);
    }
}
