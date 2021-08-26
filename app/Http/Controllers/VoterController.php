<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Voter;

class VoterController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global|voter view'], ['only' => ['index', 'show']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|voter create'], ['only' => ['create', 'store']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|voter edit'],   ['only' => ['edit', 'update']]);
        $this->middleware(['role_or_permission:developer|super admin|master|global|voter delete'], ['only' => ['destroy']]);
    }


    public function index()
    {
        $voters = User::role('voter')->get();
        return view('admin.voters.index', compact('voters'));
    }

    public function create()
    {
        return view('admin.voters.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'                   => 'required|min:3|max:50',
            'email'                  => 'required|email|unique:users',
            'password'               => 'required|confirmed',
            'password_confirmation'  => 'required'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['status']   = 'active';

        DB::beginTransaction();
        try {
            $voter = User::create($validatedData);
            $voter->assignRole('voter');
            DB::commit();
            return redirect()->route('voter.index')->with('successMessage', 'Voter successfully created!');
        } catch (\Exception $ex) {
            DB::rollback();
            \Artisan::call('cache:clear');
            return redirect()->route('voter.create')->with('errorMessage', $ex->getMessage());
        }

        return redirect()->route('voter.index')->with('errorMessage', 'An error has occurred please try again later!');
    }

    public function edit(User $voter)
    {
        return view('admin.voters.edit', compact( 'voter'));
    }

    public function update(Request $request, User $voter)
    {
        $validatedData = $request->validate([
            'name'                   => 'required|min:3|max:50',
            'status'                 => 'required',
        ]);

        try {
            $voter->update($validatedData);
            return redirect()->route('voter.index')->with('successMessage', 'Voter successfully updated!');
        } catch (\Exception $ex) {
            \Artisan::call('cache:clear');
            return redirect()->route('voter.edit', $voter->id)->with('errorMessage', $ex->getMessage());
        }

        return redirect()->route('voter.index')->with('errorMessage', 'An error has occurred please try again later!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voter  $voter
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $voter)
    {
        DB::beginTransaction();

        try {
            $voter->delete();
            DB::commit();
            return redirect()->route('voter.index')->with('successMessage', 'Voter successfully deleted!');
        } catch (\Exception $ex) {
            DB::rollback();
            \Artisan::call('cache:clear');
            return redirect()->route('voter.index')->with('errorMessage', $ex->getMessage());
        }

        return redirect()->route('voter.index')->with('errorMessage', 'An error has occurred please try again later!');
    }


}
