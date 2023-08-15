<?php

namespace App\Http\Controllers\AdminManagement;

use App\Http\Controllers\Controller;
use App\Models\CompanyPaymentPackage;
use App\Models\PaymentPackage;
use App\Models\Team;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class PaymentPackageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:payment-list', ['only' => ['index', 'show','report','exportPDF']]);
        $this->middleware('permission:payment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payment-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payment-delete', ['only' => ['destroy']]);

    }

    public function index()
    {

        $client = new Client();
        $response = $client->get('http://localhost:8000/api/packages', [
            'headers' => [
                'api_key' => 'Po77NiLBrg '
            ]
        ]);

        $packages = json_decode($response->getBody(), true);

        return view('Admin.PaymentPackages.index', compact('packages'));
    }

    public function report()
    {
        $client = new Client();
        $response = $client->get('http://localhost:8000/api/clients', [
            'headers' => [
                'api_key' => 'Po77NiLBrg'
            ]
        ]);

        $subscriptions = json_decode($response->getBody(), true);


        $total_price = 0;

        foreach ($subscriptions['clients'] as $subscription) {
            $total_price += floatval($subscription['subscriptions'][0]['paid_amount']);
        }

        $Company_num = count($subscriptions['clients']);

        return view('Admin.PaymentPackages.report', compact('subscriptions', 'total_price', 'Company_num'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentPackage  $paymentPackage
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentPackage $paymentPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentPackage  $paymentPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentPackage $paymentPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentPackage  $paymentPackage
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentPackage  $paymentPackage
     * @return \Illuminate\Http\Response
     */
    public function exportPDF()
    {
        // Retrieve the data needed for the PDF
        $client = new Client();
        $response = $client->get('http://localhost:8000/api/clients', [
            'headers' => [
                'api_key' => 'Po77NiLBrg'
            ]
        ]);

        $subscriptions = json_decode($response->getBody(), true);


        $total_price = 0; // Initialize the sum of paid amounts

        foreach ($subscriptions['clients'] as $subscription) {
            $total_price += floatval($subscription['subscriptions'][0]['paid_amount']); // Sum the paid amounts
        }

        $Company_num = count($subscriptions['clients']); // Count the number of clients

        // Generate the HTML content for the PDF
        $pdfContent = view('Admin.PaymentPackages.report-pdf', compact('subscriptions', 'total_price', 'Company_num'))->render();

        // Create a new instance of Dompdf
        $dompdf = new Dompdf();

        // Load the HTML content into Dompdf
        $dompdf->loadHtml($pdfContent);

        // Set the paper size and orientation (optional)
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Generate a unique filename for the PDF
        $filename = 'subscriptions-report-' . time() . '.pdf';

        // Output the PDF file for download
        $dompdf->stream($filename, ['Attachment' => true]);
    }

}
