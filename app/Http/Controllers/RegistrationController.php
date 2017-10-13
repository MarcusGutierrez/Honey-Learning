<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;


use honeysec\User;

use Illuminate\Support\Facades\Hash;



class RegistrationController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function create()
    {
        session()->forget('experiment_completed');
    	return view('registration.create');
    }



    public function store()
    {
    	//validate the user
    	$this->validate(request(), [
    		'school' => 'required',
    		'favpet' => 'required',
    		'age' => 'required',
    		]);

        $users = User::all();
        $matched = false;
        
        $input_id = strtolower(request('user_id'));

        foreach ($users as $user) 
        {
            if(Hash::check($input_id, $user->user_hash))
            {
                $matched = true;
                break;
            }
        }

        if($matched==false)
        {
            // create the user and save
            $input_arr = array();
            $input_arr['user_hash'] = bcrypt($input_id);
            $user = User::create($input_arr);
        }
        
        //sign the user in
        auth()->login($user);

        // session variable
        //dd($user->user_id);
        session()->forget('user_id');
        session()->forget('ineligible');
        session()->forget('experiment_completed');
        session()->put('user_id', $user->id);
        
        /*
        $taken = \honeysec\User::takenSurvey($user->id, 'pre');
        if($taken)
            session()->put('survey_completed', true);
         */
        session()->flash('message' , 'Thanks for logging in');
        
        $def;
        if(mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax() > 0.5)
            $def = 'def2';
        else
            $def = 'def1';
        
        $page_path = [];
        $page_path[] = "/consent";
        //$page_path[] = "/survey/background";
        $page_path[] = "/instruction";
        $page_path[] = "/instruction/concept";
        $page_path[] = "/play/practice";
        $page_path[] = "/session/create/$def/";
        $page_path[] = "/survey/post";
        $page_path[] = "/survey/triad";
        $page_path[] = "/results/";
        session()->put('page_path', $page_path);
        //dd(session('user_id', ''));

        return redirect('/next');
    }
}