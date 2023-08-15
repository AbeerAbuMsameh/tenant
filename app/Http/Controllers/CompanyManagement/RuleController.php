<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RuleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:rule-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:rule-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:rule-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:rule-delete', ['only' => ['destroy']]);
    }


    public function index()
    {
        if (Gate::denies('rule-list', Rule::class)) {
            return view('errors.unauthorized');
        }

        $rules = Rule::all();
        return view('Company.rules.index', compact('rules'));

    }


    public function create()
    {
        if (Gate::denies('rule-create', Rule::class)) {
            return view('errors.unauthorized');
        }

        return view('Company.rules.create');

    }

    public function store(Request $request)
    {
        if (Gate::denies('rule-create', Rule::class)) {
            return view('errors.unauthorized');
        }
        $validator = Validator($request->all(), [
            'field' => 'required',
            'operator' => 'required',
            'value' => 'required',
            'cast' => in_array($request->input('field'), ['report_date', 'last_resolve_date', 'assign_date', 'open_date']) ? 'required' : 'nullable',
//            'output_field' => 'required',
//            'output_value' => 'required',
        ]);
        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back();
        }
        $castOptions = [
            'date' => "date('Y-m-d', strtotime($request->value))",
            'month' => "date('m', strtotime($request->value))",
            'day' => "date('d', strtotime($request->value))",
            'hour' => "date('H', strtotime($request->value))",
            'strtolower' => "strtolower($request->value)",
        ];
        Rule::create(array_merge($request->all(), [
            'cast' => $castOptions[$request->cast] ?? null,
        ]));
        toastr()->success('Rules Created Successfully!');
        return redirect()->route('rules.index');

    }


    public function show($id)
    {
        $rule = Rule::findOrFail($id);
        return view('Company.rules.show', compact('rule'));
    }


    public function edit($id)
    {
        $rule = Rule::findOrFail($id);
        return view('Company.rules.edit', compact('rule'));

    }

    public function update(Request $request, $id)
    {

        if (Gate::denies('rule-edit', Rule::class)) {
            return view('errors.unauthorized');
        }
        $validator = Validator($request->all(), [
            'field' => 'required',
            'operator' => 'required',
            'value' => 'required',
            'cast' => in_array($request->input('field'), ['report_date', 'last_resolve_date', 'assign_date', 'open_date']) ? 'required' : 'nullable',
//            'output_field' => 'required',
//            'output_value' => 'required',
        ]);
        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back();
        }
        $castOptions = [
            'date' => "date('Y-m-d', strtotime($request->value))",
            'month' => "date('m', strtotime($request->value))",
            'day' => "date('d', strtotime($request->value))",
            'hour' => "date('H', strtotime($request->value))",
            'strtolower' => "strtolower($request->value)",
        ];
        Rule::query()->find($id)->update(array_merge($request->all(), [
            'cast' => $castOptions[$request->cast] ?? null,
        ]));

        toastr()->success('Rules Updated Successfully!');
        return redirect()->route('rules.index');

    }

    public function destroy($id)
    {
        if (Gate::denies('rule-delete', Rule::class)) {
            return view('errors.unauthorized');
        }
        Rule::findOrFail($id)->delete();
        return response()->json(['message' => 'Rule deleted.']);
    }
}
