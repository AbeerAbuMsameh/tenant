<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyPaymentPackage;
use App\Models\Ticket;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:company-chart', ['only' => ['companiesChartData']]);
        $this->middleware('permission:ticket-chart', ['only' => ['ticketsChartData']]);
        $this->middleware('permission:payment-chart', ['only' => ['SubscriptionChartData']]);
    }

    public function ticketsChartData()
    {
        // Retrieve ticket data from the database
        $tickets = Ticket::select('created_at')->get();

        // Prepare the data for the chart
        $ticketCounts = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov','Dec'];

        foreach ($months as $month) {
            $ticketCounts[$month] = 0;
        }

        foreach ($tickets as $ticket) {
            $date = $ticket->created_at->format('M');
            $ticketCounts[$date]++;
        }

        // Prepare the response JSON
        $response = [
            'labels' => $months,
            'data' => array_values($ticketCounts)
        ];

        return response()->json($response);
    }

    public function companiesChartData()
    {
        // Retrieve Company data from the database
        $companies = Company::select('created_at')->get();

        // Prepare the data for the chart
        $companiesCounts = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov','Dec'];

        foreach ($months as $month) {
            $companiesCounts[$month] = 0;
        }

        foreach ($companies as $company) {
            $date = $company->created_at->format('M');
            $companiesCounts[$date]++;
        }

        // Prepare the response JSON
        $response = [
            'labels' => $months,
            'data' => array_values($companiesCounts)
        ];

        return response()->json($response);
    }

    public function SubscriptionChartData()
    {
        $client = new Client();

        $response = $client->get('http://localhost:8000/api/clients', [
            'headers' => [
                'api_key' => 'Po77NiLBrg'
            ]
        ]);

        if ($response->getStatusCode() === 200) {
            $data = [];
            $paidAmountSum = 0;

            $clients = json_decode($response->getBody(), true)['clients'];

            foreach ($clients as $client) {
                $paidAmountSum = 0;
                $paidAmountSum += floatval($client['subscriptions'][0]['paid_amount']);

                $date = Carbon::parse($client['subscriptions'][0]['created_at']);
                $month = $date->format('M');
                $year = $date->format('Y');

                $data[$month] = ($data[$month] ?? 0) + $paidAmountSum;
            }

            return response()->json($data);
        }

        return response()->json([]);
    }

}
