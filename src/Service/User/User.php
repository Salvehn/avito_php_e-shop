<?php

declare(strict_types = 1);

namespace Service\User;

use Model;

class User
{
    /**
     * Получаем информацию по конкретному продукту
     *
     * @param int $id
     * @return Model\Entity\User|null
     */
    public function getInfo(int $id): ?Model\Entity\User
    {
        $User = $this->getUserRepository()->search([$id]);
        return count($User) ? $User[0] : null;
    }

    /**
     * Получаем все продукты
     *
     *
     * @return array
     */
    public function getAll(): array
    {
        $userList = $this->getUserRepository()->fetchAll();


        return $userList;
    }

    /**
     * Фабричный метод для репозитория User
     *
     * @return Model\Repository\User
     */
    protected function getUserRepository(): Model\Repository\User
    {
        return new Model\Repository\User();
    }
}
