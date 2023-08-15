<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /*
      function __construct()
     {
         $this->middleware('permission:role-list', ['only' => ['index', 'show']]);
         $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
     }
    */


    public function index()
    {
        if (Auth::user()->level == 1) {
            $roles = Role::where('level', 1)->with('permissions')->get();
        } elseif (Auth::user()->level == 2) {
            $company_id = Auth::user()->company_id;
            $roles = Role::where('level', 2)
                ->where('company_id', $company_id)
                ->with('permissions')
                ->get();
        }
        return view('Admin.UserManagement.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::on('mysql')->where('level', auth()->user()->level)->get();
        return view('Admin.UserManagement.roles.create', compact('permissions'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:mysql.roles,name',
            'permissions' => 'required',
        ]);

        $role = Role::on('mysql')->create([
            'name' => $request->input('name'),
            'level' => auth()->user()->level,
            'company_id' => auth()->user()->company_id,
        ]);

        $permissions = Permission::on('mysql')->whereIn('id', $request->input('permissions'))->get();
        $role->syncPermissions($permissions);

        toastr()->success('Role Created Successfully!');
        return redirect()->route('roles.index');
    }


    public function show(Role $role)
    {
        $rolePermissions = Permission::on('mysql')->join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $role->id)
            ->get();

        return view('Admin.UserManagement.roles.show', compact('role', 'rolePermissions'));
    }


    public function edit(Role $role)
    {
        $permissions = Permission::on('mysql')->where('level', auth()->user()->level)->get();
        $rolePermissions = DB::connection('mysql')->table("role_has_permissions")->where("role_has_permissions.role_id", $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('Admin.UserManagement.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required',
        ]);

        $role->name = $request->input('name');
        $role->save();

        $permissions = Permission::on('mysql')->whereIn('id', $request->input('permissions'))->get();
        $role->syncPermissions($permissions);

        toastr()->success('Role Updated Successfully!');
        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        Role::on('mysql')->findOrFail($id)->delete();
        return response()->json(['message' => 'Role deleted.']);
    }
}
