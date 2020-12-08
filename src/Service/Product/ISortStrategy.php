<?php

declare(strict_types = 1);

namespace Service\Product;

interface ISortStrategy {
    public function algorithm(): array;
}
