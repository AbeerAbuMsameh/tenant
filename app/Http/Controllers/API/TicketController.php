<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RefreshClientProfile;
use App\Models\CompanyPaymentPackage;
use App\Models\Database;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\Tier;
use App\Repositories\DatabaseConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    use  RefreshClientProfile;


    public function store(Request $request)
    {
        $company = Auth::user()->company;
        $database = $company->database;

        $validator = Validator($request->all(), [
            'ticket_num' => 'required|String|min:3',
            'report_src' => 'required|string|in:Phone,Email,Self_Service,Customer_Service,Technical_Team',
            'impact' => 'nullable|string|in:Limited,Localized',
            'urgency' => 'nullable|string|in:Low,Medium,High,Critical,Urgent',
            'priority' => 'nullable|string|in:Low,Medium,High,Critical,Urgent',
            'description' => 'nullable|string|min:3',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse([], 400, $validator->errors()->first());
        }

        $request['report_date'] = $request['created_at'];

        if ($database) {
            DatabaseConfig::addTenantDatabaseConnectionConfig($database);
            DB::setDefaultConnection($database->database);
            $ticket = Ticket::create($request->all());
            $package = CompanyPaymentPackage::where('company_id', Auth::user()->company_id)->first();

            if ($package) {
                if ($package->num_of_ticket == 0) {
                    toastr()->error('Sorry, your ticket limit has been reached. Please contact customer support for assistance.');
                    return redirect()->route('tickets.index');
                } elseif ($package->num_of_ticket <= 10) {
                    $remainingTickets = $package->num_of_ticket - 1;
                    toastr()->warning("You have only $remainingTickets ticket(s) remaining. Consider purchasing additional tickets.");
                }

                $package->num_of_ticket -= 1;
                $package->save();
            } else {
                toastr()->error('Package not found. Please try again or contact customer support.');
            }
            if ($request->impact == null || $request->urgency == null || $request->priority == null) {
                $ticket->applyRules();
            }
            $ticket->assignTeamBasedOnTags();
            DB::reconnect();
            $ticket = $ticket->fresh(); // Reload the ticket from the database to get all the data
            return $this->apiResponse($ticket, 200, 'Ticket Created Successfully');
        }

    }

}
