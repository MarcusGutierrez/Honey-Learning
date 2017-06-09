<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

class GamehistoryController extends Controller
{
    //

    public function store()
    {

    	//return request()->all();


    	$gamehistory = new \honeysec\Gamehistory;

        $gamehistory->game_id = request('gameid');
        $gamehistory->user_id = request('user_id');
        $gamehistory->round = request('round');
        $gamehistory->defender_action = request('defender_action');
        $gamehistory->attacker_action = request('attacker_action');
        $gamehistory->time_defender_moved = request('time_defender_moved');
        $gamehistory->time_attacker_moved = request('time_attacker_moved');
        $gamehistory->defender_points = request('defender_points');
        $gamehistory->attacker_points = request('attacker_points');


        $gamehistory->save();

        return request()->all();



    }
    
    
    public function storehoneymove(){
        $gamehistory = new \honeysec\Honey_History;
        $gamehistory->user_id = request('uid');        
        $gamehistory->game_id = request('gid');
        $gamehistory->instance = request('instance');
        $gamehistory->round = request('rnd');
        $gamehistory->node_id = request('atk_move');
        $gamehistory->attacker_points = request('atk_points');
        $gamehistory->defender_points = request('def_points');
        $gamehistory->triggered_honeypot = request('honeypotted');
        $gamehistory->move_time = request('time_attacker_moved');
        $gamehistory->save();

        return request()->all();
    }



    public function storetentative()
    {

    	//return request()->all();


    	$gametentativehistory = new \honeysec\GameTentativeHistory;

        $gametentativehistory->game_id = request('gameid');
        $gametentativehistory->user_id = request('user_id');
        $gametentativehistory->round = request('round');
        $gametentativehistory->defender_action = request('defender_action');
        $gametentativehistory->attacker_action = request('attacker_action');
        $gametentativehistory->time_defender_moved = request('time_defender_moved');
        $gametentativehistory->time_attacker_moved = request('time_attacker_moved');
        $gametentativehistory->defender_points = request('defender_points');
        $gametentativehistory->attacker_points = request('attacker_points');


        $gametentativehistory->save();

        return request()->all();



    }
    
    public function storehoneytentative(){
        $gamehistory = new \honeysec\Honey_Tentative;
        $gamehistory->user_id = request('uid');        
        $gamehistory->game_id = request('gid');
        $gamehistory->instance = request('instance');
        $gamehistory->round = request('rnd');
        $gamehistory->node_id = request('atk_move');
        $gamehistory->move_time = request('time_attacker_moved');
        $gamehistory->save();

        return request()->all();
    }
    
}
