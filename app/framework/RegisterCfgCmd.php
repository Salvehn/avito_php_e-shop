<?php

declare(strict_types=1);
namespace Framework;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterCfgCmd implements ICommand
{
    private RegisterCfgReceiver $receiver;
    private string $dir;
    private ContainerBuilder $containerBuilder;

    public function __construct(RegisterCfgReceiver $receiver, string $dir, ContainerBuilder $containerBuilder)
    {
        $this->receiver = $receiver;
        $this->dir = $dir;
        $this->containerBuilder = $containerBuilder;
    }

    public function execute()
    {
        $this->receiver->operation($this->dir, $this->containerBuilder);
    }
}
