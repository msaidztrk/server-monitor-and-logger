<?php

namespace App\Repositories\Server;

use App\DTOs\Server\ServerLogDTO;
use App\DTOs\Server\ServerMetricDTO;
use App\DTOs\Server\ServerRegistrationDTO;
use App\Models\Server\Server;

interface ServerRepositoryInterface
{
    public function create(ServerRegistrationDTO $serverData): Server;
    public function recordMetric(ServerMetricDTO $metricData): void;
    public function recordLog(ServerLogDTO $logData): void;
}

final class EloquentServerRepository implements ServerRepositoryInterface
{
    public function create(ServerRegistrationDTO $serverData): Server
    {
        return Server::create([
            'user_id' => $serverData->userId,
            'name' => $serverData->name,
            'ip_address' => $serverData->ipAddress,
            'status' => 'offline',
        ]);
    }

    public function recordMetric(ServerMetricDTO $metricData): void
    {
        Server::findOrFail($metricData->serverId)->metrics()->create([
            'cpu_usage' => $metricData->cpuUsage,
            'ram_usage' => $metricData->ramUsage,
            'disk_usage' => $metricData->diskUsage,
            'created_at' => now(),
        ]);
    }

    public function recordLog(ServerLogDTO $logData): void
    {
        Server::findOrFail($logData->serverId)->logs()->create([
            'level' => $logData->level,
            'message' => $logData->message,
            'created_at' => now(),
        ]);
    }
}
