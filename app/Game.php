<?php

namespace honeysec;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //

	public function user()
	{
		return $this->belongsTo(User::class);
	}

}
