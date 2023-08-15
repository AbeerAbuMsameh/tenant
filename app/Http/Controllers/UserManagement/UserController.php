<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /*   function __construct()
       {
           $this->middleware('permission:user-list', ['only' => ['index', 'show']]);
           $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
           $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
           $this->middleware('permission:user-delete', ['only' => ['destroy']]);
       }
   */
    public function index()
    {
        $user = Auth::user();
        if ($user->level == 1) {
            $users = User::byLevel(1)->with('roles')->get();
        } elseif ($user->level == 2) {
            $users = User::byLevel(2)->where('company_id', $user->company_id)->with('roles')->get();
        }
        return view('Admin.UserManagement.users.index', compact('users'));
    }

    public function create()
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
        return view('Admin.UserManagement.users.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:mysql.users,email',
//            'email' => [
//                'required',
//                'email',
//                Rule::unique('mysql.users', 'email'),
//            ],
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'roles' => 'required',
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['level'] = Auth::user()->level;
        $input['company_id'] = Auth::user()->company_id;
        DB::transaction(function () use ($request, $input) {
            $user = User::create($input);
            $user->assignRole($request->input('roles'));
        });
        toastr()->success('User Created Successfully!');
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        //
    }


    public function edit(User $user)
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
        return view('Admin.UserManagement.users.edit', compact('roles', 'user'));

    }


    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:mysql.users,email,' . $user->id,
//            'email' => [
//                'required',
//                'email',
//                Rule::unique('mysql.users', 'email')->ignore($user->id),
//            ],
            'password' => 'nullable|confirmed|min:8',
            'password_confirmation' => 'same:password',
            'roles' => 'required',
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        DB::transaction(function () use ($request, $user, $input) {
            $user->update($input);
            $user->syncRoles($input['roles']);
        });
        toastr()->success('User Updated Successfully!');
        return redirect()->route('users.index');
    }


    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted.']);
    }
}
