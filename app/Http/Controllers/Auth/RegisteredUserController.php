<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
       
        /*$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            
        ]);*/
        $request->validate([
           
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
  
    ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => '1',
        ]);
       
        event(new Registered($user));

        Auth::login($user);

        //return redirect(RouteServiceProvider::HOME);
    }

    public function login(Request $request)
    {
        if(\Auth::attempt($request->only('email','password')))
        {
           $response=[
            'success'=>true,
            'message'=>'you can use for again login',
            'token'=>$request->user()->createToken('devloan')->plainTextToken

           ];
           return response()->json($response,200); 
        }
        else{
            $response=[
                'success'=>false,
                'message'=>'Missmatch User and Password'
                
    
               ];
               return response()->json($response,201); 
        }

        
    }
}
