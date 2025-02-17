<?php

namespace App\Services\travel_orders;

use App\Repositories\travel_orders\TravelOrdersRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class TravelOrdersService
{
    private $travelOrdersRepository;

    public function __construct(TravelOrdersRepositoryInterface $travelOrdersRepository)
    {
        $this->travelOrdersRepository = $travelOrdersRepository;
    }

    public function create($data): array
    {
        try {
            $data['user_id'] = Auth::id();
            $order = $this->travelOrdersRepository->create($data);

            return [
                'message' => 'travel_order_created_successfully',
                'status' => 201,
                'order' => $order
            ];
        } catch (Exception $e) {
            Log::error('error_creating_travel_order: ' . $e->getMessage());
            throw new Exception('unable_to_create_travel_order');
        }
    }

    public function update(array $data, string $id): array
    {
        try {
            $order = $this->travelOrdersRepository->update($id, $data);

            return [
                'message' => 'travel_order_updated_successfully',
                'status' => 200,
                'order' => $order
            ];
        } catch (Exception $e) {
            Log::error('error_updating_travel_order: ' . $e->getMessage());
            throw new Exception('unable_to_update_travel_order');
        }
    }

    public function delete($request): array
    {
        try {
            $this->travelOrdersRepository->delete($request['id']);
            return [
                'message' => 'travel_order_deleted',
                'status' => 200
            ];
        } catch (Exception $e) {
            Log::error('error_to_delete_travel_order ' . $e->getMessage());
            throw new Exception('the_travel_request_could_not_be_deleted');
        }
    }

    public function listAll($filters): array
    {
        try {
            $userType = Auth::user()->user_type;
            $userId = Auth::id();
            return $this->travelOrdersRepository->listAll($filters, $userType, $userId)->toArray();
        } catch (\Throwable $th) {
            Log::error('error_listing_travel_orders: ' . $th->getMessage());
            throw new Exception('unable_to_list_travel_orders');
        }
    }

    public function updateStatus(string $id, array $data): array
    {
        try {
            $order = $this->travelOrdersRepository->update($id, $data);

            return [
                'message' => "status_updated_successfully",
                'status' => 200,
                'order' => $order
            ];
        } catch (\Throwable $th) {
            Log::error('error_updating_travel_order_status: ' . $th->getMessage());
            throw new Exception('unable_to_update_travel_order_status');
        }
    }

    public function getStatistics(): array
    {
        try {
            $userType = Auth::user()->user_type;
            $userId = Auth::id();
            return $this->travelOrdersRepository->getTravelOrderStatistics($userType, $userId);
        } catch (\Throwable $th) {
            Log::error('error_getting_travel_order_statistics: ' . $th->getMessage());
            throw new Exception('unable_to_get_travel_order_statistics');
        }
    }
}
