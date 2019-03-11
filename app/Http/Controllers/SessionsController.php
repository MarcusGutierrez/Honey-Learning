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
        
        session()->forget('session_id');
        session()->forget('network_id');
        session()->forget('round_id');
        session()->forget('network_id');
        session()->forget('user_id');

        session()->forget('session_completed');
        session()->forget('concept_completed');
        session()->forget('instruction_completed');
        session()->forget('practice_completed');
        session()->forget('consent_completed');
        session()->forget('background_completed');
        session()->forget('post_completed');
        session()->forget('triad_completed');

        session()->forget('consented');
        session()->forget('defender_type');
        session()->forget('round_number');

        session()->forget('page_path');
        //session()->forget('current_idx');

        session()->forget('LLR_combinations');
        session()->forget('LLR_initial_order');
        session()->forget('LLR_rewards');
        session()->forget('LLR_theta');
        session()->forget('LLR_m');
        session()->forget('LLR_max_value');
        
        session()->forget('br_look_ahead');
        session()->forget('br_sampled_states');
        session()->forget('br_history_length');
        session()->forget('br_history');
        session()->forget('br_output');

        session()->flash('message' , 'You are successfully logged out');

    	return redirect('/');

    }

    public function username()
    {
        return 'user_hash';
    }
}
