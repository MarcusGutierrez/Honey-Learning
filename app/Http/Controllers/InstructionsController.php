<?php

namespace honeysec\Http\Controllers;

use Illuminate\Http\Request;

class InstructionsController extends Controller
{
    
    public function show(){
        return view('instruction.instruction');
    }
    
}
