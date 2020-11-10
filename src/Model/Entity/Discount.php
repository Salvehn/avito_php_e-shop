<?php

declare(strict_types = 1);

namespace Model\Entity;

class Discount
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $discount;

    /**
     * @param int $id
     * @param string $name
     * @param float $price
     * @param string $desc
     */
    public function __construct(int $id, string $name, float $discount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->discount = $discount;


    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'discount' => $this->discount,


        ];
    }
}
