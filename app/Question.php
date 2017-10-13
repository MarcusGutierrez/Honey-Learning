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
    
    public static function questionID($qnumber, $type) //honeysec\Honey_Node::gameID(1)->get()
    {
        return static::where('question_number', $qnumber)->get()->where('type', $type)->first()->question_id;
    }
}
