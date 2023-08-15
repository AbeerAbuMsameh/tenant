<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Conjunction;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConjunctionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:conjunction-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:conjunction-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:conjunction-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:conjunction-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        if (Gate::denies('conjunction-list', Conjunction::class)) {
            return view('errors.unauthorized');
        }

        $conjunctions = Conjunction::all();
        return view('Company.conjunctions.index', compact('conjunctions'));

    }


    public function create()
    {
        if (Gate::denies('conjunction-create', Conjunction::class)) {
            return view('errors.unauthorized');
        }
        $rules = Rule::all();
        return view('Company.conjunctions.create', compact('rules'));

    }

    public function store(Request $request)
    {
        if (Gate::denies('conjunction-create', Conjunction::class)) {
            return view('errors.unauthorized');
        }
        $validator = Validator($request->all(), [
            'conjunction' => 'required',
            'output_field' => 'required',
            'output_value' => 'required',
        ]);
        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back();
        }

        Conjunction::create($request->all());
        toastr()->success('Conjunction Created Successfully!');
        return redirect()->route('conjunctions.index');

    }


    public function show($id)
    {

    }


    public function edit($id)
    {
        $rules = Rule::all();
        $conjunction = Conjunction::findOrFail($id);
        return view('Company.conjunctions.edit', compact('conjunction','rules'));

    }

    public function update(Request $request, $id)
    {

        if (Gate::denies('conjunction-edit', Conjunction::class)) {
            return view('errors.unauthorized');
        }
        $validator = Validator($request->all(), [
            'conjunction' => 'required',
            'output_field' => 'required',
            'output_value' => 'required',
        ]);
        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back();
        }
        Conjunction::query()->find($id)->update($request->all());

        toastr()->success('Conjunction Updated Successfully!');
        return redirect()->route('conjunctions.index');

    }

    public function destroy($id)
    {
        if (Gate::denies('conjunction-delete', Conjunction::class)) {
            return view('errors.unauthorized');
        }
        Conjunction::findOrFail($id)->delete();
        return response()->json(['message' => 'Conjunction deleted.']);
    }

}
