<?php

declare(strict_types=1);
namespace Framework;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterCfgReceiver
{
    public function operation(string $dir, ContainerBuilder $containerBuilder)
    {
        try {
            $fileLocator = new FileLocator($dir . DIRECTORY_SEPARATOR . 'config');
            $loader = new PhpFileLoader($containerBuilder, $fileLocator);
            $loader->load('parameters.php');
        } catch (\Throwable $e) {
            die('Cannot read the config file. File: ' . __FILE__ . '. Line: ' . __LINE__);
        }
    }
}
