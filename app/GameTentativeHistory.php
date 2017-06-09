<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class GameTentativeHistory extends Model
{
    //

    public function user()
	{
		return $this->belongsTo(User::class);
	}
}
