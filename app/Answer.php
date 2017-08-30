<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $primaryKey = 'answer_id';
    protected $table = 'answer';
    public $timestamps = false;
    
    public function user()
    {
        return $this->belongsTo('honeysec\User', 'user_id');
    }
    
    public function question()
    {
        return $this->belongsTo('honeysec\Question', 'question_id');
    }
}
