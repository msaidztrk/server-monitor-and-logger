<?php

namespace App\Http\Resources\Server;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ServerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ip_address' => $this->ip_address,
            'status' => $this->status,
            'last_seen_at' => $this->last_seen_at?->toDateTimeString(),
            'is_online' => $this->last_seen_at?->diffInMinutes() < 5,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
