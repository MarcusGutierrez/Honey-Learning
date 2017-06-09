<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Honey_Game extends Model
{
    protected $table = 'honey_game'; //Defines which table to use
    protected $primaryKey = 'gid';
}
