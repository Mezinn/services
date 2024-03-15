<?php

declare(strict_types=1);

namespace Product\Entity;

use Doctrine\ORM\Mapping as ORM;
use Product\Repository\ProductRepository;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private string $id;

    #[ORM\Column(length: 64)]
    private string $name;

    #[ORM\Column]
    private float $price;

    #[ORM\Column]
    private int $quantity;

    public function __construct(
        string $id,
        string $name,
        float  $price,
        int $quantity
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
