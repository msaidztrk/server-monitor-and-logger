<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerMetric extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'server_id',
        'cpu_usage',
        'ram_usage',
        'disk_usage',
        'created_at',
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
