<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;
use honeysec\Question;
use JavaScript;

class GamesController extends Controller {

    public function __construct() {
        $this->middleware('preventBackHistory');
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
        $this->create_section($type." survey");
        
        $params['survey_type'] = $type;
        
        if($type == 'background'){
            return view('instruction.background')->with($params);
        }
        
        $questions = Question::where('type', $type)->get();

        return view('instruction.survey', compact('questions'))->with($params);
    }

    public function storesurvey(Request $request, $type) {
        /*if($type == 'post' && session()->get('session_id', null) == null){
            return redirect('/')->with('message', 'Must start a game session to complete that action');
        }*/
        
        $user_id = $request->session()->get('user_id', null);
        $questions = Question::where('type', $type)->get();

        //$taken = \honeysec\User::takenSurvey($user_id, $type);
        $flagged = [];
        //if ($taken == false) { //If survey has not been taken yet
            foreach ($questions as $q) {
                $answer = new \honeysec\Answer;
                $answer->user_id = $user_id;
                $answer->question_id = $q->question_id;
                $answer->body = request("q".$q->question_number);
                $answer->time_answered = current_time();
                
                if($type == 'post')
                    $answer->session_id = session()->get('session_id');
                
                $answer->save();
                
                if(request($q->question_id) == null)
                    $flagged[] = $q->question_id;
            }
            //}
        $reqQ = [];
        foreach($questions as $question){
            $reqQ['q'.$question->question_number] = 'required';
        }

        $validator = $this->validate(request(), $reqQ);
        
        if($type == 'background')
            $request->session()->put('background_completed', true);
        else if($type == 'post')
            session()->put('post_completed', true);
        else if($type == 'triad')
            session()->put('triad_completed', true);

        return redirect('/next');
    }

    public function concept(Request $request) {
        $this->store_section("instruction");
        session()->put('instruction_completed', true);
        
        $this->store_section("concept");
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
            return redirect()->back()->withInput()->withErrors([
                        'message' => $wrongques1,
                        'message2' => $wrongques2,
                        'message3' => $wrongques3,
            ]);
        }
        session()->put('concept_completed', true);
        session()->flash('message', 'Everything is correct. Thanks!');
        $this->store_section("concept");
        return redirect('/next');
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

        $this->create_section("instruction");
        
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
    
    
    public function next(){ //pops the page path
        $page_path = session()->pull('page_path', null);
        $next_page = array_shift($page_path);
        session()->put('page_path', $page_path);
        
        return redirect("$next_page");
    }

}
