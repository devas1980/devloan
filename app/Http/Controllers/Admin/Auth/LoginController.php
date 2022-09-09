<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show()
    {
        return view('admin.auth.login');
    }

    public function login()
    {
        if(\Auth::guard('web_admin')->attempt($request->only('email','password')))
        {
            return redirect()->route('admin.dashboard');

        }

        return redirect()->back()->with('Error','Invalid Credentials');
    }
}
