<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class Discount
{
    /**
     * Поиск продуктов по массиву id
     *
     * @param int[] $ids
     * @return Entity\Discount[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        $DiscountList = [];
        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $DiscountList[] = new Entity\Discount($item['id'], $item['name'], $item['discount']);
        }

        return $DiscountList;
    }

    /**
     * Получаем все продукты
     *
     * @return Entity\Discount[]
     */
    public function fetchAll(): array
    {
        $DiscountList = [];
        foreach ($this->getDataFromSource() as $item) {
            $DiscountList[] = new Entity\Discount($item['id'], $item['name'], $item['discount']);
        }

        return $DiscountList;
    }

    /**
     * Получаем продукты из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $dataSource = [

            [
                'id' => 8,
                'name' => 'Delphi',
                'discount' => 0.92
            ]
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $DiscountFilter = function (array $dataSource) use ($search): bool {
            return in_array($dataSource[key($search)], current($search), true);
        };

        return array_filter($dataSource, $DiscountFilter);
    }
}
