<?php

namespace honeysec;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users'; //Defines which table to use
    protected $primaryKey = 'id';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token',
    ];


    public function setPasswordAttribute($password)
    {   
        $this->attributes['password'] = bcrypt($password);
    }


     public function setUseridAttribute($user_id)
    {   
        $this->attributes['user_hash'] = bcrypt($user_id);
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
