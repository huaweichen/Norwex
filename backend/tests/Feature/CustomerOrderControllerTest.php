<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\CustomerStatus;
use App\Models\Order;
use Database\Seeders\CustomerStatusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CustomerOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $seeder = new CustomerStatusSeeder();
        $seeder->run();
    }

    /**
     * Test endpoint availability.
     *
     * @return void
     */
    public function testCustomerOrderEndpointCanHandleGetMethod()
    {
        $response = $this->get('/api/customers');

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test endpoint availability.
     *
     * @return void
     */
    public function testCustomerOrderEndpointOtherMethodNotWorking()
    {
        $response = $this->post('/api/customers');

        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * Test one active user has not placed any order for more than 12 months.
     */
    public function testOneActiveUserHaveNotPlacedAnyOrderForMoreThan12Months()
    {
        $customer = Customer::factory()->active()->create();
        Order::factory()->withInMonth(['month' => 24])->create([
            'customer_id' => $customer->getKey()
        ]);

        $response = $this->get('/api/customers');
        $data = $response->decodeResponseJson();

        self::assertCount(1, $data['data']);
        self::assertEquals('orange', $data['data'][0]['display_color']);
    }

    /**
     * Test one removed user has not placed any order for more than 12 months.
     */
    public function testOneRemovedUserHaveNotPlacedAnyOrderForMoreThan12Months()
    {
        $customer = Customer::factory()->removed()->create();
        Order::factory()->withInMonth(['month' => 24])->create([
            'customer_id' => $customer->getKey()
        ]);

        $response = $this->get('/api/customers');
        $data = $response->decodeResponseJson();

        self::assertCount(1, $data['data']);
        self::assertEquals('red', $data['data'][0]['display_color']);
    }

    /**
     * Test one removed user has not placed any order for more than 12 months.
     */
    public function testOneActiveUserHavePlacedOneCompletedOrderLastMonth()
    {
        $customer = Customer::factory()->active()->create();
        Order::factory()->withInMonth(['month' => 1])->completed()->create([
            'customer_id' => $customer->getKey(),
            'order_total' => 300
        ]);

        $response = $this->get('/api/customers');
        $data = $response->decodeResponseJson();

        self::assertCount(1, $data['data']);
        self::assertEquals('green', $data['data'][0]['display_color']);
    }
}
