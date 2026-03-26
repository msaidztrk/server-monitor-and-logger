<?php

namespace App\Jobs\Server;

use App\DTOs\Server\ServerMetricDTO;
use App\Services\Server\ServerServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

final class StoreServerMetricJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 30;

    public function __construct(
        private readonly ServerMetricDTO $metricData
    ) {}

    public function handle(ServerServiceInterface $serverService): void
    {
        $serverService->recordServerMetrics($this->metricData);
    }

    public function failed(Throwable $exception): void
    {
        // Error handling logic
    }
}
