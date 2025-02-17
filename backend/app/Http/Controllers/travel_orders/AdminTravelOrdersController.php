<?php

namespace App\Http\Controllers\travel_orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\travel_orders\ListFiltersRequest;
use App\Http\Requests\travel_orders\UpdateOrderStatusRequest;
use App\Services\travel_orders\TravelOrdersService;
use Illuminate\Http\JsonResponse;

class AdminTravelOrdersController extends Controller
{
    private $travelOrderService;

    public function __construct(TravelOrdersService $travelOrderService)
    {
        $this->travelOrderService = $travelOrderService;
    }

    public function list(ListFiltersRequest $request): JsonResponse
    {
        $orders = $this->travelOrderService->listAll($request->all());
        return response()->json(['orders' => $orders]);
    }


    public function updateStatus(string $id, UpdateOrderStatusRequest $request): JsonResponse
    {
        $response = $this->travelOrderService->updateStatus($id, $request->all());
        return response()->json($response, $response['status']);
    }
}
