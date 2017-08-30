<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $primaryKey = 'round_id';
    protected $table = 'round';
    public $timestamps = false;
    
    public function session()
    {
        return $this->belongsTo('honeysec\Session', 'session_id');
    }
    
    public function moves()
    {
        return $this->hasMany('honeysec\Honey_History', 'round_id');
    }
    
    public function network()
    {
        return $this->belongsTo('honeysec\Honey_Network', 'network_id');
    }
}
