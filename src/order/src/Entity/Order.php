<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Product\Entity\Product;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(length: 36)]
    private string $id;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    #[ORM\Column(length: 255)]
    private string $customerName;

    #[ORM\Column]
    private int $quantity;

    public function __construct(
        string  $id,
        Product $product,
        string  $customerName,
        int     $quantity
    )
    {
        $this->id = $id;
        $this->product = $product;
        $this->customerName = $customerName;
        $this->quantity = $quantity;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
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
