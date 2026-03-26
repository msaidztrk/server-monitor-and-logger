<?php

namespace App\Http\Controllers\Server;

use App\DTOs\Server\ServerLogDTO;
use App\Http\Controllers\Controller;
use App\Jobs\Server\StoreServerLogJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'level' => 'required|string|in:debug,info,warning,error,critical',
            'message' => 'required|string',
        ]);

        $logData = ServerLogDTO::fromRequest($request);
        StoreServerLogJob::dispatch($logData);

        return response()->json(['status' => 'Log accepted'], 202);
    }
}
