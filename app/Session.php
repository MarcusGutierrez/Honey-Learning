<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $primaryKey = 'session_id';
    protected $table = 'sessions'; //Defines which table to use
    public $timestamps = false;
    
     public static function latest($uid) //honeysec\Session::latest($uid)
    {
        $session_id = static::where('user_id', '=', $uid)->max('session_id');
        if($session_id === null){
            return -1;
        }else{
            return $session_id;
        }
    }
    
    public static function totalAttackerPoints($session_id)
    {
        $sum = 0;
        $rounds = static::find($session_id)->rounds;
        foreach($rounds as $round){
            $sum += $round->moves->last()->attacker_points;
        }
        return $sum;
    }
    
    public static function totalPossibleAttackerPoints($session_id)
    {
        $totalvalue = 0;
        $totaldef = 0;
        $totalhpvalue = 0;
        $rounds = static::find($session_id)->rounds;
        foreach($rounds as $round){
            $defender_move = explode('-', $round->defender_move);
            if(count($defender_move) > 1 || $defender_move[0] != ""){
                foreach($defender_move as $hp){
                    $totalhpvalue += $round->network->nodes->where('node_id', $hp)->first()->value;
                }
            }
            $totalvalue += $round->network->nodes->sum('value');
            $totaldef += $round->network->nodes->sum('defender_cost');
        }
        return $totalvalue - $totaldef - $totalhpvalue;
    }
    
    public static function totalHoneypots($session_id)
    {
        $hps = 0;
        $rounds = static::find($session_id)->rounds;
        foreach($rounds as $round){
            $defender_move = explode('-', $round->defender_move);
            if(count($defender_move) > 1 || $defender_move[0] != ""){
                $hps += count($defender_move);
            }
        }
        return $hps;
    }
    
    public static function totalPasses($session_id)
    {
        $passes = static::find($session_id)->moves->where('node_id', 0)->count();
        return $passes;
    }
    
    public function user()
    {
        return $this->belongsTo('honeysec\User');
    }
    
    public function rounds()
    {
        return $this->hasMany('honeysec\Round', 'session_id');
    }
    
    public function moves()
    {
        return $this->hasManyThrough('\honeysec\Honey_History', '\honeysec\Round', 'session_id', 'round_id');
    }
}
