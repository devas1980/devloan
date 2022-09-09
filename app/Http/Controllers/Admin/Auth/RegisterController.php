<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return('admin.auth.register');
    }

    public function register(Request $request)
    {
        $payload = $requet->only('email','name');
        $payload['passsword'] = bcrypt($request->input('password'));

        Admin::create($payload);
        return response()->redirect('');
    }
}
