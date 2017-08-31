<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;
use honeysec\Question;
use JavaScript;

class GamesController extends Controller {

    public function __construct() {

        $this->middleware('auth');
    }

    public function index() {
        $booleans = array();
        $booleans['survey'] = false;
        $buttons = array();
        $buttons['play'] = "pointer-events: none; opacity: 0.4;";
        return view('instruction.index', compact('booleans'), compact('buttons'));
    }

    public function startsurvey(Request $request, $type) {
        if($type == 'post' && session()->get('session_id', null) == null){
            return redirect('/')->with('message', 'Must start a game session to complete that action');
        }
        
        $params['survey_type'] = $type;
        $questions = Question::where('type', $type)->get();

        return view('instruction.survey', compact('questions'))->with($params);
    }

    public function storesurvey(Request $request, $type) {
        if($type == 'post' && session()->get('session_id', null) == null){
            return redirect('/')->with('message', 'Must start a game session to complete that action');
        }
        
        $user_id = $request->session()->get('user_id', null);
        $questions = Question::where('type', $type)->get();

        //$taken = \honeysec\User::takenSurvey($user_id, $type);
        $flagged = [];
        //if ($taken == false) { //If survey has not been taken yet
            foreach ($questions as $q) {
                $answer = new \honeysec\Answer;
                $answer->user_id = $user_id;
                $answer->question_id = $q->question_id;
                $answer->body = request($q->question_id);
                
                if($type == 'post')
                    $answer->session_id = session()->get('session_id');
                
                $answer->save();
                
                if(request($q->question_id) == null)
                    $flagged[] = $q->question_id;
            }
        //}
        
        if (count($flagged) > 1) {
            $message = "Questions (";
            foreach($flagged as $key => $question){
                if($key == count($flagged)-1){
                    $message .= "and ".$question.")";
                }else{
                    $message .= $question.", ";
                }
            }
            $message .= " have not been answered. Press 'Skip Remaining Survey' to avoid answering remaining questions.";
            return redirect()->back()->withErrors([
                        'message' => $message
            ]);
        }else if (count($flagged) == 1) {
            $message = "Question (".$flagged[0].") has not been answered. Press 'Skip Remaining Survey' to avoid answering remaining questions.";
            return redirect()->back()->withErrors([
                        'message' => $message
            ]);
        }
        
        session()->put('survey_completed', true);

        if($type == 'pre')
            return view('instruction.index')->with('message', 'Thank you for taking our survey');
        else if($type == 'post')
            return redirect('/results/')->with('message', 'Thanks for playing');
    }

    public function concept(Request $request) {
        return view('instruction.concept');
    }

    public function store_concept() {
        //return view('instruction.qaconceptual');
        //dd(request()->all());
        $this->validate(request(), [
            'question_1' => 'required|min:1|max:1',
            'question_2' => 'required|min:1|max:1',
            'question_3' => 'required|min:1|max:1',
        ]);
        $wrongques1 = '';
        $wrongques2 = '';
        $wrongques3 = '';
        $flag = true;

        if (request('question_1') !== "4") {
            $wrongques1 = $wrongques1 . 'Question 1: Wrong! Correct answer is 3, because the defender can select one 10-cost node and two 5-cost nodes.';
            $flag = false;
        } else {
            $wrongques1 = $wrongques1 . 'Question 1: Correct answer.';
        }
        // else if(request('question_1') === "1")
        // {
        // 	$wrongques1 = $wrongques1 . 'Question 1: Correct!'; 
        // }

        if (request('question_2') !== "2") {
            $wrongques2 = $wrongques2 . ' Question 2: Wrong! The bottom negative number inside the node is the amount you lose if the node is a honeypot.';
            $flag = false;
        } else {
            $wrongques2 = $wrongques2 . 'Question 2: Correct answer.';
        }
        if (request('question_3') !== "2") {
            $wrongques3 = $wrongques3 . ' Question 3: Wrong! Passing does not affect your score. It is a safe option if you are unsure of the remaining nodes.';
            $flag = false;
        } else {
            $wrongques3 = $wrongques3 . 'Question 3: Correct answer.';
        }
        // else if(request('question_2') === "2")
        // {
        // 	$wrongques2 = $wrongques2 . 'Question 2: Correct!'; 
        // }
        if ($flag == false) {
            return redirect()->back()->withErrors([
                        'message' => $wrongques1,
                        'message2' => $wrongques2,
                        'message3' => $wrongques3,
            ]);
        }
        session()->put('concept_completed', true);
        session()->flash('message', 'Everything is correct. Thanks!');
        return view("instruction.index");
    }

    public function showinstruction() {

        // store the form data
        //dd(request()->all());


        /* $game = new \honeysec\Game;

          $game->gameid = 1;
          $game->userid = 1;
          $game->action = request('action');
          $game->time = 0;


          $game->save(); */

        //dd("hello");

        return view('instruction.slideshow');
    }

    public function show() {


        return view('instruction.index');
    }

    public function startgame($id) {


        JavaScript::put([
            'user_id' => session('user_id', '')
        ]);




        if ($id == 1) {
            //return view('honey.hone', compact('id'));
            return view('games.one', compact('id'));
        } else if ($id == 2) {
            return view('games.two', compact('id'));
        } else {
            return view('games.three', compact('id'));
        }
    }

    public function startHoneyGame($id) {
        JavaScript::put(['user_id' => session('user_id', '')]);

        if ($id == 1) {
            //return view('honey.hone', compact('id'));
            return view('honey.honey_one', compact('id'));
        } else if ($id == 2) {
            return view('honey.honey_two', compact('id'));
        } else {
            return view('honey.honey_three', compact('id'));
        }
    }

}
