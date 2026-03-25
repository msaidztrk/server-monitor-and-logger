<?php

namespace App\Http\Controllers\Server;

use App\DTOs\Server\ServerLogDTO;
use App\Http\Controllers\Controller;
use App\Services\Server\ServerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogController extends Controller
{
    public function __construct(
        private ServerServiceInterface $serverService
    ) {}

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'level' => 'required|string|in:debug,info,warning,error,critical',
            'message' => 'required|string',
        ]);

        $logData = ServerLogDTO::fromRequest($request);
        $this->serverService->recordServerLog($logData);

        return response()->json(['status' => 'Log recorded'], 201);
    }
}
