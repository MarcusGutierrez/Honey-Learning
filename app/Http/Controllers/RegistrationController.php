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
    		'turk_id' => 'required',
    		]);        
        $input_id = strtolower(request('turk_id'));
        $user = User::where('turk_id', $input_id)->first();

        if($user === null){
            // create the user and save
            $input_arr = array();
            $input_arr['turk_id'] = $input_id;
            $input_arr['consented'] = null;
            $input_arr['completed_experiments'] = 0;
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
        session()->put('consented', $user->consented);
        
        /*
        $taken = \honeysec\User::takenSurvey($user->id, 'pre');
        if($taken)
            session()->put('survey_completed', true);
         */
        session()->flash('message' , 'Thanks for logging in');
        
        $def;
        $rand_val = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        if($rand_val <= 1.0/3.0)
            $def = 'def1';
        else if($rand_val <= 2.0/3.0)
            $def = 'def2';
        else
            $def = 'def3';
        
        session()->put('defender_type', $def); //set session ID
        
        $page_path = [];
        $page_path[] = "/consent";
        //$page_path[] = "/survey/background";
        $page_path[] = "/instruction";
        $page_path[] = "/instruction/concept";
        $page_path[] = "/play/practice";
        $page_path[] = "/session/create/$def/";
        $page_path[] = "/survey/post";
        $page_path[] = "/survey/triad";
        $page_path[] = "/results";
        session()->put('page_path', $page_path);
        //dd(session('user_id', ''));

        return redirect('/consent');
    }
}