<?php

namespace App\Repositories;

use App\Http\Controllers\Traits\RefreshClientProfile;
use App\Http\Requests\StoreCompanyRequest;
use App\Jobs\CompanyDatabaseCreation;
use App\Models\Company;
use App\Models\CompanyPaymentPackage;
use App\Models\PaymentPackage;
use App\Models\User;
use Database\Seeders\Tenancy\CompanyFirstUserSeeder;
use Database\Seeders\Tenancy\TeamSeeder;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\Traits\imageTrait;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class TenantRepository
{
    use imageTrait;
    use RefreshClientProfile;

    protected $databaseRepository;
    protected $serverRepository;

    public function __construct()
    {
        $this->databaseRepository = new DatabaseRepository();
        $this->serverRepository = new ServerRepository();
    }

    public function createNewTenant (StoreCompanyRequest $request): Company
    {
        # create database
        $databaseName = DatabaseConfig::generateTenantDatabaseName($request->input('name'));
        $database = $this->databaseRepository->createOrFindDefaultLocalDatabase($databaseName);

        # get server
        $server = $this->serverRepository->getDefaultLocalServer();

        # set data to request
        $request->request->add(['database_id' => $database->id, 'server_id' => $server->id]);

        # add company
        $company = $this->createCompany($request);

        # create first role and user for company
        $this->createCompanyAuth($company);

        # configure company database
        DatabaseConfig::addTenantDatabaseConnectionConfig($database);

        # create company database DDL
        (new CompanyDatabaseCreation($databaseName))->handle();

        return $company;
    }

    private function createCompany (StoreCompanyRequest $request): Company
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            if ($request->hasFile('logo')) {
                $input['logo'] = $this->storeImage($request->file('logo'));}
            $input['active'] = $request->active === "on" ? "1" : "0";

            $client_id = $this->createClient($request);
            $input['client_id'] = $client_id;

            $result = $this->createOnlinePayment($request, $client_id);
            $transaction_number = $result['transaction_number'];

            $this->createSubscription($client_id, $transaction_number ,$request->payment_package);
            $this->refreshClientProfile($client_id);

            $company = Company::query()->create($input);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();}

        return $company;
    }

    private function createCompanyAuth (Company $company): void
    {
        (new CompanyFirstUserSeeder($company))->run();
    }

    function createClient($request)
    {
        $client = new Client();

        $response = $client->request('POST', 'http://localhost:8000/api/clients', [
            'headers' => [
                'api_key' => 'Po77NiLBrg',
            ],
            'json' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone
            ]
        ]);

        $body = $response->getBody();
        $client = json_decode($body, true);

        return $client['client']['id'];

    }

    function createOnlinePayment($request,$client_id){
        $client = new Client();

        $response = $client->request('POST', 'http://localhost:8000/api/online-payments', [
            'headers' => [
                'api_key' => 'Po77NiLBrg',
            ],
            'json' => [
                'client_id' => $client_id,
                'package_id' => $request->payment_package,
                'payment_method' => $request->payment_method,
                'promo_code' => $request->promo_code ?? null,
                ]
        ]);

        $body = $response->getBody();
        $payment = json_decode($body, true);

        return [
            'payment_id' => $payment['online_payment']['id'],
            'transaction_number' => $payment['online_payment']['transaction_number'],
        ];
    }

    function createSubscription($clientId, $transactionNumber, $packageId){
        $client = new Client();

        $response = $client->request('POST', 'http://localhost:8000/api/clients/subscriptions', [
            'headers' => [
                'api_key' => 'Po77NiLBrg',
            ],
            'json' => [
                'client_id' => $clientId,
                'package_id' => $packageId,
                'transaction_number' => $transactionNumber,
            ]
        ]);

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            return true;
        } else {
            return false;
        }
    }


}
