<?php

declare(strict_types = 1);

namespace Service\Product;

class SortContext {
    public function sort(ISortStrategy $strategy): array {
        return $strategy->algorithm();
    }
}
