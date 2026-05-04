<?php

namespace App\Policies\Server;

use App\Models\Server\Server;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ServerPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Server $server): bool
    {
        return $user->id === $server->user_id;
    }

    public function update(User $user, Server $server): bool
    {
        return $user->id === $server->user_id;
    }

    public function delete(User $user, Server $server): bool
    {
        return $user->id === $server->user_id;
    }
}
