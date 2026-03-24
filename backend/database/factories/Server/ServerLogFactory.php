<?php

namespace Database\Factories\Server;

use App\Models\Server\Server;
use App\Models\Server\ServerLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Server\ServerLog>
 */
class ServerLogFactory extends Factory
{
    protected $model = ServerLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'server_id'  => Server::factory(),
            'level'      => fake()->randomElement(['info', 'warning', 'error', 'critical']),
            'message'    => fake()->sentence(),
            'created_at' => now(),
        ];
    }
}
