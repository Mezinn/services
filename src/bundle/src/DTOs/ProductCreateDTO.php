<?php

declare(strict_types=1);

namespace Product\DTOs;

class ProductCreateDTO
{
    private string $name;
    private float $price;
    private int $quantity;

    public function __construct(
        string $name,
        float  $price,
        int    $quantity
    )
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
