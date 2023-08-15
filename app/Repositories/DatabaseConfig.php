<?php

namespace App\Repositories;

use App\Models\Database;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseConfig
{
    public static function addTenantDatabaseConnectionConfig(Database $database): void
    {
        $defaultDatabaseConnectionConfig = config('tenancy.default_database');

        $newConnection = $database->only(['host', 'username', 'password', 'database']);
        $newConnection['driver'] = $defaultDatabaseConnectionConfig['driver'];
        $newConnection['port'] = $defaultDatabaseConnectionConfig['port'];

        $connections = config('database.connections');
        $connections[$database->database] = $newConnection;
        config(['database.connections' => $connections]);

    }

    public static function getDatabaseConnectionsDynamically(): array
    {
        $mysqlConnection = self::getDefaultConnection();

        $connections['mysql'] = $mysqlConnection;
        config(['database.connections' => $connections]);

        $tenantsConnections = self::getTenantsDatabaseConnections();
        $connections = array_merge($connections, $tenantsConnections);

        return $connections;
    }

    public static function getTenantsDatabaseConnections(): array
    {
        $defaultDatabaseConnectionConfig = config('tenancy.default_database');

        $connections = (new DatabaseRepository())->getAll()->map(function ($database) use ($defaultDatabaseConnectionConfig) {
            return [
                'driver'    => $defaultDatabaseConnectionConfig['driver'],
                'host'      => $database->host,
                'port'      => $defaultDatabaseConnectionConfig['port'],
                'username'  => $database->username,
                'password'  => $database->password,
                'database'  => $database->database,
            ];
        })->keyBy('database')->toArray();

        return $connections;
    }

    public static function setTenantConnection(Database $database): void
    {
        $defaultDatabaseConnectionConfig = config('tenancy.default_database');

        $connection = $database->only(['host', 'username', 'password', 'database']);
        $connection['driver'] = $defaultDatabaseConnectionConfig['driver'];
        $connection['port'] = $defaultDatabaseConnectionConfig['port'];

        config(["database.connections.{$database->database}" => $connection]);
    }

    public static function setDefaultConnection($connectionName): void
    {
        config(['database.default' => $connectionName]);
    }

    public static function generateTenantDatabaseName($tenantName): string
    {
        $slug = Str::slug($tenantName, '_');
        return $slug . '_db';
    }

    private static function getDefaultConnection(): array
    {
        return self::getMysqlConnection();
    }

    private static function getMysqlConnection(): array
    {
        return [
            'driver'            => 'mysql',
            'url'               => env('DATABASE_URL'),
            'host'              => env('DB_HOST', '127.0.0.1'),
            'port'              => env('DB_PORT', '3306'),
            'database'          => env('DB_DATABASE', 'forge'),
            'username'          => env('DB_USERNAME', 'forge'),
            'password'          => env('DB_PASSWORD', ''),
            'unix_socket'       => env('DB_SOCKET', ''),
            'charset'           => 'utf8mb4',
            'collation'         => 'utf8mb4_unicode_ci',
            'prefix'            => '',
            'prefix_indexes'    => true,
            'strict'            => true,
            'engine'            => null,
        ];
    }
}
