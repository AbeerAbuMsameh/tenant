<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Models\Team;
use App\Repositories\TenantRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SystemController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:system-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:system-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:system-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:system-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('system-list', System::class)) {
            return view('errors.unauthorized');
        }

        $systems = System::query()->get();
        return view('Company.systems.index', compact('systems'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('system-create', System::class)) {
            return view('errors.unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (Gate::denies('system-create', System::class)) {
            return view('errors.unauthorized');
        }
        $validator = Validator($request->all(), [
            'name' => 'required|unique:systems,name',
            'main_host' => 'required',
        ]);
        if (!$validator->fails()) {
            System::create($request->all());
            toastr()->success('System Created Successfully!');
        }else{
            toastr()->error($validator->getMessageBag()->first());
        }
            return redirect()->route('systems.index');

    }

        /**
         * Display the specified resource.
         *
         * @param \App\Models\System $system
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\System $system
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {

        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param \App\Models\System $system
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            if (Gate::denies('system-edit', System::class)) {
                return view('errors.unauthorized');
            }
            $validator = Validator($request->all(), [
                'name' => 'required|unique:systems,name,'.$id,
                'main_host' => 'required',
            ]);
            if (!$validator->fails()) {
                System::query()->find($id)->update($request->all());
                toastr()->success('System Updated Successfully!');
            }else{
                toastr()->error($validator->getMessageBag()->first());
            }
            return redirect()->route('systems.index');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\System $system
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            if (Gate::denies('system-delete', System::class)) {
                return view('errors.unauthorized');
            }
            System::findOrFail($id)->delete();
            return response()->json(['message' => 'System deleted.']);
        }
    }
