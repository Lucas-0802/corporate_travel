<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Http\Controllers\travel_orders\TravelOrdersController;
use App\Services\travel_orders\TravelOrdersService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\travel_orders\CreateOrderRequest;
use App\Http\Requests\travel_orders\DeleteOrderRequest;

class TravelOrdersControllerTest extends TestCase
{
    protected $travelOrdersService;
    protected $travelOrdersController;

    public function setUp(): void
    {
        parent::setUp();

        $this->travelOrdersService = Mockery::mock(TravelOrdersService::class);
        $this->travelOrdersController = new TravelOrdersController($this->travelOrdersService);
    }

    /** @test */
    public function it_creates_a_travel_order_successfully()
    {
        $request = new CreateOrderRequest([
            'origin' => 'São Paulo',
            'destination' => 'Rio de Janeiro',
            'departure_date' => now()->addDays(2)->toDateString(),
            'return_date' => now()->addDays(5)->toDateString(),
        ]);

        $mockResponse = [
            'message' => 'travel_order_created_successfully',
            'status' => 201,
            'order' => (object) ['id' => 1, 'origin' => 'São Paulo']
        ];

        $this->travelOrdersService
            ->shouldReceive('create')
            ->once()
            ->with($request->all())
            ->andReturn($mockResponse);

        $response = $this->travelOrdersController->create($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /** @test */
    public function it_deletes_a_travel_order_successfully()
    {
        $request = new DeleteOrderRequest(['id' => '12345']);

        $mockResponse = [
            'message' => 'travel_order_deleted',
            'status' => 200
        ];

        $this->travelOrdersService
            ->shouldReceive('delete')
            ->once()
            ->with($request->all())
            ->andReturn($mockResponse);

        $response = $this->travelOrdersController->delete($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
