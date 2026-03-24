<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;

class ServerLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'server_id',
        'level',
        'message',
        'created_at',
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
