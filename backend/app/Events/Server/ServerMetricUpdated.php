<?php

namespace App\Events\Server;

use App\Models\Server\ServerMetric;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class ServerMetricUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly ServerMetric $serverMetric
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('server.' . $this->serverMetric->server_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'metric.updated';
    }
}
