<?php

namespace App\Console\Commands\Server;

use App\Services\Server\ServerServiceInterface;
use Illuminate\Console\Command;

final class PruneMetricsCommand extends Command
{

    protected $signature = 'metrics:prune {--days=7 : Retention period in days}';

    protected $description = 'Delete stale server metrics from the database';

    public function handle(ServerServiceInterface $serverService): int
    {
        $days = (int) $this->option('days');
        $this->info("Pruning metrics older than {$days} days...");

        $deletedCount = $serverService->cleanupMetrics($days);

        $this->info("Successfully deleted {$deletedCount} metrics.");

        return Command::SUCCESS;
    }
}
