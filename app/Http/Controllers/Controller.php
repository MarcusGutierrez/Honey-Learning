<?php

namespace honeysec\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function create_section($type){
        $section = new \honeysec\Section_Stamp;
        $section->user_id = session()->get('user_id');
        $section->section_type = $type;
        $section->time_entered = current_time();
        $section->save();
    }
    
    public function store_section($type){
        $section = \honeysec\Section_Stamp::where('user_id', session()->get('user_id', null))->get()->where('section_type', $type)->last();
        $section->time_completed = current_time();
        $section->save();
    }
}
