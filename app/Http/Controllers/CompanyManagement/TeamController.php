<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:team-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:team-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:team-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:team-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('team-list', Team::class)) {
            return view('errors.unauthorized');
        }

        $teams = Team::query()->get();
        return view('Company.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (Gate::denies('team-create', Team::class)) {
            return view('errors.unauthorized');
        }

        $validator = Validator($request->all(), [
            'name' => 'required|min:2|max:50',
        ]);
        if (!$validator->fails()) {
            Team::create($request->all());
            toastr()->success('Team Created Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('teams.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, $id)
    {

        if (Gate::denies('team-edit', Team::class)) {
            return view('errors.unauthorized');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:50',
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back()->withErrors($validator);
        }
        Team::query()->find($id)->update($request->all());
        toastr()->success('Team updated successfully!');
        return redirect()->route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Gate::denies('team-delete', Team::class)) {
            return view('errors.unauthorized');
        }

        Team::findOrFail($id)->delete();
        return response()->json(['message' => 'Team deleted.']);
    }
}
