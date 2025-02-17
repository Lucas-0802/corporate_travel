<?php

namespace App\Repositories\travel_orders;

use App\Models\TravelOrder;
use Illuminate\Support\Collection;


class TravelOrdersRepository implements TravelOrdersRepositoryInterface
{
    public function create(array $data): TravelOrder
    {
        return TravelOrder::create($data);
    }

    public function findById(string $id): ?TravelOrder
    {
        return TravelOrder::find($id);
    }

    public function update(string $id, array $data): TravelOrder
    {
        $travelOrder = TravelOrder::findOrFail($id);
        $travelOrder->update($data);
        return $travelOrder;
    }

    public function delete(string $id): bool
    {
        return TravelOrder::where('id', $id)->delete() > 0;
    }

    public function listAll($filters, string $userType, string $userId): Collection
    {   
        $query = TravelOrder::query()->with(['user', 'status']);
    
        if ($userType === 'common') {
            $query->where('user_id', $userId);
        }
    
        if (isset($filters['status_id'])) {
            $query->where('status_id', $filters['status_id']);
        }
    
        if (isset($filters['destination'])) {
            $query->where('destination', 'LIKE', "%{$filters['destination']}%");
        }
    
        if (isset($filters['origin'])) {
            $query->where('origin', 'LIKE', "%{$filters['origin']}%");
        }
    
        if (isset($filters['date_from']) && isset($filters['date_to'])) {
            $query->whereBetween('departure_date', [$filters['date_from'], $filters['date_to']]);
        }
  
        $query->orderBy('created_at', 'desc');
    
        return $query->get();
    }
    

    public function updateStatus(string $id, int $status): TravelOrder
    {
        $travelOrder = TravelOrder::findOrFail($id);
        $travelOrder->update(['status_id' => $status]);

        return $travelOrder;
    }

    public function getTravelOrderStatistics(string $userType, string $userId = null): array
    {
        $query = TravelOrder::query();

        if ($userType === 'common' && $userId) {
            $query->where('user_id', $userId);
        }

        $totalTrips = $query->count();

        $totals = $query->selectRaw('status_id, COUNT(*) as total')
            ->whereIn('status_id', [1, 2, 3])
            ->groupBy('status_id')
            ->pluck('total', 'status_id')
            ->toArray();

        return [
            'total_trips' => $totalTrips,
            'status_counts' => $totals
        ];
    }
}
