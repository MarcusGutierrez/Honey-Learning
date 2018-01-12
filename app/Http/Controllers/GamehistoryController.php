<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

class GamehistoryController extends Controller
{
    //
    
    
    public function storehoneymove(Request $request){
        
        //$user_id = $request->session()->get('user_id');
        $network_id = $request->session()->get('network_id', null);
        $round_id = $request->session()->get('round_id', null);
        $is_practice = \honeysec\Honey_Network::find($network_id)->is_practice;
        //$session_id = $request->session()->get('session_id');
        
        if($is_practice == 0){
            $gamehistory = new \honeysec\Honey_History;
            //$gamehistory->user_id = $user_id;
            //$gamehistory->network_id = $network_id;
            $gamehistory->round_id = $round_id;
            //$gamehistory->session_id = $session_id;
            $gamehistory->attack_attempt = request('atk_attempt');
            $gamehistory->node_id = request('atk_target');
            $gamehistory->attacker_points = request('atk_points');
            $gamehistory->defender_points = request('def_points');
            $gamehistory->passed = request('atk_passed');
            $gamehistory->timed_out = request('atk_timedout');
            $gamehistory->triggered_honeypot = request('honeypotted');
            $gamehistory->move_time = format(request('time_attacker_moved'));
            //$gamehistory->move_time = 1502905735535;
            $gamehistory->save();

            return request()->all();
        }else{
            return request()->all();
        }
    }
    
    public function storehoneytentative(Request $request){
        //$user_id = $request->session()->get('user_id');
        $network_id = $request->session()->get('network_id', null);
        $is_practice = \honeysec\Honey_Network::find($network_id)->is_practice;
        $round_id = $request->session()->get('round_id', null);
        //$session_id = $request->session()->get('session_id');
        
        if($is_practice == 0){
            $gamehistory = new \honeysec\Honey_Tentative;
            //$gamehistory->user_id = $user_id;
            //$gamehistory->network_id = $network_id;
            $gamehistory->round_id = $round_id;
            //$gamehistory->session_id = $session_id;
            $gamehistory->attack_attempt = request('atk_attempt');
            $gamehistory->node_id = request('atk_target');
            $gamehistory->move_time = format(request('time_attacker_moved'));
            $gamehistory->save();

            return request()->all();
        }else{
            return request()->all();
        }
    }
    
}
