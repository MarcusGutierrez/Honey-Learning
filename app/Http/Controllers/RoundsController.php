<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use honeysec\Honey_Network;
use honeysec\Honey_Node;

class RoundsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('game_session')->except('practice_round', 'network_params', 'next_round');
    }
    
    public function network_params(Request $request){
        $network_id = $request->session()->get('network_id', 2);
        
        $atkAttempts = Honey_Network::find($network_id)->atk_attempts;
        $totalValue = Honey_Node::inGameID($network_id)->valueSum();

        $params = array();
        $params['atk_attempts'] = $atkAttempts;
        $params['total_value'] = $totalValue;

        return $params;
    }
    
    private function uniRand($network_id){
        $hpArr = array();
        $game = Honey_Network::find($network_id);
        $honey_nodes = Honey_Node::inGameID($network_id)->get();
        $numNodes = Honey_Node::inGameID($network_id)->get()->count();
        $hp = rand(1, $numNodes - 1);
        //$honey_nodes[$hp]['is_honeypot'] = 1;
        //return $honey_nodes;
        $hpArr[] = $hp;
        return $hpArr;
    }
    
    private function highestValue($network_id){
        $hpArr = array();
        $game = Honey_Network::find($network_id);
        $honey_nodes = Honey_Node::inGameID($network_id)->get();
        $numNodes = Honey_Node::inGameID($network_id)->get()->count();
        
        $budget = $game->def_budget;
        
        while($budget > 0){
            $maxValue = -1;
            $maxNode = -1;
            foreach($honey_nodes as $key => $node){
                //If node has a higher value, meets budget, and is not already a honeypot
                if((($node['value'] - $node['attacker_cost']) > $maxValue) && ($node['defender_cost'] <= $budget) && ($node['is_honeypot'] === 0)){
                    $maxValue = $node['value']-$node['attacker_cost'];
                    $maxNode = $key;
                }
                //echo "Max Node:".$maxNode."<br>";
                //echo "Max Value:".$maxValue."<br>";
            }
            if($maxNode > -1){ //If a node was selected
                //$honey_nodes[$maxNode]['is_honeypot'] = 1;
                $hpArr[] = $maxNode;
                $budget -= $honey_nodes[$maxNode]['defender_cost'];
            }else{
                $budget = 0;
            }
        }
        return $hpArr;
    }
    
    private function defender_move(Request $request, $defender_type, $network_id)
    {
        $data = null;
        switch($defender_type){
            case "def1":
                $honey_nodes = $this->uniRand($network_id);
                break;
            case "def2":
                $honey_nodes = $this->highestValue($network_id);
                break;
            default:
                $honey_nodes = array();
        }
        return $honey_nodes;
    }
    
    private function remainingNodes($budget, $nodes){
        $remaining_nodes = array();
        foreach($nodes as $i){
            if($i['def_cost'] <= $budget){
                $remaining_nodes[] = $i;
            }
        }
        return $remaining_nodes;
    }
    
    public function defround(Request $request, $defender_type, $network_id){
        $honey_network = Honey_Network::find($network_id);
        $honey_nodes = Honey_Node::inGameID($network_id)->get();
        
        $hpArr = $this->defender_move($request, $defender_type, $network_id);
        
        foreach($hpArr as $i){
            $honey_nodes[$i]['is_honeypot'] = 1;
        }
        
        return view('honey.honey_one', compact('honey_network'), compact('honey_nodes'));
    }
    
    public function round_create(Request $request, $defender_type, $network_id, $round_number){
        $session_completed = $request->session()->get('session_completed', false);
        if($session_completed == false){
            
            $correct_round = $request->session()->get('round_number');
            if($correct_round == $round_number){
                $honey_network = Honey_Network::find($network_id);
                $honey_nodes = Honey_Node::inGameID($network_id)->get();

                $hpArr = $this->defender_move($request, $defender_type, $network_id);

                $defDB = "";
                foreach($hpArr as $i){
                    $honey_nodes[$i]['is_honeypot'] = 1;
                    $defDB .= $honey_nodes[$i]['node_id']."-";
                }
                $defDB = substr($defDB, 0, strlen($defDB) - 1);



                $session_id = $request->session()->get('session_id');
                $round_id = $request->session()->get('round_id');
                $round_number = $request->session()->get('round_number');

                $is_round = \honeysec\Round::where('session_id', $session_id)->where('network_id', $network_id)->where('round_id', $round_id)->first();

                if($is_round == null){ //Create round if it has not been created yet
                    $round = new \honeysec\Round;
                    $round->session_id = $session_id;
                    $round->network_id = $network_id;
                    $round->round_number = $round_number;
                    $round->defender_move = $defDB;
                    $round->round_start = current_time();
                    $round->save();
                    
                    $r = \honeysec\Round::where('session_id', $session_id)->where('network_id', $network_id)->where('round_number', $round_number)->first();
                    $round_id = $r->round_id;
                    $request->session()->put('round_id', $round_id);
                }

            } else {
                $request->session()->flash('message' , "Current round: ".$correct_round);
                return redirect("/play/defender/".$defender_type."/network/".$network_id."/round/".$correct_round);
            }
            
            $lastround = false;
            if($round_number == 5){
                $lastround = true;
            }
            
            $rounds = array();
            $rounds['round_number'] = $round_number;
            $rounds['lastround'] = $lastround;
            $rounds['max_round'] = 5;

            //return $this->defround($request, $defender_type, $network_id);
            return view('honey.honey_one', compact('honey_network'), compact('honey_nodes'))->with($rounds);
        } else {
            $request->session()->flash('message' , "Game Session completed");
            return redirect("/session/destroy");
        }
    }
    
    public function practice_round(Request $request)
    {
        $practice_networks = Honey_Network::where('is_practice', 1)->get();
        $honey_network = $practice_networks[mt_rand(0, count($practice_networks))];
        $honey_nodes = $honey_network->nodes;
        
        $request->session()->put('network_id', 2);
        $request->session()->put('round_id', 0);
        
        $rounds = array();
        $rounds['round_number'] = 1;
        $rounds['lastround'] = true;
        $rounds['max_round'] = 1;

        //return $this->defround($request, $defender_type, $network_id);
        return view('honey.honey_one', compact('honey_network'), compact('honey_nodes'))->with($rounds);
    }
    
    public function round_store(Request $request){
        $round_number = $request->session()->get('round_number');
        $request->session()->forget('round_id');
        //console.log("STORE TEST: ".$round_id);
        if($round_number == 5) { //END session
            $request->session()->put('session_completed', true);
            return "completed";
        } else {
            $round_number++;
            $request->session()->put('round_number', $round_number);
            return $round_number;
        }
    }
    
    public function next_round(Request $request){
        $network_id = $request->session()->get('network_id', null);
        $is_practice = \honeysec\Honey_Network::find($network_id)->is_practice;
        if($is_practice == 1){
            $request->session()->put('practice_completed', true);
            return redirect('/')->with('message', 'You may now play the real game');
        }
        
        $session_completed = $request->session()->get('session_completed', false);
        
        if($session_completed == false) {
            $def = $request->session()->get('defender_type');
            $network_id = $request->session()->get('network_id');
            $round_number = $request->session()->get('round_number');

            return redirect("/play/defender/".$def."/network/".$network_id."/round/".$round_number);
        } else {
            return redirect('/results/')->with('message', 'Thanks for playing');
        }
    }
    
}
