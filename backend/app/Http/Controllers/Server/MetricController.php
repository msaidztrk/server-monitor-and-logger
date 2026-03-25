<?php

namespace App\Http\Controllers\Server;

use App\DTOs\Server\ServerMetricDTO;
use App\Http\Controllers\Controller;
use App\Services\Server\ServerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class MetricController extends Controller
{
    public function __construct(
        private ServerServiceInterface $serverService
    ) {}

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'cpu_usage' => 'required|numeric|min:0|max:100',
            'ram_usage' => 'required|numeric|min:0|max:100',
            'disk_usage' => 'required|numeric|min:0|max:100',
        ]);

        $metricData = ServerMetricDTO::fromRequest($request);
        $this->serverService->recordServerMetrics($metricData);

        return response()->json(['status' => 'Metric recorded'], 201);
    }
}
