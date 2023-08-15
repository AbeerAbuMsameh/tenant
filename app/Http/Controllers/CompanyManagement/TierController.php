<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TierController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:tier-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:tier-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tier-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tier-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('tier-list', Team::class)) {
            return view('errors.unauthorized');
        }

        $tiers = Tier::query()->get();
        return view('Company.tiers.index', compact('tiers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('tier-create', Team::class)) {
            return view('errors.unauthorized');
        }

        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:20',
            'number' => 'required|numeric|min:2|max:3',
        ]);
        if (!$validator->fails()) {
            Tier::create($request->all());
            toastr()->success('Tier Created Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('tiers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tier  $tier
     * @return \Illuminate\Http\Response
     */
    public function show(Tier $tier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tier  $tier
     * @return \Illuminate\Http\Response
     */
    public function edit(Tier $tier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tier  $tier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('tier-create', Team::class)) {
            return view('errors.unauthorized');
        }

        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:20',
            'number' => 'required|numeric|min:2|max:3',
        ]);


        if (!$validator->fails()) {
            Tier::query()->find($id)->update($request->all());
            toastr()->success('Tier Updated Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('tiers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tier  $tier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('tier-delete', Team::class)) {
            return view('errors.unauthorized');
        }

        Tier::findOrFail($id)->delete();
        return response()->json(['message' => 'Tier deleted.']);
    }
}
