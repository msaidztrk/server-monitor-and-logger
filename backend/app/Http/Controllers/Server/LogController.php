<?php

namespace App\Http\Controllers\Server;

use App\DTOs\Server\ServerLogDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Server\StoreLogRequest;
use App\Http\Resources\Server\LogResource;
use App\Jobs\Server\StoreServerLogJob;
use App\Models\Server\Server;
use App\Services\Server\ServerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogController extends Controller
{
    public function __construct(
        private ServerServiceInterface $serverService
    ) {}

    public function index(Server $server): JsonResponse
    {
        $logs = $this->serverService->getServerLogs($server->id);

        return response()->json(LogResource::collection($logs));
    }

    public function store(StoreLogRequest $request): JsonResponse
    {
        $logData = ServerLogDTO::fromRequest($request);
        StoreServerLogJob::dispatch($logData);

        return response()->json(['status' => 'Log accepted'], 202);
    }
}
