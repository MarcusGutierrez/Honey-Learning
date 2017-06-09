<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Honey_Node extends Model
{
    protected $table = 'honey_node'; //Defines which table to use
    
    public function scopeInGameID($query, $id) //honeysec\Honey_Node::gameID(1)->get()
    {
        return static::where('gid', '=', $id);
    }
    
    public function scopeValueSum($query) //honeysec\Honey_Node::gameID(1)->get()
    {
        return static::pluck('value')->sum();
    }
    
    public function scopeNodeID($query, $id) //honeysec\Honey_Node::nodeID(1)->get()
    {
        return static::where('nid', '=', $id)->get();
    }
}
