<?php

namespace App\Services\Server;

use App\DTOs\Server\ServerLogDTO;
use App\DTOs\Server\ServerMetricDTO;
use App\DTOs\Server\ServerRegistrationDTO;
use App\Events\Server\ServerMetricUpdated;
use App\Repositories\Server\ServerRepositoryInterface;

interface ServerServiceInterface
{
    public function registerServer(ServerRegistrationDTO $dto): array;
    public function recordServerMetrics(ServerMetricDTO $dto): void;
    public function recordServerLog(ServerLogDTO $dto): void;
    public function cleanupMetrics(int $retentionDays): int;
    public function cleanupLogs(int $retentionDays): int;
    public function getServersForUser(int $userId);
    public function getServerMetrics(int $serverId, int $hours = 24);
    public function getServerLogs(int $serverId, int $limit = 100);
}

final class ServerService implements ServerServiceInterface
{
    public function __construct(
        private ServerRepositoryInterface $serverRepository
    ) {}

    public function registerServer(ServerRegistrationDTO $dto): array
    {
        $serverRecord = $this->serverRepository->create($dto);
        $agentAccessToken = $serverRecord->createToken('AgentAccess')->accessToken;

        return [
            'server' => $serverRecord,
            'access_token' => $agentAccessToken,
        ];
    }

    public function recordServerMetrics(ServerMetricDTO $dto): void
    {
        $metricRecord = $this->serverRepository->recordMetric($dto);
        event(new ServerMetricUpdated($metricRecord));
    }

    public function recordServerLog(ServerLogDTO $dto): void
    {
        $this->serverRepository->recordLog($dto);
    }

    public function cleanupMetrics(int $retentionDays): int
    {
        return $this->serverRepository->pruneMetrics($retentionDays);
    }

    public function cleanupLogs(int $retentionDays): int
    {
        return $this->serverRepository->pruneLogs($retentionDays);
    }

    public function getServersForUser(int $userId)
    {
        return $this->serverRepository->getAllForUser($userId);
    }

    public function getServerMetrics(int $serverId, int $hours = 24)
    {
        return $this->serverRepository->getMetricsForServer($serverId, $hours);
    }

    public function getServerLogs(int $serverId, int $limit = 100)
    {
        return $this->serverRepository->getLogsForServer($serverId, $limit);
    }
}

