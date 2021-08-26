<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|user view'], ['only' => ['index', 'show']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|user create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|user edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|user delete'], ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasrole('developer')){
            $users = User::with('roles')
                     ->notRole(['voter'])->get();
        }else{
            $users = User::with('roles')
                ->notRole(['developer', 'super admin', 'voter'])->get();
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->hasrole('developer')){
            $roles = Role::All();
        }else{
            $roles = Role::where('name', '!=', 'developer')
                ->where('name', '!=', 'uncategorized')
                ->where('name', '!=', 'super admin')
                ->get();
        }
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'role'                   => 'required',
            'name'                   => 'required|min:3|max:50',
            'email'                  => 'required|email|unique:users',
            'password'               => 'required|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'password_confirmation'  => 'required'
        ]);

        //Only developer can create users with role developer/ super admin/ uncategorized
        if(!auth()->user()->hasrole('developer')){
            if($validatedData['role'] == 'developer' || $validatedData['role'] == 'super admin' || $validatedData['role'] == 'uncategorized')
            {
                return redirect()->route('user.create')->with('errorMessage', 'Something went wrong please try again!');
            }
        }

        $validatedData['status'] = 'active';
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['avatar'] = 'default.jpg';

        DB::beginTransaction();
        try {
            $user = User::create($validatedData);
            $user->assignRole($validatedData['role']);
            DB::commit();
            return redirect()->route('user.index')->with('successMessage', 'User successfully created!');
        } catch (\Exception $ex) {
            DB::rollback();
            \Artisan::call('cache:clear');
            return redirect()->route('user.create')->with('errorMessage', $ex->getMessage());
        }

        return redirect()->route('user.index')->with('errorMessage', 'An error has occurred please try again later!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // Only developer can modify other developer or super admin
        if(!auth()->user()->hasrole('developer')){
            if(($user->hasrole('developer')) || ($user->hasrole('super admin')))
            {
                return redirect()->route('user.index')->with('errorMessage', 'Modification restricted for selected user!');
            }
        }

        // User can not modify itself
        if((auth()->user()->id == $user->id))
        {
            return redirect()->route('user.index')->with('errorMessage', 'Self modification restricted!');
        }

        if(auth()->user()->id != '1'){
            // No one even master developer can not delete user 1 (master developer) & user 2 ( master super admin)
            if(($user->id == '1') || ($user->id == '2'))
            {
                return redirect()->route('user.index')->with('errorMessage', 'Modification restricted for selected user!');
            }
        }

        if(auth()->user()->hasrole('developer')){
            $roles = Role::all();
        }else{
            $roles = Role::where('name', '!=', 'developer')
                ->where('name', '!=', 'uncategorized')
                ->where('name', '!=', 'super admin')
                ->get();
        }

        return view('admin.users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'role'                   => 'required',
            'name'                   => 'required|min:3|max:50',
            'status'                 => 'required',
        ]);

        // Only developer can modify other developer or super admin
        if(!auth()->user()->hasrole('developer')){
            if(($user->hasrole('developer')) || ($user->hasrole('super admin')))
            {
                return redirect()->route('user.index')->with('errorMessage', 'Modification restricted for selected user!');
            }
        }

        // User can not modify itself
        if((auth()->user()->id == $user->id))
        {
            return redirect()->route('user.index')->with('errorMessage', 'Self modification restricted!');
        }

        if(auth()->user()->id != '1'){
            // No one even master developer can not delete user 1 (master developer) & user 2 ( master super admin)
            if(($user->id == '1') || ($user->id == '2'))
            {
                return redirect()->route('user.index')->with('errorMessage', 'Modification restricted for selected user!');
            }
        }

        //Only developer can create users with role developer/ super admin/ uncategorized
        if(!auth()->user()->hasrole('developer')){
            if($validatedData['role'] == 'developer' || $validatedData['role'] == 'super admin' || $validatedData['role'] == 'uncategorized')
            {
                return redirect()->route('user.index')->with('errorMessage', 'Something went wrong please try again!');
            }
        }

        DB::beginTransaction();

        try {
            $user->update($validatedData);
            $user->syncRoles($validatedData['role']);
            DB::commit();
            return redirect()->route('user.index')->with('successMessage', 'User successfully updated!');
        } catch (\Exception $ex) {
            DB::rollback();
            \Artisan::call('cache:clear');
            return redirect()->route('user.edit', $user->id)->with('errorMessage', $ex->getMessage());
        }

        return redirect()->route('user.index')->with('errorMessage', 'An error has occurred please try again later!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Only developer can delete other developer or super admin
        if(!auth()->user()->hasrole('developer')){
            if(($user->hasrole('developer')) || ($user->hasrole('super admin')))
            {
                return redirect()->route('user.index')->with('errorMessage', 'Modification restricted for selected user!');
            }
        }

        // User can not delete itself
        if((auth()->user()->id == $user->id))
        {
            return redirect()->route('user.index')->with('errorMessage', 'Self modification restricted!');
        }

        // No one even master developer can not delete user 1 (master developer) & user 2 ( master super admin)
        if(($user->id == '1') || ($user->id == '2'))
        {
            return redirect()->route('user.index')->with('errorMessage', 'Modification restricted for selected user!');
        }

        DB::beginTransaction();

        try {
            $user->delete();
            DB::commit();
            return redirect()->route('user.index')->with('successMessage', 'User successfully deleted!');
        } catch (\Exception $ex) {
            DB::rollback();
            \Artisan::call('cache:clear');
            return redirect()->route('user.index')->with('errorMessage', $ex->getMessage());
        }

        return redirect()->route('user.index')->with('errorMessage', 'An error has occurred please try again later!');
    }
}
