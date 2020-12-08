<?php

declare(strict_types = 1);

namespace Service\Product;

use Model;

class Product
{
    /**
     * Получаем информацию по конкретному продукту
     *
     * @param int $id
     * @return Model\Entity\Product|null
     */
    public function getInfo(int $id): ?Model\Entity\Product
    {
        $product = $this->getProductRepository()->search([$id]);
        return count($product) ? $product[0] : null;
    }

    /**
     * Получаем все продукты
     *
     * @param string $sortType
     *
     * @return Model\Entity\Product[]
     */
    public function getAll(string $sortType): array
    {
        $productList = $this->getProductRepository()->fetchAll();
        $sortcontext = new SortContext();
        $sortedList = $productList;
        //debug_log($sortcontext->a());

        switch ($sortType) {
            case 'price':

                $sortedList = $sortcontext->sort(new PriceSortStrategy($productList));
                break;
            case 'name':
            
                $sortedList = $sortcontext->sort(new NameSortStrategy($productList));
                break;
            default:
                $sortedList = $productList;
                break;
        }

        // Применить паттерн Стратегия
        // $sortType === 'price'; // Сортировка по цене
        // $sortType === 'name'; // Сортировка по имени

        return $sortedList;
    }

    /**
     * Фабричный метод для репозитория Product
     *
     * @return Model\Repository\Product
     */
    protected function getProductRepository(): Model\Repository\Product
    {
        return new Model\Repository\Product();
    }
}
