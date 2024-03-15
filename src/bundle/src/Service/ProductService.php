<?php

declare(strict_types=1);

namespace Product\Service;

use Doctrine\ORM\EntityManagerInterface;
use Product\DTOs\ProductCreateDTO;
use Product\Entity\Product;
use Product\Message\ProductCreatedMessage;
use Product\Repository\ProductRepository;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Factory\UuidFactory;

class ProductService
{
    private ProductRepository $productRepository;
    private UuidFactory $uuidFactory;
    private EntityManagerInterface $entityManager;
    private MessageBusInterface $messageBus;

    public function __construct(
        ProductRepository      $productRepository,
        UuidFactory            $uuidFactory,
        EntityManagerInterface $entityManager,
        MessageBusInterface    $messageBus
    )
    {
        $this->productRepository = $productRepository;
        $this->uuidFactory = $uuidFactory;
        $this->entityManager = $entityManager;
        $this->messageBus = $messageBus;
    }

    public function getProducts(): array
    {
        return $this->productRepository
            ->createQueryBuilder('product')
            ->getQuery()
            ->getResult();
    }

    public function getProductById(string $id): ?Product
    {
        return $this->productRepository->createQueryBuilder('product')
            ->where('product.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function create(ProductCreateDTO|ProductCreatedMessage $payload): Product
    {
        if ($payload instanceof ProductCreatedMessage) {
            $product = new Product(
                $payload->getId(),
                $payload->getName(),
                $payload->getPrice(),
                $payload->getQuantity()
            );
        } else {
            $product = new Product(
                $this->uuidFactory->timeBased()->create()->toRfc4122(),
                $payload->getName(),
                $payload->getPrice(),
                $payload->getQuantity()
            );
        }

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        if ($payload instanceof ProductCreateDTO) {
            $this->messageBus->dispatch(
                new ProductCreatedMessage(
                    $product->getId(),
                    $product->getName(),
                    $product->getPrice(),
                    $product->getQuantity()
                )
            );
        }
        return $product;
    }
}
