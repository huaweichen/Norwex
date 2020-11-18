<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => function () {
                return Customer::all()
                    ->pluck('customer_id')
                    ->random();
            },
            'order_status' => $this->faker->randomElement([
                Order::COMPLETED,
                Order::INCOMPLETE
            ]),
            'order_total' => $this->faker->numberBetween(10, 250),
            'created_date_time' => $this->faker->dateTimeInInterval('-18 months', '+1 month'),
        ];
    }

    /**
     * Define COMPLETED Order.
     *
     * @return OrderFactory
     */
    public function completed(): OrderFactory
    {
        return $this->state(function () {
            return [
                'order_status' => Order::COMPLETED,
            ];
        });
    }

    /**
     * Define INCOMPLETE Order.
     *
     * @return OrderFactory
     */
    public function incomplete(): OrderFactory
    {
        return $this->state(function () {
            return [
                'order_status' => Order::INCOMPLETE,
            ];
        });
    }


    /**
     * Define WITHIN amount of months.
     *
     * @return OrderFactory
     */
    public function withInMonth(array $attributes): OrderFactory
    {
        return $this->state(function () use ($attributes) {
            return [
                'created_date_time' => $this->faker
                    ->dateTimeInInterval('-' . $attributes['month'] . ' months', '+1 month'),
            ];
        });
    }
}
