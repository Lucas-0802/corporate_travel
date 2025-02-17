<?php

namespace App\Http\Controllers\travel_orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\travel_orders\CreateOrderRequest;
use App\Http\Requests\travel_orders\DeleteOrderRequest;
use App\Http\Requests\travel_orders\ListFiltersRequest;
use App\Http\Requests\travel_orders\OrderRequest;
use App\Services\travel_orders\TravelOrdersService;
use Illuminate\Http\JsonResponse;

class TravelOrdersController extends Controller
{
    private $travelOrderService;

    public function __construct(TravelOrdersService $travelOrderService)
    {
        $this->travelOrderService = $travelOrderService;
    }

    public function create(CreateOrderRequest $request): JsonResponse
    {   
        $response = $this->travelOrderService->create($request->all());
        return response()->json($response, $response['status']);
    }

    public function list(ListFiltersRequest $request): JsonResponse
    {
        $orders = $this->travelOrderService->listAll($request->all());
        return response()->json(['orders' => $orders]);
    }

    public function update(OrderRequest $request, string $id): JsonResponse
    {
        $response = $this->travelOrderService->update($request->all(), $id);
        return response()->json($response, $response['status']);
    }

    public function delete(DeleteOrderRequest $request): JsonResponse 
    {
        $response = $this->travelOrderService->delete($request->all());
        return response()->json($response, $response['status']);
    }

    public function getStatistics(): JsonResponse
    {
        $response = $this->travelOrderService->getStatistics();
        return response()->json(['statistics' => $response]);
    }
}

