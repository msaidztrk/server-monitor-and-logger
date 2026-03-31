<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('server.{serverId}', function ($user, int $serverId) {
    return $user->servers()->where('id', $serverId)->exists();
});
