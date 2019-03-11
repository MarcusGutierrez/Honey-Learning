<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;


use honeysec\User;
use honeysec\Session;

use Illuminate\Support\Facades\Hash;



class RegistrationController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('preventBackHistory');
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
        
        $pure_count = Session::where('defender_type', 'pure highest')->count();
        $fixed_count = Session::where('defender_type', 'fixed equilibria')->count();
        $bandit_count = Session::where('defender_type', 'LLR Bandit')->count();
        $bresponse_count = Session::where('defender_type', 'Best Response')->count();
        
        $min_count = min($pure_count, $fixed_count, $bandit_count);
        $min_arr = array();
        
        if($pure_count == $min_count)
            $min_arr[] = "def1";
        if($fixed_count == $min_count)
            $min_arr[] = "def2";
        if($bandit_count == $min_count)
            $min_arr[] = "def3";
        if($bresponse_count == $min_count)
            $min_arr[] = "def4";
        
        $rand_val = mt_rand(0, mt_getrandmax() -1) / mt_getrandmax();
        foreach($min_arr as $idx => $item){
            if($rand_val <= ($idx + 1)/count($min_arr)){
                $def = $item;
                break;
            }
        }
        
        /*
        $def;$pure_count = Session::where('defender_type', 'pure highest')->count();
        $rand_val = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        if($rand_val <= 1.0/3.0)
            $def = 'def1';
        else if($rand_val <= 2.0/3.0)
            $def = 'def2';
        else
            $def = 'def3';
        */
        
        $def = "def4";
        
        session()->put('defender_type', $def); //set session defender type
        
        $page_path = [];
        $page_path[] = "/consent"; //0
        $page_path[] = "/instruction/1"; //1
        $page_path[] = "/instruction/2"; //2
        $page_path[] = "/instruction/3"; //3
        $page_path[] = "/instruction/concept"; //4
        $page_path[] = "/play/practice"; //5
        $page_path[] = "/play"; //6
        $page_path[] = "/survey/post"; //7
        $page_path[] = "/survey/background"; //8
        $page_path[] = "/survey/triad"; //9
        $page_path[] = "/results"; //10
        session()->put('page_path', $page_path);
        session()->put('current_idx', 0);
        //dd(session('user_id', ''));

        return redirect('/consent');
    }
}