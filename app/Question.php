<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $primaryKey = 'question_id';
    protected $table = 'question';
    public $timestamps = false;
    
    public function answers()
    {
        return $this->hasMany('honeysec\Answer', 'question_id');
    }
}
