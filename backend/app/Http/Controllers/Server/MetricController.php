<?php

namespace App\Http\Controllers\Server;

use App\DTOs\Server\ServerMetricDTO;
use App\Http\Controllers\Controller;
use App\Jobs\Server\StoreServerMetricJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class MetricController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'cpu_usage' => 'required|numeric|min:0|max:100',
            'ram_usage' => 'required|numeric|min:0|max:100',
            'disk_usage' => 'required|numeric|min:0|max:100',
        ]);

        $metricData = ServerMetricDTO::fromRequest($request);
        StoreServerMetricJob::dispatch($metricData);

        return response()->json(['status' => 'Metric accepted'], 202);
    }
}
