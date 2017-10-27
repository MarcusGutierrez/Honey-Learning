<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

class InstructionsController extends Controller
{
    
    public function __construct() {
        $this->middleware('preventBackHistory');
        $this->middleware('auth');
    }
    
    public function instruction(){
        $this->create_section("instruction");
        return view('instruction.instruction');
    }
    
    public function consent(Request $request){
        $this->create_section("consent");
        return view('instruction.consent');
    }
    
    public function consent_store(Request $request){
        $this->validate(request(), [
            'q1' => 'required',
            'q2' => 'required',
            'q3' => 'required',
        ]);
        
        if(request('q1') === 'no' || request('q2') === 'no' || request('q3') === 'no'){
            session()->put('ineligible', true);
            return redirect('/ineligible');
        }
        session()->put('consent_completed', true);
        $this->store_section("consent");
        return redirect('/next');
    }
    
    public function ineligible(Request $request){
        //$this->create_section("consent");
        $this->store_section("consent");
        return view('instruction.ineligible');
    }
    
}
