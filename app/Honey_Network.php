<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Honey_Network extends Model
{
    protected $table = 'honey_network'; //Defines which table to use
    protected $primaryKey = 'network_id';
    public $timestamps = false;
    
    public function nodes()
    {
        return $this->hasMany('honeysec\Honey_Node', 'network_id');
    }
    
    public function rounds()
    {
        return $this->hasMany('honeysec\Round', 'network_id');
    }
}
