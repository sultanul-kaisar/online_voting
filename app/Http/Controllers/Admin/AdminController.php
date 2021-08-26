<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['role_or_permission:developer|super admin|master|global'],   ['only' => ['dashboard']]);
    }

    public function dashboard()
    {
        // $projects   = Project::all();
        // $blogs      = Blog::all();
        // $galleries  = Gallery::all();
        // $clients    = Client::all();
        return view('admin.dashboard');
    }
}
