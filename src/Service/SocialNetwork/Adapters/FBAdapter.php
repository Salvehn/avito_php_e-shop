<?php

declare(strict_types=1);
namespace Service\SocialNetwork;

class FB
{

    public function send(string $msg): string
    {
        return strtolower($msg);
    }

}
class FBAdapter implements ISocialNetwork
{
    private $adapter;
    public function __construct(FB $adapter)
    {
        $this->adapter=$adapter;
    }
    public function send(string $msg):void
    {
        $message = $this->adapter->send($msg);
    }
}
?>
