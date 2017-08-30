<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Honey_Tentative extends Model
{
    protected $table = 'honey_attack_tentative'; //Defines which table to use
    //protected $dateFormat = 'Y-m-d\TH:i:s.u';
    public $timestamps = false;
    
    
    
}
