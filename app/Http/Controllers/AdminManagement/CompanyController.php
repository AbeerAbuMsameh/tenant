<?php

namespace App\Http\Controllers\AdminManagement;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\imageTrait;
use App\Http\Requests\StoreCompanyRequest;
use App\Models\Company;
use App\Models\PaymentPackage;
use App\Models\User;
use App\Repositories\DatabaseConfig;
use App\Repositories\TenantRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class CompanyController extends Controller
{
    use imageTrait;

    protected $tenantRepository;

    function __construct()
    {
        $this->middleware('permission:company-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:company-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:company-delete', ['only' => ['destroy']]);
        $this->middleware('permission:payment-list', ['only' => ['create']]);

        $this->tenantRepository = new TenantRepository();
    }

    public function index()
    {
        $companies = Company::paginate(5); // 10 items per page
        return view('Admin.Company.index', compact('companies'));
    }


    public function create()
    {
     $client = new Client();
        $response = $client->get('http://localhost:8000/api/packages', [
            'headers' => [
                'api-key' => 'Po77NiLBrg'
            ]
        ]);

        $packages = json_decode($response->getBody(), true);
        $payment_packages = $packages['packages'];
        return view('Admin.Company.create', compact('payment_packages'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCompanyRequest $request)
    {
        $this->tenantRepository->createNewTenant($request);
        toastr()->success('Company Created Successfully');
        return redirect()->route('companies.index');

    }

    public function show(Company $company)
    {
        //
    }

    public function edit(Company $company)
    {
        $company = Company::findOrFail($company->id);
        return view('Admin.Company.edit', compact('company'));

    }

    public function update(Request $request, Company $company)
    {
        $validator = Validator($request->all(), [
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'name' => 'nullable|min:2',
            'email' => 'required|email|unique:companies,email,' . $company->id,
            'address' => 'required|String|min:4',
            'website' => 'required|url',
            'phone' => 'required|regex:/^\+?[0-9]{1,3}[-. ]?\(?[0-9]{1,}\)?[-. ]?[0-9]{1,}[-. ]?[0-9]{1,}$/',
            'description' => 'nullable',
        ]);
        if ($request->hasFile('logo')) {
            if ($company->logo) {
                $old_path = public_path($company->logo);
                if (File::exists($old_path)) {
                    File::delete($old_path);
                }
            }
            $path = $this->storeImage($request->logo);
        } else {
            $path = $company->logo;
        }
        $company->update(array_merge(
            $validator->validated(),
            [
                'logo' => $path,
                'active' => $request->active = "on" ? "1" : "0",
            ]
        ));
        toastr()->success('Company Updates Successfully!');
        return redirect()->route('companies.index');

    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $company = Company::findOrFail($id);
            $databaseName = $company->database->database;
            $result = DB::select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$databaseName'");
            if (!empty($result)) {
                DB::statement("DROP DATABASE $databaseName");
            }
            $company->delete();
            return response()->json(['message' => 'Company deleted.']);
        });

    }

    public function editProfile(Request $request)
    {
        $user = User::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'password' => 'required|confirmed|min:6',
        ], [
            'oldPassword.required' => 'The current password field is required.',
            'password.required' => 'The new password field is required.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['message' => $errors[0]], 422);
        }

        // Check if the previous password matches the one stored in the database
        if (!Hash::check($request->input('oldPassword'), $user->password)) {
            return response()->json(['message' => 'Previous password is incorrect'], 422);
        }

        // Update the password
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }

    public function updateRate(Request $request)
    {
        $validatedData = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        $company = auth()->user()->company;
        $company->rate = $validatedData['rating'];
        $company->save();
        toastr()->success('Rate updated successfully');
        return redirect()->back();
    }
}
