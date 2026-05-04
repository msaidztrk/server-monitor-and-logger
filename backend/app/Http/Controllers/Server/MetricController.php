<?php

namespace App\Http\Controllers\Server;

use App\DTOs\Server\ServerMetricDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Server\StoreMetricRequest;
use App\Http\Resources\Server\MetricResource;
use App\Jobs\Server\StoreServerMetricJob;
use App\Models\Server\Server;
use App\Services\Server\ServerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class MetricController extends Controller
{
    public function __construct(
        private ServerServiceInterface $serverService
    ) {}

    public function index(Server $server): JsonResponse
    {
        $metrics = $this->serverService->getServerMetrics($server->id);

        return response()->json(MetricResource::collection($metrics));
    }

    public function store(StoreMetricRequest $request): JsonResponse
    {
        $metricData = ServerMetricDTO::fromRequest($request);
        StoreServerMetricJob::dispatch($metricData);

        return response()->json(['status' => 'Metric accepted'], 202);
    }
}
