<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

class GameSessionsController extends Controller
{
    
    protected $redirectTo = '/';
    
    public function __construct()
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $def_type, $network_id)
    {   
        if($request->session()->get('session_id') == null) {
            $game_session = new \honeysec\Session;
            $game_session->defender_type = $def_type;
            $game_session->user_id = $request->session()->get('user_id', null);
            //$game_session->session_start = date('Y/m/d h:i:s', time());
            if($game_session->save()){ //game session started
                $session_id = \honeysec\Session::latest($request->session()->get('user_id', null)); //acquire current session ID
                $request->session()->put('session_id', $session_id); //set session ID
                $request->session()->put('defender_type', $def_type); //set session ID
                $request->session()->put('session_completed', false); //set session ID
                $request->session()->put('round_number', 1);
                $request->session()->put('network_id', $network_id);

                //$round_hash = str_replace("%","_", rawurlencode(bcrypt($request->session()->get('user_id', null))));

                $request->session()->pull('pagepath', null); //empty page path
                $request->session()->push('pagepath', "/play/defender/".$def_type."/network/".$network_id."/round/1");
                $pagepath = $request->session()->get('pagepath', null);
                //return redirect()->route('play', ['gid' => 1]);
                return redirect("/play/defender/".$def_type."/network/".$network_id."/round/1");
            }
        } else {
            $request->session()->flash('message' , 'Cannot create new session when current session is running');
            $round_number = $request->session()->get('round_number', 1);
            return redirect("/play/defender/".$def_type."/network/".$network_id."/round/".$round_number);
        }
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
        $def_type = $request->session()->get('defender_type', false);
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
            $params['session_code'] = "a".substr(md5($session_id."b73"), 0, 10)."7";
            
            return view('honey.results')->with($params);
        } else {
            $request->session()->flash('message' , 'Please complete your session before reviewing the results page');
            return redirect("/play/defender/".$def_type."/network/".$network_id."/round/".$round_number);
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