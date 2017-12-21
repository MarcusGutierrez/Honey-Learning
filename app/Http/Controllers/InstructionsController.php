<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

use honeysec\User;

class InstructionsController extends Controller
{
    
    public function __construct() {
        $this->middleware('preventBackHistory');
        $this->middleware('auth');
        $this->middleware('consented')->except('ineligible');
    }
    
    public function instruction(){
        $this->create_section("instruction");
        return view('instruction.instruction');
    }
    
    public function instruction1(){
        if(session()->get('current_idx', null) == 0){
            session()->put('current_idx', 1);
        }
        $this->create_section("instruction 1");
        return view('instruction.instruction1');
    }
    
    public function instruction2(){
        $this->store_section("instruction 1");
        if(session()->get('current_idx', null) == 1){
            session()->put('current_idx', 2);
        }
        $this->create_section("instruction 2");
        return view('instruction.instruction2');
    }
    
    public function instruction3(){
        $this->store_section("instruction 2");
        if(session()->get('current_idx', null) == 2){
            session()->put('current_idx', 3);
        }
        $this->create_section("instruction 3");
        return view('instruction.instruction3');
    }
    
    public function consent(Request $request){
        $this->create_section("consent");
        return view('instruction.consent');
    }
    
    public function pregame(){
        //dd(Auth::guard(null)->check());
        $this->create_section("pregame");
        return view('honey.pregame');
    }
    
    public function store_pregame(){
        $this->store_section("pregame");
        $def = session()->get('defender_type', null);
        return redirect('/session/create/'.$def);
    }
    
    public function consent_store(Request $request){
        $this->validate(request(), [
            'q1' => 'required',
            'q2' => 'required',
            'q3' => 'required',
        ]);
        
        $user = User::find(session()->get('user_id', null));
        
        if(request('q1') === 'no' || request('q2') === 'no' || request('q3') === 'no'){
            session()->put('consented', false);
            $user->consented = false;
            $user->save();
            return redirect('/ineligible');
        }
        session()->put('consented', true);
        $user->consented = true;
        $user->save();
        
        $this->store_section("consent");
        return redirect('/instruction/1');
    }
    
    public function ineligible(Request $request){
        //$this->create_section("consent");
        $this->store_section("consent");
        return view('instruction.ineligible');
    }
    
}
