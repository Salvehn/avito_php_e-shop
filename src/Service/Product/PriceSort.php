<?php

declare(strict_types = 1);

namespace Service\Product;
function debug_log($object = null, $label = null)
{
    $message = json_encode($object, JSON_PRETTY_PRINT);
    $label = "Debug" . ($label ? " ($label): " : ': ');
    echo "<script>console.log(\"$label\", $message);</script>";
}
class PriceSortStrategy implements ISortStrategy {
    private $list;

    public function __construct($list)
    {
        $this->list = $list;
    }
    private function compare($a, $b){
        return $a->getPrice() - $b->getPrice();
    }
    public function algorithm(): array {
        $temp = $this->list;

        usort($temp,array($this,'compare'));
        return $temp;
    }
}
