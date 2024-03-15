<?php

declare(strict_types=1);

namespace Product\ResourceBuilder;

use Product\Entity\Product;

class ProductResourceBuilder
{
    /** @var callable<string, string>[] */
    private array $callables;

    public function __construct()
    {
        $this->callables = [];
        $this->reset();
    }

    public function id(): self
    {
        $this->callables[] = function (Product $product): array {
            return ['id', (string)$product->getId()];
        };

        return $this;
    }

    public function name(): self
    {
        $this->callables[] = function (Product $product): array {
            return ['name', (string)$product->getName()];
        };

        return $this;
    }

    public function price(): self
    {
        $this->callables[] = function (Product $product): array {
            return ['price', (string)$product->getPrice()];
        };

        return $this;
    }

    public function quantity(): self
    {
        $this->callables[] = function (Product $product): array {
            return ['quantity', (string)$product->getQuantity()];
        };

        return $this;
    }

    public function build(Product $product): array
    {
        $result = [];
        foreach ($this->callables as $callable) {
            [$key, $value] = $callable($product);
            $result[$key] = $value;
        }
        return $result;
    }

    public function reset(): void
    {
        $this
            ->id()
            ->name()
            ->price()
            ->quantity();
    }
}
