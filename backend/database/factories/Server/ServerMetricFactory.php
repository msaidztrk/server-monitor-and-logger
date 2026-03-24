<?php

namespace Database\Factories\Server;

use App\Models\Server\Server;
use App\Models\Server\ServerMetric;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Server\ServerMetric>
 */
class ServerMetricFactory extends Factory
{
    protected $model = ServerMetric::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'server_id'   => Server::factory(),
            'cpu_usage'   => fake()->randomFloat(2, 0, 100),
            'ram_usage'   => fake()->randomFloat(2, 0, 100),
            'disk_usage'  => fake()->randomFloat(2, 0, 100),
            'created_at'  => now(),
        ];
    }
}
