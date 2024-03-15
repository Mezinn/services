<?php

declare(strict_types=1);

namespace App\Service;

use App\DTOs\OrderCreateDTO;
use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Product\Entity\Product;
use Symfony\Component\Uid\Factory\UuidFactory;

class OrderService
{
    private OrderRepository $orderRepository;
    private EntityManagerInterface $entityManager;
    private UuidFactory $uuidFactory;

    public function __construct(
        OrderRepository        $orderRepository,
        EntityManagerInterface $entityManager,
        UuidFactory            $uuidFactory
    )
    {
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
        $this->uuidFactory = $uuidFactory;
    }

    public function getOrders(): array
    {
        return $this->orderRepository
            ->createQueryBuilder('anOrder')
            ->innerJoin('anOrder.product', 'product')
            ->getQuery()
            ->getResult();
    }

    public function getOrderById(string $id): ?Order
    {
        return $this->orderRepository
            ->createQueryBuilder('order')
            ->where('order.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function create(OrderCreateDTO $dto): Order
    {
        $product = $this->entityManager->getReference(
            Product::class,
            $dto->getProductId()
        );

        $order = new Order(
            $this->uuidFactory->timeBased()->create()->toRfc4122(),
            $product,
            $dto->getCustomerName(),
            $dto->getQuantity(),
        );

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $order;
    }
}
