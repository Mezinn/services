<?php

declare(strict_types=1);

namespace Product\Message;

class ProductCreatedMessage
{
    private string $id;
    private string $name;
    private float $price;
    private int $quantity;

    public function __construct(
        string $id,
        string $name,
        float  $price,
        int    $quantity
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getId(): string
    {
        return $this->id;
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
