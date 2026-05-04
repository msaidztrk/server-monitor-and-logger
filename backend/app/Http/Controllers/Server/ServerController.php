<?php

namespace App\Http\Controllers\Server;

use App\DTOs\Server\ServerRegistrationDTO;
use App\Http\Controllers\Controller;
use App\Http\Resources\Server\ServerResource;
use App\Models\Server\Server;
use App\Services\Server\ServerServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final class ServerController extends Controller
{
    public function __construct(
        private ServerServiceInterface $serverService
    ) {}

    public function index(): JsonResponse
    {
        $servers = $this->serverService->getServersForUser(auth()->id());

        return response()->json(ServerResource::collection($servers));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'nullable|string|max:45',
        ]);

        $serverRegistrationData = ServerRegistrationDTO::fromRequest($request);
        $registrationResult = $this->serverService->registerServer($serverRegistrationData);

        return response()->json([
            'message' => 'Server registered successfully.',
            'server' => $registrationResult['server'],
            'access_token' => $registrationResult['access_token'],
        ], 201);
    }
}
