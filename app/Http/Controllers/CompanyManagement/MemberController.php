<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\System;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:member-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:member-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:member-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:member-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('member-list', System::class) && Gate::denies('team-list', Team::class)) {
            return view('errors.unauthorized');
        }
        $teams = Team::query()->get();
        $members = Member::query()->get();
        $users = User::query()->where(['company_id' => Auth::user()->company_id])->get();
        return view('Company.members.index', compact('members', 'teams', 'users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('member-create', System::class)) {
            return view('errors.unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('member-create', System::class)) {
            return view('errors.unauthorized');
        }
        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:20',
            'position' => 'required|String',
            'team_id' => 'exists:teams,id',
            'user_id' => 'required|numeric',
        ]);
        if (!$validator->fails()) {
            if (User::findOrfail($request->user_id)) {
                Member::create($request->all());
                toastr()->success('Member Created Successfully!');
            } else {
                toastr()->error('User Not Found');
            }
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('members.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('member-edit', System::class)) {
            return view('errors.unauthorized');
        }
        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:20',
            'position' => 'required|String',
            'team_id' => 'exists:teams,id',
            'user_id' => 'required|numeric',
        ]);
        if (!$validator->fails()) {
            if (User::findOrfail($request->user_id)) {
                Member::query()->find($id)->update($request->all());
                toastr()->success('Member Updated Successfully!');
            } else {
                toastr()->error('User Not Found');
            }
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Member $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('member-delete', System::class)) {
            return view('errors.unauthorized');
        }
        Member::findOrFail($id)->delete();
        return response()->json(['message' => 'Member deleted.']);
    }
}
