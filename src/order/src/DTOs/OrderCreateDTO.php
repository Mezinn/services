<?php

declare(strict_types=1);

namespace App\DTOs;

class OrderCreateDTO
{
    private string $productId;
    private string $customerName;
    private int $quantity;

    public function __construct(
        string $productId,
        string $customerName,
        int    $quantity
    )
    {
        $this->productId = $productId;
        $this->customerName = $customerName;
        $this->quantity = $quantity;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getCustomerName(): string
    {
        return $this->customerName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
