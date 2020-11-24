<?php

declare(strict_types=1);
namespace Service\SocialNetwork;

class VK
{

    public function send(string $msg): string
    {
        return strtolower($msg);
    }

}
class VKAdapter implements ISocialNetwork
{
    private $adapter;
    public function __construct(VK $adapter)
    {
        $this->adapter=$adapter;
    }
    public function send(string $msg):void
    {
        $message = $this->adapter->send($msg);
    }
}
?>
