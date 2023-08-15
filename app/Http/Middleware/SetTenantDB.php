<?php

namespace App\Http\Middleware;

use App\Repositories\DatabaseConfig;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetTenantDB
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user->level == 2) {
            $database = $user->company->database;
            DatabaseConfig::setTenantConnection($database);
            DatabaseConfig::setDefaultConnection($database->database);
            DB::setDefaultConnection($database->database);
        }

        return $next($request);
    }
}
