<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Section_Stamp extends Model
{
    protected $primaryKey = 'section_id';
    protected $table = 'section_stamp'; //Defines which table to use
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('honeysec\User');
    }
}
