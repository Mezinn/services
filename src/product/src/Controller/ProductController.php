<?php

declare(strict_types=1);

namespace App\Controller;

use Product\DTOs\ProductCreateDTO;
use Product\ResourceBuilder\ProductResourceBuilder;
use Product\Service\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class ProductController
{
    private ProductService $productService;
    private ProductResourceBuilder $productResourceBuilder;

    public function __construct(
        ProductService         $productService,
        ProductResourceBuilder $productResourceBuilder
    )
    {
        $this->productService = $productService;
        $this->productResourceBuilder = $productResourceBuilder;
    }

    #[Route("/products", methods: "get")]
    public function products(): Response
    {
        $products = $this->productService->getProducts();

        $result = [];
        foreach ($products as $product) {
            $result[] = $this->productResourceBuilder->build($product);
        }

        return new JsonResponse(['data' => $result]);
    }

    #[Route("/products/{id}", methods: "get")]
    public function view(string $id): Response
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(
            $this->productResourceBuilder->build($product)
        );
    }

    #[Route("/products", methods: "post")]
    public function create(Request $request): Response
    {
        $dto = new ProductCreateDTO(
            (string)$request->get('name'),
            (float)$request->get('price'),
            (int)$request->get('quantity'),
        );

        $product = $this->productService->create($dto);

        return new JsonResponse(
            $this->productResourceBuilder->build($product)
        );
    }
}
