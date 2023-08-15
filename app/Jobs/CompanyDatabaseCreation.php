<?php

namespace App\Jobs;

use App\Repositories\DatabaseRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CompanyDatabaseCreation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name;
    protected $databaseRepository;

    public function __construct($name)
    {
        $this->name = $name;
        $this->databaseRepository = new DatabaseRepository();
    }

    public function handle() {
        # create database
        $this->databaseRepository->generateCreateDatabaseDDL($this->name);

        DB::setDefaultConnection($this->name);

        # migration
        $this->databaseRepository->migrateTenantDatabase();
//        Artisan::call('migrate', ['--path' => '/database/migrations/Tenancy']);

        DB::setDefaultConnection('mysql');
    }
}
