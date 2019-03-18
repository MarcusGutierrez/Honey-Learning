<?php

namespace honeysec\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function create_section($type) {
        $section = new \honeysec\Section_Stamp;
        $section->user_id = session()->get('user_id');
        $section->section_type = $type;
        $section->time_entered = current_time();
        $section->save();
    }
    
    public function store_section($type) {
        $section = \honeysec\Section_Stamp::where('user_id', session()->get('user_id', null))->get()->where('section_type', $type)->last();
        $section->time_completed = current_time();
        $section->save();
    }
    
    
    protected function action_index($idx) {
        switch($idx){
            case -1:
                return [];
            case 0:
                return [1, 2];
            case 1:
                return [1, 3, 4];
            case 2:
                return [1, 5];
            case 3:
                return [2, 3];
            case 4:
                return [2, 4];
            case 5:
                return [2, 5];
            case 6:
                return [3, 5];
            case 7:
                return [4, 5];
            default:
                return [];
        }
    }
    
    
    protected function ftrl_pullArm() {
        $round_number = session()->get('round_number');
        $session_id = session()->get('session_id');
        
        //Check if a move has been made because round number is 1 for the first 2 rounds
        $made_moves = \honeysec\Session::find($session_id)->moves->count() > 0;
        if($made_moves){
            $last_move = \honeysec\Session::find($session_id)->moves->last();
            $triggered_honeypot = $last_move->triggered_honeypot;
            $defenseStr = \honeysec\Session::find($session_id)->rounds->last()->defender_move;
            $defenseArr = explode("-", $defenseStr);
            $captured_node = $triggered_honeypot == 1 ? $last_move->node_id : -1;
            $feedback = array();
            foreach($defenseArr as $arm){
                if($captured_node == $arm){
                    $feedback[] = ($last_move->attacker_points / 40.0) - 1.0;
                } else {
                    $feedback[] = -1.0;
                }
            }
            
            $ftrl_L = session()->get('ftrl_L', null);
            $ftrl_x = session()->get('ftrl_x', null);
            
            for($i = 0; $i < count($defenseArr); $i++){
                $ftrl_L[$defenseArr[$i] - 1] += ($feedback[$i] + 1.0) / $ftrl_x[$defenseArr[$i] - 1];
            }
            for($i = 0; $i < count($ftrl_L); $i++){
                $ftrl_L[$i] -= 1.0;
            }
            
            session()->forget('ftrl_L');
            session()->put('ftrl_L', $ftrl_L);
        }
        
        $learning_rate = 1.0 / sqrt($round_number);
        $this->ftrl_solve_optimization($learning_rate);
        
        
        
        $output = $this->ftrl_sample();
        $output_shifted = [];
        
        $found_arm = false;
        $armIdx = -1;
        
        $defense = null;
        while(!$found_arm) {
            $armIdx++;
            $output_shifted = array();
            foreach($output as $arm){
                $output_shifted[] = $arm + 1;
            }
            
            //the output is a subset of the arm in question
            if(!array_diff($output_shifted, $this->action_index($armIdx))){
                $found_arm = true;
                $defense = $this->action_index($armIdx);
            }
            
        }
        
        return $defense;
    }
    
    
    private function ftrl_solve_optimization($learning_rate) {
        $ftrl_d = session()->get('ftrl_d', 5);
        $ftrl_m = session()->get('ftrl_m', 2);
        $ftrl_L = session()->get('ftrl_L', null);
        $ftrl_x = session()->get('ftrl_x', null);
        $ftrl_bias = session()->get('ftrl_bias', 0.0);
        $eps = session()->get('ftrl_eps', 1.0);
        $max_iteration = 100;
        $iteration = 1;
        $upper = -1;
        $lower = -1;
        $f = 200.0 * $eps; //Set to force first iteration
        $step_size = 1;
        
        while($iteration < $max_iteration && abs($f) >= (100.0 * $eps)){
            
            for($i = 0; $i < count($ftrl_x); $i++){
                $ftrl_x[$i] = $this->ftrl_solve_unconstrained($ftrl_L[$i], $ftrl_x[$i], $learning_rate);
            }
            
            $f = array_sum($ftrl_x) / floatval($ftrl_m);
            $df = $this->ftrl_hessian_inverse($learning_rate);
            $next_bias = $ftrl_bias + ($f / $df);
            
            if($f > 0.0){
                $lower = $ftrl_bias;
                if(!isset($upper)) {
                    $step_size *= 2;
                    if($next_bias > ($lower + $step_size)){
                        $ftrl_bias = ($lower + $step_size);
                    }
                } else if($next_bias > $upper){
                    $ftrl_bias = ($lower + $upper) / 2.0;
                }
            } else {
                $upper = $ftrl_bias;
                $ftrl_bias = $next_bias;
                if(!isset($lower)){
                    $step_size *= 2;
                    if($next_bias < ($upper - $step_size)){
                        $ftrl_bias = $upper - $step_size;
                    }
                } else {
                    if($next_bias < $lower){
                        $ftrl_bias = ($lower + $upper) / 2.0;
                    }
                }
            }
            $iteration++;
            
        }
        session()->forget('ftrl_x');
        session()->put('ftrl_x', $ftrl_x);
        
        session()->forget('ftrl_bias');
        session()->put('ftrl_bias', $ftrl_bias);
    }
    
    
    private function ftrl_solve_unconstrained($loss, $warm_start, $learningRate) {
        $x = $warm_start;
        $fx = 100000;
        $dfx = 100000;
        $dx = 100000;
        $gamma = session()->get('ftrl_gamma');
        $eps = session()->get('ftrl_eps', 1.0);
        
        do {
            $fx = $loss - (0.5 / sqrt($x)) + $gamma * (1.0 - log(1.0 - $x));
            $dfx = 0.25 / pow(sqrt($x), 3) + ($gamma / (1.0 - $x));
            $dx = $fx / $dfx;
            
            if($dx > $x)
                $dx = $x / 2;
            else if($dx < ($x - 1.0))
                $dx = ($x - 1.0) / 2.0;
            
            $x -= $dx;
        } while(abs($dx) >= $eps);
        
        return $x + $dx;
    }
    
    
    private function ftrl_hessian_inverse($learning_rate) {
        $inverse = 0.0;
        $ftrl_x = session()->get('ftrl_x', null);
        $gamma = session()->get('ftrl_gamma', 1.0);
        foreach($ftrl_x as $xi){
            $inverse += 1.0 / ((0.25 / pow($xi, 1.5)) + ($gamma / (1.0 - $xi)));
        }
        return ($inverse * $learning_rate);
    }
    
    
    private function ftrl_sample() {
        $ftrl_x = session()->get('ftrl_x', null);
        $m = session()->get('ftrl_m', 2);
        $x = $ftrl_x;
        arsort($x);
        $desc_keys = array_keys($x);
        
        $included = $ftrl_x;
        $remaining = array();
        foreach($included as $i){
            $remaining[] = 1.0 - $i;
        }
        
        $outer_sample = $this->ftrl_split_sample($included, $remaining);
        $weights = array();
        $cumulative = array();
        for($i = 0; $i < count($outer_sample); $i++){
            $weights[$i] = $outer_sample[$i]['prob'];
            $cumulative[$i] = ($i > 0) ? $weights[$i] + $cumulative[$i-1] : $weights[$i];
        }
        
        $left = -1;
        $right = -1;
        $r = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        for($i = 0; $i < count($outer_sample); $i++){
            if($r < $cumulative[$i]){
                $left = $outer_sample[$i]['left'];
                $right = $outer_sample[$i]['right'];
                break;
            }
        }
        
        $sample = [];
        if($left == ($right - 1)){
            $sample = range(0, $m);
        } else {
            $candidates = range($left, $right-1);
            shuffle($candidates);
            $firstArr = ($left > 0) ? range(0, $left - 1) : [];
            $secondArr = array_slice($candidates, 0, ($m - $left));
            $sample = array_merge($firstArr, $secondArr);
        }
        $action = array();
        foreach($sample as $s){
            $action[] = $desc_keys[$s];
        }
        
        return $action;
    }
    
    
    private function ftrl_split_sample($included, $remaining) {
        $d = session()->get('ftrl_d', 5);
        $m = session()->get('ftrl_m', 2);
        $eps = session()->get('ftrl_eps', 1.0);
        $prob = 1.0;
        $left = 0;
        $right = $d;
        $i = $right;
        
        $results = array();
        
        while($left < $right) {
            $i--;
            $active = ($m - $left) / ($right - $left);
            $inactive = 1.0 - $active;
            
            if($active == 0 || $inactive == 0){
                $results[] = array('prob'=>$prob, 'left'=>$left, 'right'=>$right);
                return $results;
            }
            $weight = min($included[$right - 1] / $active, $remaining[$left] / $inactive);
            $results[] = array('prob'=>$weight, 'left'=>$left, 'right'=>$right);
            $prob -= $weight;
            
            for($i = 0; $i < count($included); $i++){
                $included[$i] = $included[$i] - ($weight * $active);
            }
            for($i = 0; $i < count($remaining); $i++){
                $remaining[$i] = $remaining[$i] - ($weight * $inactive);
            }
            while($right > 0 && $included[$right - 1] <= $eps){
                $right--;
            }
            while($left < $d && $remaining[$left] <= $eps){
                $left++;
            }
        }
        if($prob > 0.0){
            $results[] = array('prob'=>$prob, 'left'=>$left, 'right'=>$right);
        }
        
        return $results;
    }
    

}
