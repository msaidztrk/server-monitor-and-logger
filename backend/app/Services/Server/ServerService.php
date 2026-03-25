<?php

namespace App\Services\Server;

use App\DTOs\Server\ServerLogDTO;
use App\DTOs\Server\ServerMetricDTO;
use App\DTOs\Server\ServerRegistrationDTO;
use App\Repositories\Server\ServerRepositoryInterface;

interface ServerServiceInterface
{
    public function registerServer(ServerRegistrationDTO $dto): array;
    public function recordServerMetrics(ServerMetricDTO $dto): void;
    public function recordServerLog(ServerLogDTO $dto): void;
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
        $this->serverRepository->recordMetric($dto);
    }

    public function recordServerLog(ServerLogDTO $dto): void
    {
        $this->serverRepository->recordLog($dto);
    }
}
