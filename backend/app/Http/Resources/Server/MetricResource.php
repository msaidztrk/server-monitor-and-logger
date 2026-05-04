<?php

namespace App\Http\Resources\Server;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class MetricResource extends JsonResource
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
            'cpu_usage' => $this->cpu_usage,
            'ram_usage' => $this->ram_usage,
            'disk_usage' => $this->disk_usage,
            'created_at' => $this->created_at->toDateTimeString(),
            'timestamp' => $this->created_at->timestamp,
        ];
    }
}
