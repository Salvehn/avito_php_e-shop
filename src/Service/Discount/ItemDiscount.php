<?php

declare(strict_types = 1);

namespace Service\Discount;

use Model;

class ItemDiscount
{
    /**
     * Получаем информацию по конкретному продукту
     *
     * @param int $id
     * @return Model\Entity\Discount|null
     */
    public function __construct()
    {
        
    }
    public function getInfo(int $id): ?Model\Entity\Discount
    {
        $Discount = $this->getDiscountRepository()->search([$id]);
        return count($Discount) ? $Discount[0] : null;
    }

    /**
     * Получаем все продукты
     *
     * @param string $sortType
     *
     * @return Model\Entity\Discount[]
     */
    public function getAll(string $sortType): array
    {
        $DiscountList = $this->getDiscountRepository()->fetchAll();

        // Применить паттерн Стратегия
        // $sortType === 'price'; // Сортировка по цене
        // $sortType === 'name'; // Сортировка по имени

        return $DiscountList;
    }

    /**
     * Фабричный метод для репозитория Discount
     *
     * @return Model\Repository\Discount
     */
    protected function getDiscountRepository(): Model\Repository\Discount
    {
        return new Model\Repository\Discount();
    }
}
