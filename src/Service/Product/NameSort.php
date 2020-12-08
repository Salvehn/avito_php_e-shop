<?php

declare(strict_types = 1);

namespace Service\Product;

class NameSortStrategy implements ISortStrategy {
    private $list;

    public function __construct($list)
    {
        $this->list = $list;
    }
    private function compare($a, $b) {
        return strcmp($a->getName(), $b->getName());
    }
    public function algorithm(): array {
        $temp = $this->list;
        usort($temp,array($this,'compare'));
        return $temp;
    }
}
