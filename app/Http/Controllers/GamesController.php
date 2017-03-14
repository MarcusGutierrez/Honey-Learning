<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GamesController extends Controller
{

	public function index()
	{
		return view('instruction.index');
	}


	public function showinstruction()
	{

		// store the form data


		//dd(request()->all());


		$game = new \App\Game;

		$game->gameid = 1;
		$game->userid = 1;
		$game->action = request('action');
		$game->time = 0;


		$game->save();



		return redirect('/instruction');

	}


	public function show()
	{


		return view('instruction.show');

	}

	public function startgame($id)
	{


		if($id==1)
		{

			return view('games.one', compact('id'));
		}
		else if($id==2)
		{
			return view('games.two', compact('id'));
		}
		else
		{
			return view('games.three', compact('id'));
		}


	}



}
