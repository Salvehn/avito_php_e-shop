<?php

declare(strict_types = 1);

namespace Service\SocialNetwork;

class SocialNetwork
{
    /**
     * Получение класса соц.сети
     *
     * @param string $socialNetwork
     * @param string $courseName
     *
     * @return void
     */
    public function create(string $socialNetwork, string $courseName): void
    {
        // Реализовать паттерн Адаптер с названиями указанными ниже

        switch ($socialNetwork) {
            case ISocialNetwork::SOCIAL_NETWORK_VK:
                $vk = new VK();
                $socialNetworkAdapter = new VKAdapter($vk);
                break;

            case ISocialNetwork::SOCIAL_NETWORK_FACEBOOK:
                $fb = new FB();
                $socialNetworkAdapter = new FBAdapter($fb);
                break;

            default:
                $vk = new VK();
                $socialNetworkAdapter = new VKAdapter($vk);
        }

        $this->sendMessage($socialNetworkAdapter, $courseName);
    }

    /**
     * Отправка сообщения в соц.сеть
     *
     * @param ISocialNetwork $socialNetwork
     * @param string $courseName
     *
     * @return void
     */
    protected function sendMessage(ISocialNetwork $socialNetwork, string $courseName): void
    {
        $socialNetwork->send('Интересный ' . $courseName . ' курс');
    }
}
