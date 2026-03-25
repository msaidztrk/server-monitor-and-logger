<?php

namespace App\DTOs\Server;

use Illuminate\Http\Request;

final readonly class ServerMetricDTO
{
    public function __construct(
        public int $serverId,
        public float $cpuUsage,
        public float $ramUsage,
        public float $diskUsage
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            serverId: $request->user()->id,
            cpuUsage: (float) $request->validated('cpu_usage'),
            ramUsage: (float) $request->validated('ram_usage'),
            diskUsage: (float) $request->validated('disk_usage')
        );
    }
}
