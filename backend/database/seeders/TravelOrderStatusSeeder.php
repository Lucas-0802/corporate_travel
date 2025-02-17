<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TravelOrderStatus;

class TravelOrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status_name = ['solicitado', 'aprovado', 'cancelado'];

        foreach ($status_name as $status) {
            TravelOrderStatus::create(['name' => $status]);
        }
    }
}
