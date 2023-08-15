<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Conjunction;
use App\Models\Member;
use App\Models\Rule;
use App\Models\Service;
use App\Models\System;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketTag;
use App\Models\Tier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (Auth::user()->level == '2') {
            $teams_num = Team::query()->count();
            $systems_num = System::query()->count();
            $systems_num += Tier::query()->count();
            $tickets_num = Ticket::query()->count();
            $rules_num = Rule::query()->count();
            $members_num = Member::query()->count();
            $services_num = Service::query()->count();
            $conjunction = Conjunction::query()->count();
            $ticket_tags_num = TicketTag::query()->count();

            $opened_tickets_num = Ticket::query()->where('status', 'opened')->count();
            $closed_tickets_num = Ticket::query()->where('status', 'closed')->count();
            $assigned_tickets_num = Ticket::query()->where('status', 'assigned')->count();
            $reported_tickets_num = Ticket::query()->where('status', 'reported')->count();
            $resolved_tickets_num = Ticket::query()->where('status', 'resolved')->count();

            $opened_tickets_avg = $tickets_num !== 0 ? number_format(($opened_tickets_num / $tickets_num) * 100, 2) : 0;
            $closed_tickets_avg = $tickets_num !== 0 ? number_format(($closed_tickets_num / $tickets_num) * 100, 2) : 0;
            $assigned_tickets_avg = $tickets_num !== 0 ? number_format(($assigned_tickets_num / $tickets_num) * 100, 2) : 0;
            $reported_tickets_avg = $tickets_num !== 0 ? number_format(($reported_tickets_num / $tickets_num) * 100, 2) : 0;
            $resolved_tickets_avg = $tickets_num !== 0 ? number_format(($resolved_tickets_num / $tickets_num) * 100, 2) : 0;


            return view('home', compact(
                'teams_num',
                'systems_num',
                'tickets_num',
                'rules_num',
                'members_num',
                'services_num',
                'conjunction',
                'ticket_tags_num',
                'opened_tickets_num',
                'closed_tickets_num',
                'assigned_tickets_num',
                'reported_tickets_num',
                'resolved_tickets_num',
                'opened_tickets_avg',
                'closed_tickets_avg',
                'assigned_tickets_avg',
                'reported_tickets_avg',
                'resolved_tickets_avg'
            ));
        } else {
            $users_num = User::query()->count();
            $roles_num = Role::query()->count();
            $companies = Company::all();
            $totalCompanies = $companies->count();
            $ratingSum = $companies->sum('rate');
            if ($totalCompanies > 0) {
                $ratingPercentage = round($ratingSum / ($totalCompanies * 5) * 100, 2);
            }else{
                $ratingPercentage = 0;
            }
            $companies_num = Company::query()->count();
            return view('home', compact('roles_num', 'ratingPercentage', 'users_num', 'companies_num'));

        }

    }
}
