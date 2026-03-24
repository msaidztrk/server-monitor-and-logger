<?php

namespace App\Models\Server;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'ip_address',
        'api_token',
        'status',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function metrics()
    {
        return $this->hasMany(ServerMetric::class);
    }

    public function logs()
    {
        return $this->hasMany(ServerLog::class);
    }
}
