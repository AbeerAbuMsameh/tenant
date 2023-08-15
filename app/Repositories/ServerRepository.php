<?php

namespace App\Repositories;

use App\Models\Server;

class ServerRepository
{
    public function createNewOrFindServer ($data): Server
    {
        return Server::query()->firstOrCreate($data);
    }

    public function getDefaultLocalServer (): Server
    {
        $defaultSeverConfig = config('tenancy.default_server');
        return Server::query()->firstOrCreate($defaultSeverConfig);
    }
}
