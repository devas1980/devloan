<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function store(Request $request)
    {
      
        $role = Role::create([
            'role' => $request->role,
           
        ]);
      
       
       //return redirect('welcome');
      
    }
}
