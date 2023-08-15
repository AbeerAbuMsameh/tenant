<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceSystem;
use App\Models\System;
use App\Models\Tier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;


class ServiceController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:service-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:service-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:service-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy']]);
        $this->middleware('permission:troubleshoot', ['only' => ['troubleshoot']]);
        $this->middleware('permission:troubleshootRequest', ['only' => ['troubleshootRequest']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('service-list', Service::class)) {
            return view('errors.unauthorized');
        }
        $systems = System::get();
        $tiers = Tier::get();


        $services = Service::with('service_systems')->get();

        return view('Company.services.index', compact('systems', 'tiers', 'services'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('service-create', Service::class)) {
            return view('errors.unauthorized');
        }

        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:20',
        ]);
        if (!$validator->fails()) {
            Service::create($request->all());
            toastr()->success('Service Created Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('service-create', Service::class)) {
            return view('errors.unauthorized');
        }

        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:20',
        ]);


        if (!$validator->fails()) {
            Service::query()->find($id)->update($request->all());
            toastr()->success('Service Updated Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('service-delete', Service::class)) {
            return view('errors.unauthorized');
        }

        Service::findOrFail($id)->delete();
        return response()->json(['message' => 'Service deleted.']);
    }


    /**
     * @return Application|Factory|View
     */
    public function troubleshoot()
    {
        if (Gate::denies('troubleshoot', Service::class)) {
            return view('errors.unauthorized');
        }
        $services = Service::with('service_systems')->get();
        $systems = System::get();
        $tiers = Tier::get();

        return view('Company.services.troubleshooting', compact('systems', 'tiers', 'services'));

    }

    public function troubleshootRequest(Request $request)
    {
        if (Gate::denies('troubleshootRequest', Service::class)) {
            return view('errors.unauthorized');
        }
        $serviceId = $request->input('service_id');
        $serviceSystems = ServiceSystem::where('service_id', $serviceId)->get();
        foreach ($serviceSystems as $system) {
            $command = $system->command;
            try {
                $response = Http::get($command);
                // Update the status for the current system
                $system->status = 'Success';
            } catch (\Exception $e) {
                $system->status = 'Error';
            }
            $system->save();
        }
    }
}
