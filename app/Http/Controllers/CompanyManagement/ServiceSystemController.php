<?php

namespace App\Http\Controllers\CompanyManagement;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceSystem;
use App\Models\System;
use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class ServiceSystemController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:service-system-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:service-system-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:service-system-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:service-system-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::denies('service-system-list', Service::class)) {
            return view('errors.unauthorized');
        }

        $systems = System::get();
        $tiers = Tier::get();
        $services = Service::whereDoesntHave('service_systems')->get();
        $service_id = request()->input('service_id');
        return view('Company.services.addSystems', compact('systems', 'tiers', 'services', 'service_id'));
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
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'systems' => 'required|array',
            'systems.*.main_host' => 'nullable|string',
            'systems.*.sort_num' => 'required|integer|min:1',
            'systems.*.command' => 'required|string',
        ],[
            'systems.*.main_host' => 'Main Host is Required',
            'systems.*.sort_num' => 'Sort Number of System is Required',
            'systems.*.command' => 'Command is Required',

        ]);

        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->route('service_systems.index');

        }


        $serviceSystems = [];

        foreach ($request->input('systems') as $system) {
            $systemId = $system['system_id'];
            $mainHost = isset($system['main_host']) ? $system['main_host'] : null;

            if ($mainHost === null) {
                $system_main = System::find($systemId);
                $mainHost = $system_main->main_host;
                $systemId = $system_main->id;
                $tierId = null;
            } else {
                $tierId = $systemId;
                $systemId = null;
            }

            $serviceSystems[] = [
                'service_id' => $request->input('service_id'),
                'system_id' => $systemId,
                'tier_id' => $tierId,
                'main_host' => $mainHost,
                'sort_num' => $system['sort_num'],
                'command' => $system['command'],
                'created_at' => now(),

            ];
        }

        ServiceSystem::insert($serviceSystems);

        toastr()->success('Systems Added Successfully');

        return redirect()->route('services.index');

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceSystem  $serviceSystem
     * @return \Illuminate\Http\Response
     */
    public function show($serviceId)
    {
        // Retrieve service systems based on the service ID
        $serviceSystems = ServiceSystem::where('service_id', $serviceId)->orderBy('sort_num', 'asc')->get();

        // Transform the service systems to include the system name or tier name
        $transformedSystems = $serviceSystems->map(function ($serviceSystem) {
            $systemName = optional($serviceSystem->system)->name;
            $tierName = optional($serviceSystem->tier)->name;

            $name = $systemName ?? $tierName;
            return [
                'name' => $name,
                'main_host' => $serviceSystem->main_host,
                'sort_num' => $serviceSystem->sort_num,
                'command' => $serviceSystem->command,
            ];
        });

        // Return the service systems as a JSON response
        return response()->json(['systems' => $transformedSystems]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceSystem  $serviceSystem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::with('service_systems')->find($id);
        $systems = System::get();
        $tiers = Tier::get();

        return view('Company.services.edit-systems', compact('systems', 'tiers', 'service'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceSystem  $serviceSystem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'systems' => 'required|array',
            'systems.*.main_host' => 'nullable|string',
            'systems.*.sort_num' => 'required|integer|min:1',
            'systems.*.command' => 'required|string',
        ],[
            'systems.*.main_host' => 'Main Host is Required',
            'systems.*.sort_num' => 'Sort Number of System is Required',
            'systems.*.command' => 'Command is Required',

        ]);

        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->route('services.index');
        }
        $serviceSystems = [];

        foreach ($request->input('systems') as $system) {
            $systemId = $system['system_id'];
            $mainHost = isset($system['main_host']) ? $system['main_host'] : null;
            if ($mainHost === null) {
                $system_main = System::find($systemId);
                $mainHost = $system_main->main_host;
                $systemId = $system_main->id;
                $tierId = null;
            } else {
                $tierId = $systemId;
                $systemId = null;
            }

            $serviceSystems[] = [
                'service_id' => $id,
                'system_id' => $systemId,
                'tier_id' => $tierId,
                'main_host' => $mainHost,
                'sort_num' => $system['sort_num'],
                'command' => $system['command'],
                'created_at' => now(),
            ];
        }

        $service = Service::findOrFail($id);

        // Delete all associated service_systems
        $service->service_systems()->delete();

        // Delete the service
        ServiceSystem::insert($serviceSystems);

        toastr()->success('Systems Updated Successfully');

        return redirect()->route('services.index');
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();

            toastr()->error('Failed to update systems.');
            return redirect()->route('services.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceSystem  $serviceSystem
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceSystem $serviceSystem)
    {
        //
    }
}
