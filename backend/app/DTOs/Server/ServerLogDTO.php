<?php

namespace App\DTOs\Server;

use Illuminate\Http\Request;

final readonly class ServerLogDTO
{
    public function __construct(
        public int $serverId,
        public string $level,
        public string $message
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            serverId: $request->user()->id,
            level: $request->validated('level'),
            message: $request->validated('message')
        );
    }
}
