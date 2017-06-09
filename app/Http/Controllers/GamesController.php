<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

use honeysec\Question;

use JavaScript;





class GamesController extends Controller
{





	public function  __construct()
	{
		
		 $this->middleware('auth')->except(['index']);

	}



	public function index()
	{

		
			return view('instruction.index');
	}



	public function startsurvey()
	{






		$questions = Question::all();


		



		//dd($questions);



		return view('instruction.survey', compact('questions'));
	}



	public function storesurvey()
	{


		//dd(request()->all());
		$this->validate(request(), [


    		'Question_1' => 'required',

    		'Question_2' => 'required',

    		'Question_3' => 'required',

    		'Question_4' => 'required',

    		'Question_5' => 'required',

    		'Question_6' => 'required',

    		'Question_7' => 'required',

    		'Question_8' => 'required',

    		'Question_9' => 'required',

    		'Question_10' => 'required',

    		'Question_11' => 'required',

    		'Question_12' => 'required',

    		'Question_13' => 'required',

    		'Question_14' => 'required',

    		'Question_15' => 'required',

    		'Question_16' => 'required',

    		'Question_17' => 'required',

    		'Question_18' => 'required',
    		
    		'Question_19' => 'required',

    		'Question_20' => 'required',

    		'Question_21' => 'required',

    		'Question_22' => 'required',

    		'Question_23' => 'required',

    		'Question_24' => 'required',

    		'Question_25' => 'required',

    		'Question_26' => 'required',

    		'Question_27' => 'required'




    		]);



		$answer = new \honeysec\Answer;

		$answer->user_id =  session('user_id','');

		$answer->Question_1 = request('Question_1');
		$answer->Question_2 = request('Question_2');
		$answer->Question_3 = request('Question_3');
		$answer->Question_4 = request('Question_4');
		$answer->Question_5 = request('Question_5');
		$answer->Question_6 = request('Question_6');
		$answer->Question_7 = request('Question_7');
		$answer->Question_8 = request('Question_8');
		$answer->Question_9 = request('Question_9');
		$answer->Question_10 = request('Question_10');

		$answer->Question_11 = request('Question_11');
		$answer->Question_12 = request('Question_12');
		$answer->Question_13 = request('Question_13');
		$answer->Question_14 = request('Question_14');
		$answer->Question_15 = request('Question_15');
		$answer->Question_16 = request('Question_16');
		$answer->Question_17 = request('Question_17');
		$answer->Question_18 = request('Question_18');
		$answer->Question_19 = request('Question_19');
		$answer->Question_20= request('Question_20');

		$answer->Question_21 = request('Question_21');
		$answer->Question_22 = request('Question_22');
		$answer->Question_23 = request('Question_23');
		$answer->Question_24 = request('Question_24');
		$answer->Question_25 = request('Question_25');
		$answer->Question_26 = request('Question_26');
		$answer->Question_27 = request('Question_27');

		$answer->save();


		return view('instruction.surveydone');

		





	}




	public function showinstruction()
	{

		// store the form data


		//dd(request()->all());


		$game = new \honeysec\Game;

		$game->gameid = 1;
		$game->userid = 1;
		$game->action = request('action');
		$game->time = 0;


		$game->save();



		return redirect('/instruction');

	}


	public function show()
	{


		return view('instruction.index');

	}

	public function startgame($id)
	{


		JavaScript::put([
        'user_id' => session('user_id','')
    ]);




		if($id==1)
		{
                        //return view('honey.hone', compact('id'));
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
        
        
        public function startHoneyGame($id)
	{
            JavaScript::put(['user_id' => session('user_id','')]);

            if($id==1){
                //return view('honey.hone', compact('id'));
                return view('honey.honey_one', compact('id'));
            }else if($id==2){
                return view('honey.honey_two', compact('id'));
            }else{
                return view('honey.honey_three', compact('id'));
            }
	}

}
