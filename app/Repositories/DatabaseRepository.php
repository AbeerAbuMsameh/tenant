<?php

namespace App\Repositories;

use App\Models\Database;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DatabaseRepository
{
    public function createNewOrFindDatabase ($data): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        return Database::query()->firstOrCreate($data);
    }

    public function createOrFindDefaultLocalDatabase ($databaseName): Database
    {
        $databaseConfig = collect(config('tenancy.default_database'))
            ->only(['host', 'username', 'password'])->toArray();
        $databaseConfig['database'] = $databaseName;

        $database = Database::query()->where('database', $databaseName)->first();

        if (!$database) {
            $database = Database::query()->create($databaseConfig);
        }

        return $database;
    }

    public function getAll ()
    {
        return Database::query()->get();
    }

    public function getById ($id): Database
    {
        return Database::query()->find($id);
    }

    public function generateCreateDatabaseDDL ($databaseName): void
    {

        DB::statement("CREATE DATABASE IF NOT EXISTS $databaseName");
    }

    public function migrateTenantDatabase (): void
    {
        Artisan::call('migrate', ['--path' => '/database/migrations/Tenancy']);
    }
}
