<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Honey_History extends Model
{
    protected $table = 'honey_attack_move'; //Defines which table to use
    
    public static function nextInstance($uid, $gid) //honeysec\Honey_Node::gameID(1)->get()
    {
        $instance = static::where('user_id', '=', $uid)->where('game_id', '=', $gid)->max('instance');
        if($instance === null){
            return 0;
        }else{
            return $instance + 1;
        }
    }
    
}
