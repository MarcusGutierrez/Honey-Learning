<?php

namespace honeysec;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'turk_user'; //Defines which table to use
    protected $primaryKey = 'id';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'turk_id',
        'consented',
        'completed_experiments'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
         'remember_token',
    ];


    public function setPasswordAttribute($password)
    {   
        $this->attributes['password'] = bcrypt($password);
    }*/

    public function getRememberToken(){
      return null; // not supported
    }

    public function setRememberToken($value){
      // not supported
    }

    public function getRememberTokenName(){
      return null; // not supported
    }

    /**
     * Overrides the method to ignore the remember token.
     */
    public function setAttribute($key, $value)
    {
      $isRememberTokenAttribute = $key == $this->getRememberTokenName();
      if (!$isRememberTokenAttribute)
      {
        parent::setAttribute($key, $value);
      }
    }


     public function setUseridAttribute($user_id)
    {   
        $this->attributes['turk_id'] = bcrypt($user_id);
    }
    
    public static function takenSurvey($user_id, $type)
    {
        $answers = static::find($user_id)->answers;
        foreach($answers as $answer){
            if($answer->question->type == $type)
                return true;
        }
        return false;
    }
    
    public static function findByTurk($turk_id)
    {
        return static::where('turk_id', $turk_id)->firstOrFail();
    }
    
    public function getCompletionCode()
    {
        if($this->sessions->count() > 0){
            $session_id = $this->sessions->first()->session_id;
            $completion_code = "a".substr(md5($session_id."b73"), 0, 8)."7";
            return $completion_code;
        } else {
            return null;
        }
    }
    
    public function sessions()
    {
        return $this->hasMany('honeysec\Session');
    }
    
    public function answers()
    {
        return $this->hasMany('honeysec\Answer', 'user_id');
    }
    
    public function sectionStamps()
    {
        return $this->hasMany('honeysec\Section_Stamp', 'user_id');
    }


}
