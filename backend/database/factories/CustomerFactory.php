<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_status_id' => function () {
                return CustomerStatus::all()
                    ->pluck('customer_status_id')
                    ->random();
            },
            'name' => $this->faker->name,
        ];
    }

    /**
     * Define an ACTIVE customer.
     *
     * @return CustomerFactory
     */
    public function active(): CustomerFactory
    {
        return $this->state(function () {
            return [
                'customer_status_id' => function () {
                    return CustomerStatus::where('code', '=', CustomerStatus::ACTIVE)
                        ->first()
                        ->getKey();
                }
            ];
        });
    }

    /**
     * Define an REMOVED customer.
     *
     * @return CustomerFactory
     */
    public function removed(): CustomerFactory
    {
        return $this->state(function () {
            return [
                'customer_status_id' => function () {
                    return CustomerStatus::where('code', '=', CustomerStatus::REMOVED)
                        ->first()
                        ->getKey();
                }
            ];
        });
    }
}
