<?php

use App\Http\Controllers\AdminManagement\CompanyController;
use App\Http\Controllers\AdminManagement\PaymentPackageController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CompanyManagement\ConjunctionController;
use App\Http\Controllers\CompanyManagement\MemberController;
use App\Http\Controllers\CompanyManagement\RuleController;
use App\Http\Controllers\CompanyManagement\ServiceController;
use App\Http\Controllers\CompanyManagement\ServiceSystemController;
use App\Http\Controllers\CompanyManagement\SystemController;
use App\Http\Controllers\CompanyManagement\TeamController;
use App\Http\Controllers\CompanyManagement\TicketController;
use App\Http\Controllers\CompanyManagement\TicketTagController;
use App\Http\Controllers\CompanyManagement\TierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserManagement\RoleController;
use App\Http\Controllers\UserManagement\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::prefix('/superAdmin')->group(function () {
        Route::resource('companies', CompanyController::class);
        Route::get('/companies_chart_data', [ChartController::class, 'companiesChartData'])->name('companies.chart.data');
        Route::resource('payment-packages', PaymentPackageController::class);
        Route::get('subscription_report', [PaymentPackageController::class,'report'])->name('subscription_report');
        Route::get('/subscription_chart_data', [ChartController::class, 'SubscriptionChartData'])->name('subscription_chart_data');
        Route::get('/superAdmin/export-pdf',  [PaymentPackageController::class,'exportPDF'])->name('export.pdf');

    });
});

Route::get('/error-unauthorized', function () {
    return view('errors.unauthorized');
});
Route::get('/error-404', function () {
    return view('errors.404');
});
Route::get('/error-403', function () {
    return view('errors.403');
});
Route::get('/error-500', function () {
    return view('errors.500');
});

Route::group(['middleware' => ['auth', 'tenant_db']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::prefix('/company')->group(function () {
        Route::resource('members', MemberController::class);
        Route::resource('systems', SystemController::class);
        Route::resource('teams', TeamController::class);
        Route::resource('tiers', TierController::class);
        Route::resource('tickets', TicketController::class);
        Route::resource('tags', TicketTagController::class);
        Route::resource('rules', RuleController::class);
        Route::resource('conjunctions', ConjunctionController::class);
        Route::get('services/troubleshoot',[ServiceController::class, 'troubleshoot'])->name('troubleshoot');
        Route::get('/troubleshoot/send-requests', [ServiceController::class, 'troubleshootRequest'])->name('sendRequests');
        Route::resource('services',ServiceController::class);
        Route::resource('service_systems',ServiceSystemController::class);
        Route::get('/tickets-chart-data', [ChartController::class, 'ticketsChartData'])->name('tickets.chart.data');
        Route::post('/rate', [CompanyController::class, 'updateRate'])->name('rate.update');

        Route::put('editProfile', [CompanyController::class, 'editProfile'])->name('editProfile');
        Route::get('/profile', function () {
            $auth = User::find(Auth::id());
            return view('Company.editProfile', compact('auth'));
        })->name('profilePage');
    });

    Route::prefix('/tickets')->group(function () {
        Route::get('close/{id}', [TicketController::class, 'close'])->name('close');
        Route::get('resolve/{id}', [TicketController::class, 'resolve'])->name('resolve');
        Route::get('open/{id}', [TicketController::class, 'open'])->name('open');
        Route::post('assign', [TicketController::class, 'assign'])->name('assign');

    });
});
