<?php


declare(strict_types=1);
namespace Framework;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\RouteCollection;

class RegisterRoutesCmd implements ICommand
{
    private RegisterRoutesreceiver $receiver;
    /**
         * @var ?RouteCollection|null
         */
    protected $routeCollection;

    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;
    protected string $dir;

    public function __construct(RegisterRoutesReceiver $receiver, ?RouteCollection $routeCollection, ContainerBuilder $containerBuilder, string $dir)
    {
        $this->receiver = $receiver;
        $this->routeCollection = $routeCollection;
        $this->containerBuilder = $containerBuilder;
        $this->dir = $dir;
    }

    public function execute()
    {
        return $this->receiver->operation($this->routeCollection, $this->containerBuilder, $this->dir);

    }
}
