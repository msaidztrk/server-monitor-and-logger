<?php

namespace App\Console\Commands\Server;

use App\Services\Server\ServerServiceInterface;
use Illuminate\Console\Command;

final class PruneLogsCommand extends Command
{
    protected $signature = 'logs:prune {--days=30 : Retention period in days}';

    protected $description = 'Delete stale server logs from the database';

    public function handle(ServerServiceInterface $serverService): int
    {
        $days = (int) $this->option('days');
        $this->info("Pruning logs older than {$days} days...");

        $deletedCount = $serverService->cleanupLogs($days);

        $this->info("Successfully deleted {$deletedCount} logs.");

        return Command::SUCCESS;
    }
}
