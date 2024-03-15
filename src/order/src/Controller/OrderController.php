<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTOs\OrderCreateDTO;
use App\ResourceBuilder\OrderResourceBuilder;
use App\Service\OrderService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class OrderController
{
    private OrderService $orderService;
    private OrderResourceBuilder $orderResourceBuilder;

    public function __construct(
        OrderService         $orderService,
        OrderResourceBuilder $orderResourceBuilder
    )
    {
        $this->orderService = $orderService;
        $this->orderResourceBuilder = $orderResourceBuilder;
    }

    #[Route("/orders", methods: "get")]
    public function orders(): Response
    {
        $orders = $this->orderService->getOrders();

        $result = [];
        foreach ($orders as $order) {
            $result[] = $this->orderResourceBuilder->build($order);
        }

        return new JsonResponse(['data' => $result]);
    }

    #[Route("/orders/{id}", methods: "get")]
    public function view(string $id): Response
    {
        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(
            $this->orderResourceBuilder->build($order)
        );
    }

    #[Route("/orders", methods: "post")]
    public function create(Request $request): Response
    {
        $dto = new OrderCreateDTO(
            (string)$request->get('productId'),
            (string)$request->get('customerName'),
            (int)$request->get('quantity'),
        );

        $order = $this->orderService->create($dto);

        return new JsonResponse(
            $this->orderResourceBuilder->build($order)
        );
    }
}
