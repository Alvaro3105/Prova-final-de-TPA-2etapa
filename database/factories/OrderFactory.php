<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Order> */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'cliente' => fake()->name(),
            'status' => 'pendente',
            'codigo_pedido' => fake()->unique()->bothify('PED-#####'),
            'total' => fake()->numberBetween(0, 10000),
        ];
    }
}
