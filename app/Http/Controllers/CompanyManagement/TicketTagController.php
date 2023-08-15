<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TicketTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketTagController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:tag-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:tag-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tag-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tag-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        if (Gate::denies('tag-list', TicketTag::class)) {
            return view('errors.unauthorized');
        }

        $tags = TicketTag::query()->get();
        return view('Company.tags.index', compact('tags'));

    }


    public function create()
    {
        if (Gate::denies('tag-create', TicketTag::class)) {
            return view('errors.unauthorized');
        }
        $teams = Team::all();
        return view('Company.tags.create', compact('teams'));
    }

    public function store(Request $request)
    {
        if (Gate::denies('tag-create', TicketTag::class)) {
            return view('errors.unauthorized');
        }

        $validator = Validator($request->all(), [
            'words' => ['required', 'regex:/^[\w\s]+(?:,[\w\s]+)*,?$/'],
            'team_id' => 'required|exists:teams,id',
        ]);
        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back();
        }

        TicketTag::create($request->all());
        toastr()->success('Tags Created Successfully!');

        return redirect()->route('tags.index');

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if (Gate::denies('tag-edit', TicketTag::class)) {
            return view('errors.unauthorized');
        }
        $tag = TicketTag::findorfail($id);
        $teams = Team::all();
        return view('Company.tags.edit', compact('teams', 'tag'));
    }


    public function update(Request $request, $id)
    {
        if (Gate::denies('tag-edit', TicketTag::class)) {
            return view('errors.unauthorized');
        }

        $validator = Validator($request->all(), [
            'words' => ['required', 'regex:/^[\w\s]+(?:,[\w\s]+)*,?$/'],
            'team_id' => 'required|exists:teams,id',
        ]);
        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back();
        }

        TicketTag::query()->find($id)->update($request->all());
        toastr()->success('Tag Updated Successfully!');
        return redirect()->route('tags.index');
    }


    public function destroy($id)
    {
        if (Gate::denies('tag-delete', TicketTag::class)) {
            return view('errors.unauthorized');
        }
        TicketTag::findOrFail($id)->delete();
        return response()->json(['message' => 'Tag deleted.']);
    }
}
