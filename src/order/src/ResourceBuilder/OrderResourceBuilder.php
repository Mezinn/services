<?php

declare(strict_types=1);

namespace App\ResourceBuilder;

use App\Entity\Order;
use Product\ResourceBuilder\ProductResourceBuilder;

class OrderResourceBuilder
{
    private ProductResourceBuilder $productResourceBuilder;

    private array $callables;

    public function __construct(
        ProductResourceBuilder $productResourceBuilder
    )
    {
        $this->productResourceBuilder = $productResourceBuilder;
        $this->callables = [];
        $this->reset();
    }

    public function id(): self
    {
        $this->callables[] = function (Order $order): array {
            return ['id', $order->getId()];
        };

        return $this;
    }

    public function product(): self
    {
        $this->callables[] = function (Order $order): array {
            return [
                'product',
                $this->productResourceBuilder->build(
                    $order->getProduct()
                )
            ];
        };

        return $this;
    }

    public function customerName(): self
    {
        $this->callables[] = function (Order $order): array {
            return ['customerName', $order->getCustomerName()];
        };

        return $this;
    }

    public function quantity(): self
    {
        $this->callables[] = function (Order $order): array {
            return ['customerName', (string)$order->getQuantity()];
        };

        return $this;
    }

    public function build(Order $order): array
    {
        $result = [];
        foreach ($this->callables as $callable) {
            [$key, $value] = $callable($order);
            $result[$key] = $value;
        }
        return $result;
    }

    public function reset(): void
    {
        $this->productResourceBuilder->reset();

        $this
            ->id()
            ->product()
            ->customerName()
            ->quantity()
            ->quantity();
    }
}
