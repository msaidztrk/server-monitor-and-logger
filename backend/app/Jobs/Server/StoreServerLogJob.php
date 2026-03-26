<?php

namespace App\Jobs\Server;

use App\DTOs\Server\ServerLogDTO;
use App\Services\Server\ServerServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

final class StoreServerLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 20;

    public function __construct(
        private readonly ServerLogDTO $logData
    ) {}

    public function handle(ServerServiceInterface $serverService): void
    {
        $serverService->recordServerLog($this->logData);
    }

    public function failed(Throwable $exception): void
    {
        // Error handling logic
    }
}
