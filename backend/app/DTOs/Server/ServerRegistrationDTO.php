<?php

namespace App\DTOs\Server;

use Illuminate\Http\Request;

final readonly class ServerRegistrationDTO
{
    public function __construct(
        public string $name,
        public ?string $ipAddress,
        public int $userId
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            name: $request->validated('name'),
            ipAddress: $request->validated('ip_address') ?? $request->ip(),
            userId: $request->user()->id
        );
    }
}
