<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Gamehistory extends Model
{
    //



    public function user()
	{
		return $this->belongsTo(User::class);
	}
}
