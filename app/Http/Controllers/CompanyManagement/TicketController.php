<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\RefreshClientProfile;
use App\Models\Company;
use App\Models\CompanyPaymentPackage;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\Tier;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{

    use RefreshClientProfile;
    function __construct()
    {
        $this->middleware('permission:ticket-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:ticket-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:ticket-close', ['only' => ['close']]);
        $this->middleware('permission:ticket-assign', ['only' => ['assign']]);
        $this->middleware('permission:ticket-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ticket-resolve', ['only' => ['resolve']]);
        $this->middleware('permission:ticket-open', ['only' => ['open']]);
        $this->middleware('permission:ticket-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        if (Gate::denies('ticket-list', Ticket::class)) {
            return view('errors.unauthorized');
        }

        $teams = Team::query()->get();
        $tiers = Tier::query()->get();
        $tickets = Ticket::query()->paginate(100);
        return view('Company.tickets.index', compact('tickets', 'teams', 'tiers'));
    }


    public function create()
    {
        if (Gate::denies('ticket-create', Ticket::class)) {
            return view('errors.unauthorized');
        }

        return view('Company.tickets.create');
    }


    public function store(Request $request)
    {
        if (Gate::denies('ticket-create', Ticket::class)) {
            return view('errors.unauthorized');
        }
        $validator = Validator($request->all(), [
            'ticket_num' => 'required|String|min:3',
            'report_src' => 'required|string|in:Phone,Email,Self_Service,Customer_Service,Technical_Team',
            'impact' => 'nullable|string|in:Limited,Localized',
            'urgency' => 'nullable|string|in:Low,Medium,High,Critical,Urgent',
            'priority' => 'nullable|string|in:Low,Medium,High,Critical,Urgent',
            'description' => 'nullable|string|min:3',
        ]);
        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back();
        }
        $request['report_date'] = now();
        $ticket = Ticket::create($request->all());
        $client = new Client();

         $clientId = Company::where('id', Auth::user()->company_id)->value('client_id');

         $response = $client->post('http://localhost:8000/api/subscriptions/decrease-limit', [
            'headers' => [
                'api_key' => 'Po77NiLBrg'
            ],
            'json' => [
                'client_id' => $clientId,
                'discount' => 1
            ]
        ]);


        $responseData = json_decode($response->getBody(), true);

        if ($responseData['client']['profile']['limit'] <= 10) {
            toastr()->warning('Remaining Ticket on Selected Subscription Package is '.$responseData['client']['profile']['limit'] );
        }

        if ($request->impact == null || $request->urgency == null || $request->priority == null) {
            $ticket->applyRules();
        }
        $ticket->assignTeamBasedOnTags();
        toastr()->success('Ticket Created Successfully!');
        return redirect()->route('tickets.index');
    }




    public function show($id)
    {
        if (Gate::denies('ticket-show', Ticket::class)) {
            return view('errors.unauthorized');
        }
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return view('errors.404');
        }

        return view('Company.tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('ticket-edit', Ticket::class)) {
            return view('errors.unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'tier2' => 'nullable|exists:tiers,id',
            'tier3' => 'nullable|exists:tiers,id',
            'description' => 'nullable|string|min:3',
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back()->withErrors($validator);
        }
        $ticket = Ticket::query()->find($id);
        $ticket->update($request->all());
        $ticket->applyRules();
        $ticket->assignTeamBasedOnTags();
        toastr()->success('Ticket updated successfully!');
        return redirect()->route('tickets.index');
    }


    public function destroy($id)
    {
        if (Gate::denies('ticket-delete', Ticket::class)) {
            return view('errors.unauthorized');
        }

        $ticket = Ticket::find($id);

        if (!$ticket) {
            return view('errors.404');
        }

        Ticket::findOrFail($id)->delete();
        return response()->json(['message' => 'Ticket deleted.']);
    }

    public function close(Request $request, $id)
    {
        if (Gate::denies('ticket-close', Ticket::class)) {
            return view('errors.unauthorized');
        }

        $ticket = Ticket::find($id);
        if (!$ticket) {
            return view('errors.404');
        }

        if ($ticket->open_date != null && $ticket->close_date == null) {
            $request['close_date'] = now();
            if ($ticket->last_resolve_date == null)
                $request['last_resolve_date'] = $request['close_date'];
            $ticket->status = 'closed';
            $ticket->update($request->all());
            toastr()->success('Ticket Closed Successfully!');
        } else {
            toastr()->info($ticket->open_date == null ? 'Ticket can\'t be closed !'
                : 'Ticket Closed Previously!');
        }
        return redirect()->route('tickets.index');
    }

    public function resolve(Request $request, $id)
    {
        if (Gate::denies('ticket-resolve', Ticket::class)) {
            return view('errors.unauthorized');
        }
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return view('errors.404');
        }

        if ($ticket->close_date == null && $ticket->assign_date != null) {
            $request['last_resolve_date'] = now();
            $ticket->status = 'resolved'; // Set the status to 'closed'
            $ticket->update($request->all());;
            $ticket->applyRules();
            toastr()->success('Last Resolve date Updated Successfully!');
        } else {
            toastr()->info($ticket->assign_date == null ? 'Ticket not Assigned to any team previously !'
                : 'Ticket Closed Previously!');
        }
        return redirect()->route('tickets.index');
    }

    public function open(Request $request, $id)
    {
        if (Gate::denies('ticket-open', Ticket::class)) {
            return view('errors.unauthorized');
        }
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return view('errors.404');
        }
        if ($ticket->close_date == null) {
            $request['open_date'] = now();
            $ticket->status = 'opened'; // Set the status to 'opened'
            $ticket->update($request->all());
            $ticket->applyRules();
            toastr()->success('Ticket Opened Successfully!');
        } else {
            toastr()->warning('Ticket Closed Previously , Cant Open!');
        }
        return redirect()->route('tickets.index');

    }

    public function assign(Request $request)
    {
        if (Gate::denies('ticket-assign', Ticket::class)) {
            return view('errors.unauthorized');
        }
        $ticket = Ticket::find($request->assignTicketId);

        if (!$ticket) {
            return view('errors.404');
        }
        if ($ticket->open_date != null && $ticket->close_date == null) {
            $ticket->assign_date = now();
            $ticket->status = 'assigned'; // Set the status to 'closed'
            $ticket->team_id = $request->team_id;
            $ticket->save();
            $ticket->applyRules();
            toastr()->success('Ticket Assigned to Team Successfully!');
        } else {
            toastr()->info($ticket->open_date == null ? 'Ticket can\'t be Assigned Before open !'
                : 'Ticket Closed Previously!');
        }
        return redirect()->route('tickets.index');
    }

}
