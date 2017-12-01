<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

class GameSessionsController extends Controller
{
    
    protected $redirectTo = '/';
    
    public function __construct()
    {
        $this->middleware('preventBackHistory');
        $this->middleware('auth');
        $this->middleware('game_session')->except('create');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    
    private function get_defender_name($def_type){
        if($def_type == "def1")
            return "pure highest";
        else if($def_type == "def2")
            return "fixed equilibria";
        else if($def_type == "def3")
            return "LLR Bandit";
        return null;
    }
    
    /**$request->session()->put('defender_type', $def_type); //set session ID
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $def_type)
    {
        if($request->session()->get('session_id') == null) {
            $this->create_section("game session");
            
            $game_session = new \honeysec\Session;
            $game_session->session_start = current_time();
            $game_session->defender_type = $this->get_defender_name($def_type);
            $game_session->round_amount = 50;
            $game_session->user_id = $request->session()->get('user_id', null);
            //$game_session->session_start = date('Y/m/d h:i:s', time());
            if($game_session->save()){ //game session started
                $session_id = \honeysec\Session::latest($request->session()->get('user_id', null)); //acquire current session ID
                $request->session()->put('session_id', $session_id); //set session ID
                $request->session()->put('defender_type', $def_type); //set session ID
                $request->session()->put('session_completed', false); //set session ID
                $request->session()->put('round_number', 1);
                
                $networks = \honeysec\Honey_Network::where('is_practice', 0)->get();
                $network_id = $networks[mt_rand(0, count($networks) - 1)]->network_id;
                
                $request->session()->put('network_id', $network_id);
                
                if($def_type == 'def3'){
                    $nodes = \honeysec\Honey_Network::find($network_id)->nodes;
                    $N = count($nodes);
                    $LLR_max_value = \honeysec\Honey_Network::find($network_id)->nodes->where('node_id', '!=', 0)->max('value'); //bounds LLR to rewards [0, 1.0]
                    $LLR_rewards = array();
                    $LLR_theta = array();
                    $LLR_m = array();
                    for($i = 0; $i < $N; $i++){
                        $LLR_theta[] = 0;
                        $LLR_m[] = 0;
                        $LLR_rewards[] = 0;
                    }
                    
                    $LLR_combinations = array();
                    $budget = \honeysec\Honey_Network::find($network_id)->def_budget;
                    
                    $LLR_combinations = $this->powerSet(array(1, 2, 3, 4, 5));
                    foreach($LLR_combinations as $key => $comb){
                        if(count($comb) == 0){
                            unset($LLR_combinations[$key]);
                            continue;
                        }
                        
                        $b = $budget;
                        foreach($comb as $item){
                            $b -= $nodes[$item]->defender_cost;
                            
                            if($b < 0){
                                unset($LLR_combinations[$key]);
                                break;
                            }
                        }
                        
                        if($b > 0){
                            for($i = 1; $i < count($nodes); $i++){
                                if(in_array($i, $comb) != 1 && ($b - $nodes[$i]->defender_cost) >= 0)
                                    unset($LLR_combinations[$key]);
                            }
                            //echo in_array($i, $comb);
                        }
                    }
                    
                    $LLR_initial_order = array();
                    for($i = 1; $i < $N; $i++){ //array initialization
                        $LLR_initial_order[] = $i;
                    }
                    for($i = 0; $i < $N - 2; $i++){ //Fisher-Yates shuffle
                        $j = mt_rand($i, $N - 2);
                        $tmp = $LLR_initial_order[$j];
                        $LLR_initial_order[$j] = $LLR_initial_order[$i];
                        $LLR_initial_order[$i] = $tmp;
                    }
                    
                    session()->put('LLR_combinations', $LLR_combinations);
                    session()->put('LLR_initial_order', $LLR_initial_order);
                    session()->put('LLR_rewards', $LLR_rewards);
                    session()->put('LLR_theta', $LLR_theta);
                    session()->put('LLR_m', $LLR_m);
                    session()->put('LLR_max_value', $LLR_max_value);
                    
                }
                
                //dd($LLR_combinations);
                //$round_hash = str_replace("%","_", rawurlencode(bcrypt($request->session()->get('user_id', null))));

                //$request->session()->pull('pagepath', null); //empty page path
                //$request->session()->push('pagepath', "/play/defender/".$def_type."/network/".$network_id."/round/1");
                //$pagepath = $request->session()->get('pagepath', null);
                //return redirect()->route('play', ['gid' => 1]);
                return redirect("/play/round/1");
            }
        } else {
            $request->session()->flash('message' , 'Cannot create new session when current session is running');
            $round_number = $request->session()->get('round_number', 1);
            return redirect("/play/round/".$round_number);
        }
    }
    
    private function powerSet($array) {
        // add the empty set
        $results = array(array());

        foreach ($array as $element) {
            foreach ($results as $combination) {
                $results[] = array_merge(array($element), $combination);
            }
        }

        return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    
    public function results(Request $request)
    {
        $session_id = $request->session()->get('session_id', false);
        $completed = $request->session()->get('session_completed', false);
        $def_type = $this->get_defender_name($request->session()->get('defender_type', false));
        $network_id = $request->session()->get('network_id', false);
        $round_number = $request->session()->get('round_number', false);
        
        if($completed == true) {
            $params = array();
            $params['total_points'] = \honeysec\Session::totalAttackerPoints($session_id);
            $params['total_possible'] = \honeysec\Session::totalPossibleAttackerPoints($session_id);
            $params['honeypots_triggered'] = \honeysec\Session::find($session_id)->moves->sum('triggered_honeypot');
            $params['honeypots_total'] = \honeysec\Session::totalHoneypots($session_id);
            $params['total_passes'] = \honeysec\Session::totalPasses($session_id);
            $params['defender_type'] = $def_type;
            $params['session_code'] = "a".substr(md5($session_id."b73"), 0, 8)."7";
            
            $game_session = \honeysec\Session::find($request->session()->get('session_id', null));
            if($request->session()->get('session_completed', false) == true) {
                $game_session->completed = 1;
            }
            $game_session->session_end = current_time();
            $game_session->save();
            
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
            
            auth()->logout();
            $request->session()->put('experiment_completed', true);
            
            return view('honey.results')->with($params);
        } else {
            $request->session()->flash('message' , 'Please complete your session before reviewing the results page');
            return redirect("/play/round/".$round_number);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $game_session = \honeysec\Session::find($request->session()->get('session_id', null));
        if($request->session()->get('session_completed', false) == true) {
            $game_session->completed = 1;
        }
        $game_session->session_end = current_time();
        $game_session->save();
        
        $request->session()->forget('session_id');
        $request->session()->forget('defender_type');
        $request->session()->forget('session_completed');
        $request->session()->forget('network_id');
        $request->session()->forget('round_id');
        $request->session()->forget('round_number');
        
        $request->session()->flash('message' , "Thanks for playing");
        
        return redirect("/");
    }
}