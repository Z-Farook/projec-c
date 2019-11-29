<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the account dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth/account');
    }

    public function admin_foods()
    {
        return view('auth/admin/foods');
    }
    public function admin_users()
    {
        return view('auth/admin/users');
    }

    public function admin()
    {
        return view('auth/admin/dashboard');
    }
    public function admin_movies()
    {
        return view('auth/admin/movies');
    }
    public function admin_actors()
    {
        return view('auth/admin/actors');
    }

    public function admin_rooms()
    {
        return view('auth/admin/rooms');
    }
    public function admin_shows()
    {
        return view('auth/admin/shows');
    }
}
