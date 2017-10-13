<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

use honeysec\User;
use Illuminate\Support\Facades\Hash;




class SessionsController extends Controller
{
    //


    public function __construct()
    {
    	$this->middleware('guest')->except(['destroy']);
    }



    public function create()
    {
    	return view('sessions.create');
    }




    public function store()
    {
        $users = User::all();
        $matched = false;

        foreach ($users as $user) 
        {
            
            //echo $user->user_id;

            if(Hash::check(request('user_id'), $user->user_hash))
            {
               // echo "Matched with one";
                $matched = true;
                auth()->login($user);

                //session variable 

                session('user_id', '');
                session(['user_id' => $user->user_hash ]);
                session()->flash('message' , 'Welcome! You are now logged in');
                //dd(session('user_id', ''));

                break;

            }


        }

        if($matched==false)
        {
           

            return redirect()->back()->withErrors([

                'message' => 'Check your credentials'

                ]);


        }
        


   


    	return redirect()->home();



    }



    public function destroy(Request $request)
    {


    	auth()->logout();
        
        $request->session()->forget('session_id');
        $request->session()->forget('session_completed');
        $request->session()->forget('concept_completed');
        $request->session()->forget('instruction_completed');
        $request->session()->forget('practice_completed');
        $request->session()->forget('consent_completed');
        $request->session()->forget('background_completed');
        $request->session()->forget('post_completed');
        $request->session()->forget('triad_completed');
        $request->session()->forget('defender_type');
        $request->session()->forget('network_id');
        $request->session()->forget('round_id');
        $request->session()->forget('round_number');
        $request->session()->forget('network_id');
        $request->session()->forget('user_id');

        session()->flash('message' , 'You are successfully logged out');

    	return redirect('/');

    }

    public function username()
    {
        return 'user_hash';
    }
}
