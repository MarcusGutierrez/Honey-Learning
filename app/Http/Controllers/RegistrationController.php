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
        
        /*
         * Obtains list of users that meet turk id constrains
         * (13+ characters, starting with the letter 'a' and only alphanumeric)
         * that have also completed the experiment
         */
        $completed_turkers = \honeysec\User::whereRaw('LENGTH(turk_id) > 12')
                            ->whereRaw('`turk_id` LIKE \'a%\'')
                            ->whereRaw('turk_id REGEXP \'[A-Za-z0-9]+$\'')
                            ->where('completed_experiments', 1)->pluck('id');
        
        /*$pure_count = Session::where('defender_type', 'pure highest')
                        ->whereIn('user_id', $completed_turkers)
                        ->where('completed', 1)
                        ->count();
        $fixed_count = Session::where('defender_type', 'fixed equilibria')
                        ->where('completed', 1)
                        ->whereIn('user_id', $completed_turkers)->count();
        $bandit_count = Session::where('defender_type', 'LLR Bandit')
                        ->where('completed', 1)
                        ->whereIn('user_id', $completed_turkers)->count();
        */
        $bresponse_count = Session::where('defender_type', 'Best Response')
                        ->where('completed', 1)
                        ->whereIn('user_id', $completed_turkers)->count();
        $pbresponse_count = Session::where('defender_type', 'Prob BR')
                        ->where('completed', 1)
                        ->whereIn('user_id', $completed_turkers)->count();
        $ftrl_count = Session::where('defender_type', 'FTRL')
                        ->where('completed', 1)
                        ->whereIn('user_id', $completed_turkers)->count();
        
        $min_count = min($bresponse_count, $pbresponse_count, $ftrl_count);
        $min_arr = array();
        
        /*if($pure_count == $min_count) {
            $min_arr[] = "def1";
        } if($fixed_count == $min_count) {
            $min_arr[] = "def2";
        } if($bandit_count == $min_count) {
            $min_arr[] = "def3";
        }*/ 
        if($bresponse_count == $min_count) {
            $min_arr[] = "def4";
        } if($pbresponse_count == $min_count) {
            $min_arr[] = "def5";
        } if($ftrl_count == $min_count) {
            $min_arr[] = "def6";
        }
        
        $rand_val = mt_rand(0, mt_getrandmax() -1) / mt_getrandmax();
        foreach($min_arr as $idx => $item){
            if($rand_val <= ($idx + 1)/count($min_arr)){
                $def = $item;
                break;
            }
        }
        
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