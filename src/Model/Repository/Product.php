<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class Product
{
    /**
     * Поиск продуктов по массиву id
     *
     * @param int[] $ids
     * @return Entity\Product[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        $productList = [];
        $product = new Entity\Product(0, '', 0, '');
        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $product->setId($item['id']);
            $product->setName($item['name']);
            $product->setPrice($item['price']);
            $product->setDesc($item['desc']);
            $productList[] = clone $product;
        }

        return $productList;
    }

    /**
     * Получаем все продукты
     *
     * @return Entity\Product[]
     */
    public function fetchAll(): array
    {
        $productList = [];
        $product = new Entity\Product(0, '', 0, '');
        foreach ($this->getDataFromSource() as $item) {
            $product->setId($item['id']);
            $product->setName($item['name']);
            $product->setPrice($item['price']);
            $product->setDesc($item['desc']);
            $productList[] = clone $product;
        }

        return $productList;
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
                'id' => 1,
                'name' => 'PHP',
                'price' => 15300,
                'desc' => 'old one'
            ],
            [
                'id' => 2,
                'name' => 'Python',
                'price' => 20400,
                'desc' => 'nice one'
            ],
            [
                'id' => 3,
                'name' => 'C#',
                'price' => 30100,
                'desc' => 'decent one'
            ],
            [
                'id' => 4,
                'name' => 'Java',
                'price' => 30600,
                'desc' => 'tough one'
            ],
            [
                'id' => 5,
                'name' => 'Ruby',
                'price' => 18600,
                'desc' => 'unknown'
            ],
            [
                'id' => 8,
                'name' => 'Delphi',
                'price' => 8400,
                'desc' => ':D'
            ],
            [
                'id' => 9,
                'name' => 'C++',
                'price' => 19300,
                'desc' => 'beyond humanity'
            ],
            [
                'id' => 10,
                'name' => 'C',
                'price' => 12800,
                'desc' => 'just oof'
            ],
            [
                'id' => 11,
                'name' => 'Lua',
                'price' => 5000,
                'desc' => 'e2 daddy'
            ],
            [
                'id' => 12,
                'name' => 'Rust',
                'price' => 1234,
                'desc' => 'dafuq is this'
            ]
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return in_array($dataSource[key($search)], current($search), true);
        };

        return array_filter($dataSource, $productFilter);
    }
}
