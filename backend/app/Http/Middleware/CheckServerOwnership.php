<?php

namespace App\Http\Middleware;

use App\Models\Server\Server;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class CheckServerOwnership
{
    public function handle(Request $request, Closure $next, string $parameter = 'server'): Response
    {
        $server = $request->route($parameter);

        if ($server instanceof Server && $server->user_id !== $request->user()?->id) {
            return response()->json(['message' => 'Forbidden: You do not own this server.'], 403);
        }

        return $next($request);
    }
}
