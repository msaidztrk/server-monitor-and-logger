<?php

namespace App\Repositories\Server;

use App\DTOs\Server\ServerLogDTO;
use App\DTOs\Server\ServerMetricDTO;
use App\DTOs\Server\ServerRegistrationDTO;
use App\Models\Server\Server;
use App\Models\Server\ServerMetric;

interface ServerRepositoryInterface
{
    public function create(ServerRegistrationDTO $serverData): Server;
    public function recordMetric(ServerMetricDTO $metricData): ServerMetric;
    public function recordLog(ServerLogDTO $logData): void;
    public function pruneMetrics(int $retentionDays): int;
    public function getAllForUser(int $userId);
    public function getMetricsForServer(int $serverId, int $hours = 24);
    public function getLogsForServer(int $serverId, int $limit = 100);
    public function updateLastSeen(int $serverId): void;
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

    public function recordMetric(ServerMetricDTO $metricData): ServerMetric
    {
        $server = Server::findOrFail($metricData->serverId);
        $this->updateLastSeen($server->id);

        return $server->metrics()->create([
            'cpu_usage' => $metricData->cpuUsage,
            'ram_usage' => $metricData->ramUsage,
            'disk_usage' => $metricData->diskUsage,
            'created_at' => now(),
        ]);
    }

    public function recordLog(ServerLogDTO $logData): void
    {
        $server = Server::findOrFail($logData->serverId);
        $this->updateLastSeen($server->id);

        $server->logs()->create([
            'level' => $logData->level,
            'message' => $logData->message,
            'created_at' => now(),
        ]);
    }

    public function pruneMetrics(int $retentionDays): int
    {
        return ServerMetric::where('created_at', '<', now()->subDays($retentionDays))->delete();
    }

    public function getAllForUser(int $userId)
    {
        return Server::where('user_id', $userId)->get();
    }

    public function getMetricsForServer(int $serverId, int $hours = 24)
    {
        return Server::findOrFail($serverId)
            ->metrics()
            ->where('created_at', '>=', now()->subHours($hours))
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getLogsForServer(int $serverId, int $limit = 100)
    {
        return Server::findOrFail($serverId)
            ->logs()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function updateLastSeen(int $serverId): void
    {
        Server::where('id', $serverId)->update([
            'last_seen_at' => now(),
            'status' => 'online'
        ]);
    }
}

