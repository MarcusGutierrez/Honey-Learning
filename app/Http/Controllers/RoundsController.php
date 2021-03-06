<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use honeysec\Honey_Network;
//use honeysec\Honey_Node;

class RoundsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('preventBackHistory');
        $this->middleware('consented');
        $this->middleware('auth');
        $this->middleware('game_session')->except('practice_round', 'network_params', 'next_round');
    }
    
    public function network_params(Request $request){
        $network_id = $request->session()->get('network_id', -1);
        
        $atkAttempts = Honey_Network::find($network_id)->atk_attempts;
        $totalValue = Honey_Network::find($network_id)->nodes->pluck('value')->sum();

        $params = array();
        $params['atk_attempts'] = $atkAttempts;
        $params['total_value'] = $totalValue;
        
        
        if(session()->get('session_id', false)){
            $params['total_attacker_points'] = \honeysec\Session::totalAttackerPoints(session()->get('session_id', null));
        }else
            $params['total_attacker_points'] = 0;

        return $params;
    }
    
    private function LLR_Bandit($network_id){
        $game = Honey_Network::find($network_id);
        $nodes = Honey_Network::find($network_id)->nodes;
        $L = count($nodes)-1;
        $hpArr = array();
        $round_number = session()->get('round_number', null);
        
        if($round_number <= $L){ //Initialization
            $LLR_initial_order = session()->get('LLR_initial_order', null);
            $hpArr[] = $LLR_initial_order[$round_number-1];
            $budget = $game->def_budget - $nodes[$LLR_initial_order[$round_number-1]]->defender_cost;
            
            $keys = array_keys(json_decode($nodes, true));
            foreach($nodes as $key => $node){
                if($node->is_honeypot == 1 || $node->defender_cost > $budget || $node->node_id == 0 || $node->node_id == $hpArr[0]){
                    unset($keys[$key]);
                }
            }
            
            $has_more = false;
            foreach($keys as $remaining_node){
                if($nodes[$remaining_node]->defender_cost <= $budget){
                    $has_more = true;
                    break;
                }
            }
            if($has_more == false)
                $budget = 0;
            
            while($budget > 0){
                $keys = array_values($keys);
                
                $rand_node = mt_rand(0, count($keys) - 1);
                $budget -= $nodes[$keys[$rand_node]]->defender_cost;
                $hpArr[] = $keys[$rand_node];
                unset($keys[$rand_node]);
                
                foreach($keys as $k => $key_item){
                    if($nodes[$key_item]->defender_cost > $budget)
                        unset($keys[$k]);
                }
                
                $has_more = false;
                foreach($keys as $remaining_node){
                    if($nodes[$remaining_node]->defender_cost <= $budget){
                        $has_more = true;
                        break;
                    }
                }
                if($has_more == false)
                    $budget = 0;
            }
            session()->put('LLR_latest_arm', $hpArr);
            return $hpArr;
        }else{ //Majority of algorithm
            $LLR_combinations = session()->get('LLR_combinations', null);
            $LLR_values = array();
            $LLR_L = session()->get('LLR_L', null);
            $LLR_theta = session()->get('LLR_theta', null);
            $LLR_m = session()->get('LLR_m', null);
            
            foreach($nodes as $key => $arm){
                if($arm->defender_cost == 0){
                    continue;
                }
                
                $numerator = ($LLR_L + 1)*log($round_number);
                $LLR_values[$key] = $LLR_theta[$key] + sqrt($numerator / $LLR_m[$key]);
            }
            $max_combination = array();
            $max_value = 0;
            foreach($LLR_combinations as $comb){
                $llr_val = 0;
                $comb_string = "";
                foreach($comb as $arm){
                    $llr_val += $LLR_values[$arm];
                    $comb_string .= $arm."-";
                }
                substr($comb_string, 0, -1);
                if($llr_val > $max_value){
                    $max_value = $llr_val;
                    $max_combination = $comb;
                }
            }
            session()->put('LLR_latest_arm', $max_combination);
            return $max_combination;
        }
    }
    
    
    
    
    /* 
     * Grabs the stored output from the tsbr-online executable to play as the
     * current round's defense. In the event that executable is not finsihed
     * computing, this function will wait 5 millisecond intervals at a time. If
     * the executable takes longer than 2 seconds, it will time-out and not play
     * a defense.
     * 
     * @warning best response will likely overwrite the session variable even
     * after killed
     */
    private function Best_Response($network_id) {
        //$round_number = session()->get('round_number');
        $session_id = session()->get('session_id');
        
        
        $made_moves = \honeysec\Session::find($session_id)->moves->count() > 0;
        if($made_moves){
            $last_move = \honeysec\Session::find($session_id)->moves->last();
            $triggered_honeypot = $last_move->triggered_honeypot;
            $captured_node = $triggered_honeypot == 1 ? ($last_move->node_id - 1) : -1;
        }
        
        $path = session()->get('br_path', null);
        $look_ahead = session()->get('br_look_ahead', 1);
        $sampled_states = session()->get('br_sampled_states', 100);
        $history_length = session()->get('br_history_length', 0);
        $history = session()->get('br_history', "");
        
        if(isset($captured_node))
            $history .= " ".$captured_node;
        
        $cmd = $path;
        $cmd .= " ".$look_ahead;
        $cmd .= " ".$sampled_states;
        $cmd .= " ".$history_length;
        $cmd .= $history;
        session()->put('cmd', $cmd);
        
        //dd($cmd);
        
        $output = null;
        exec($cmd, $output);
        while(!isset($output))
            usleep(500);
        
        $output_idx = str_replace("Final Best Action = ", "", $output[0]);
        $cmd = session()->get('cmd');
        
        //dd($output_idx);
        
        $history .= " ".$output_idx;
        session()->put('br_history', $history);
        
        $history_length = session()->get('br_history_length', 0);
        session()->put('br_history_length', $history_length + 1);
        
        return $this->action_index($output_idx);
    }
    
    
    private function uniRand($network_id){
        $hpArr = array();
        $game = Honey_Network::find($network_id);
        $numNodes = $game->nodes->count();
        $hp = mt_rand(1, $numNodes - 1);
        //$honey_nodes[$hp]['is_honeypot'] = 1;
        //return $honey_nodes;
        $hpArr[] = $hp;
        return $hpArr;
    }
    
    private function highestValue($network_id){
        $hpArr = array();
        $game = Honey_Network::find($network_id);
        $honey_nodes = $game->nodes;
        
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
                $honey_nodes[$maxNode]['is_honeypot'] = 1;
                $hpArr[] = $maxNode;
                $budget -= $honey_nodes[$maxNode]['defender_cost'];
            }else{
                $budget = 0;
            }
        }
        return $hpArr;
    }
    
    private function oneshotEquilibria($network_id){
        $possible_moves = \honeysec\Equilibria::where('network_id', $network_id)->get();
        $hpArr = array();
        $fixed = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        $cumulative = 0.0;
        foreach($possible_moves as $move){
            $cumulative += $move->probability;
            if($fixed <= $cumulative){
                $hpArr = explode("-", $move->defender_move);
                break;
            }
        }
        return $hpArr;
    }
    
    private function defender_move(Request $request, $defender_type, $network_id)
    {
        //$data = null;
        switch($defender_type){
            case "def1":
                $honey_nodes = $this->highestValue($network_id);
                break;
            case "def2":
                $honey_nodes = $this->oneshotEquilibria($network_id);
                break;
            case "def3":
                $honey_nodes = $this->LLR_Bandit($network_id);
                break;
            case "def4": case "def5":
                $honey_nodes = $this->Best_Response($network_id);
                break;
            case "def6":
                $honey_nodes = $this->ftrl_pullArm();
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
        $honey_nodes = $honey_network->nodes;
        
        $hpArr = $this->defender_move($request, $defender_type, $network_id);
        
        foreach($hpArr as $i){
            $honey_nodes[$i]['is_honeypot'] = 1;
        }
        
        return view('honey.honey_one', compact('honey_network'), compact('honey_nodes'));
    }
    
    
    public function round_create(Request $request){
        $session_id = session()->get('session_id');
        $round_amount = \honeysec\Session::find(session()->get('session_id'))->round_amount;
        $round_number = session()->get('round_number', null);
        $last_move = $round_number;
        if($round_number > 1)
            $last_move = \honeysec\Session::lastMoveNumber($session_id);
        $session_completed = $last_move >= $round_amount;
        
        $defender_type = session()->get('defender_type', null);
        $network_id = session()->get('network_id', null);
        if($session_completed == false){
            
            $round_amount = \honeysec\Session::find($session_id)->round_amount;
            
            $honey_network = Honey_Network::find($network_id);
            $honey_nodes = $honey_network->nodes;

            $hpArr = $this->defender_move($request, $defender_type, $network_id);

            $defDB = "";
            foreach($hpArr as $i){
                $honey_nodes[$i]['is_honeypot'] = 1;
                $defDB .= $honey_nodes[$i]['node_id']."-";
            }
            $defDB = substr($defDB, 0, strlen($defDB) - 1);


            $session_id = $request->session()->get('session_id', null);
            $round_id = $request->session()->get('round_id', null);
            $round_number = $request->session()->get('round_number', null);
            
            $moves = \honeysec\Session::find($session_id)->moves;
            if($moves->count() > 0){
                $round_number = $moves->last()->round->round_number + 1;
                session()->put('round_number', $round_number);
            }

            //$is_round = \honeysec\Round::where('session_id', $session_id)->get()->where('round_number', $round_number)->first();
            $is_round = \honeysec\Round::findWithNumber($session_id, $round_number);

            if($is_round == null){ //Create round if it has not been created yet
                $round = new \honeysec\Round;
                $round->session_id = $session_id;
                $round->network_id = $network_id;
                $round->round_number = $round_number;
                $round->cumulative_score = \honeysec\Session::totalAttackerPointsRound($session_id, $round_number);
                $round->defender_move = $defDB;
                $round->round_start = current_time();
                $round->save();

                $round_id = $round->round_id;
                session()->put('round_id', $round_id);
            }else{ //round exists
                session()->put('round_id', $is_round->round_id);
                session()->put('round_number', $is_round->round_number);
                $is_round->cumulative_score = \honeysec\Session::totalAttackerPointsRound($session_id, $round_number);
            }

            
            
            $lastround = false;
            if($round_number == $round_amount){
                $lastround = true;
            }
            
            $atkAttempts = Honey_Network::find($network_id)->atk_attempts;
            $totalValue = Honey_Network::find($network_id)->nodes->pluck('value')->sum();
            
            $rounds = array();
            $rounds['round_id'] = $round_id;
            $rounds['round_number'] = $round_number;
            $rounds['lastround'] = $lastround;
            $rounds['max_round'] = $round_amount;
            
            $rounds['atk_attempts'] = $atkAttempts;
            $rounds['total_value'] = $totalValue;
            $rounds['round_id'] = $round_id;
            if(session()->get('session_id', false)){
                $rounds['total_attacker_points'] = \honeysec\Session::totalAttackerPoints(session()->get('session_id', null));
            }else
                $rounds['total_attacker_points'] = 0;

            
            //$cmd = session()->get('cmd');
            //session()->flash('message' , $cmd);
            //dd($cmd);
            
            //return $this->defround($request, $defender_type, $network_id);
            return view('honey.honey_one', compact('honey_network'), compact('honey_nodes'))->with($rounds);
        } else {
            session()->put('session_completed', true);
            return $this->next_round($request);
        }
    }
    
    public function practice_round(Request $request)
    {
        $practice_networks = Honey_Network::where('is_practice', 1)->get();
        $honey_network = $practice_networks[mt_rand(0, count($practice_networks) - 1)];
        $honey_nodes = $honey_network->nodes;
        
        $request->session()->put('network_id', $honey_network->network_id);
        $request->session()->put('round_id', 0);
        
        $atkAttempts = $honey_network->atk_attempts;
        $totalValue = $honey_network->nodes->pluck('value')->sum();
        
        $rounds = array();
        $rounds['round_number'] = 1;
        $rounds['lastround'] = true;
        $rounds['max_round'] = 1;
        
        $rounds['atk_attempts'] = $atkAttempts;
        $rounds['total_value'] = $totalValue;
        $rounds['round_id'] = 0;
        if(session()->get('session_id', false)){
            $rounds['total_attacker_points'] = \honeysec\Session::totalAttackerPoints(session()->get('session_id', null));
        }else
            $rounds['total_attacker_points'] = 0;

        //return $this->defround($request, $defender_type, $network_id);
        return view('honey.honey_one', compact('honey_network'), compact('honey_nodes'))->with($rounds);
    }
    
    public function round_store(Request $request){
        
        $session_id = session()->get('session_id', null);
        $round_number = session()->get('round_number', null);
        
        $round_amount = \honeysec\Session::find($session_id)->round_amount;
        //$round = \honeysec\Round::find(session()->get('round_id', null));
        $round = \honeysec\Round::find(request('round_id'));
        
        //$old_cumulative = 0;
        //if(\honeysec\Round::findWithNumber($session_id, $round_number-1) != null)
            //$old_cumulative = \honeysec\Round::findWithNumber($session_id, $round_number-1)->cumulative_score;
        
        //$new_points = request('attacker_points');
        //$round->cumulative_score = \honeysec\Session::totalAttackerPointsRound($session_id, $round_number);
        
        $round->round_end = current_time();
        
        
        if($round_number >= $round_amount) { //END session
            $request->session()->put('session_completed', true);
            $request->session()->save();
            return "completed";
        } else {
            $def = session()->get('defender_type');

            if($def == 'def3'){
                $LLR_latest_arm = session()->get('LLR_latest_arm', null);
                
                $LLR_m = session()->get('LLR_m', null);
                $LLR_theta = session()->get('LLR_theta', null);
                $LLR_rewards = session()->get('LLR_rewards', null);
                
                $max_value = session()->get('LLR_max_value', null);
                //$user_id = session()->get('user_id', null);
                $session_id = session()->get('session_id', null);
                $nodes = \honeysec\Honey_Network::find(session()->get('network_id', null))->nodes;
                $last_round = $round->moves;
                
                for($i = 0; $i < count($LLR_latest_arm); $i++){
                    $LLR_m[$LLR_latest_arm[$i]] += 1;
                    
                    foreach($last_round as $move){
                        if($move->node_id == $LLR_latest_arm[$i]){
                            $LLR_rewards[$LLR_latest_arm[$i]] += $nodes[$LLR_latest_arm[$i]]->value / $max_value;
                            break;
                        }
                    }
                    $LLR_theta[$LLR_latest_arm[$i]] = $LLR_rewards[$LLR_latest_arm[$i]]/$LLR_m[$LLR_latest_arm[$i]];
                }
                
                session()->put('LLR_m', $LLR_m);
                session()->put('LLR_rewards', $LLR_rewards);
                session()->put('LLR_theta', $LLR_theta);
                
            } else if($def == 'def4') {
                
            }
            
            $round->save();
            //$round_number++;
            //session()->put('round_number', $round_number);
            
            return $round_number;
        }
    }
    
    public function next_round(Request $request){
        $network_id = session()->get('network_id', null);
        $is_practice = \honeysec\Honey_Network::find($network_id)->is_practice;
        if($is_practice == 1){
            if(session()->get('current_idx', null) == 5){
                session()->put('current_idx', 6);
            }
            session()->put('practice_completed', true);
            return redirect('/pregame');
        }
        
        //$session_completed = session()->get('session_completed', false);
        $round_amount = \honeysec\Session::find(session()->get('session_id'))->round_amount;
        $round_number = session()->get('round_number', null);
        $session_completed = $round_number >= $round_amount;
        
        if($session_completed == false) {
            
            //$def = session()->get('defender_type');
            $network_id = session()->get('network_id');
            $session_id = session()->get('session_id');
            $round_number = session()->get('round_number');
            
            
            return redirect("/play");
        } else {
            $session_id = session()->get('session_id', null);
            $rounds = \honeysec\Session::find($session_id)->rounds;
            foreach($rounds as $r){
                $r->cumulative_score = \honeysec\Session::totalAttackerPointsRound($session_id, $r->round_number);
                $r->save();
            }
            $last_round = $rounds->last();
            if($last_round->round_end == null){
                $last_round->round_end = $last_round->moves->first()->move_time;
                $last_round->save();
            }
            
            if(session()->get('current_idx', null) == 6){
                session()->put('current_idx', 7);
            }
            
            session()->put('session_completed', true);
            
            $this->store_section("game session");
            return redirect('/survey/post')->with('message', 'Please complete our post game survey');
        }
    }
    
}