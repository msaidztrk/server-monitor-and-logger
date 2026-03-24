<?php

namespace Database\Factories\Server;

use App\Models\Server\Server;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Server\Server>
 */
class ServerFactory extends Factory
{
    protected $model = Server::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'name'         => fake()->domainName(),
            'ip_address'   => fake()->ipv4(),
            'api_token'    => Str::random(64),
            'status'       => fake()->randomElement(['online', 'offline']),
            'last_seen_at' => now(),
        ];
    }
}
