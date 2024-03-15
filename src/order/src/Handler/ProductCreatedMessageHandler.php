<?php

declare(strict_types=1);

namespace App\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Product\Entity\Product;
use Product\Message\ProductCreatedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProductCreatedMessageHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(ProductCreatedMessage $message)
    {
        $product = new Product(
            $message->getId(),
            $message->getName(),
            $message->getPrice(),
            $message->getQuantity()
        );
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}
