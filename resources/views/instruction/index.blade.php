@extends('layouts.master')





@section('content')

@php
use honeysec\User;

$completion = 0;
if(session()->get('survey_completed', false))
$completion += 25;
if(session()->get('concept_completed', false))
$completion += 25;
if(session()->get('practice_completed', false))
$completion += 25;


$user_id = session()->get('user_id');
$has_played = \honeysec\User::find($user_id)->sessions->count() > 0;
if($has_played){
    $first_session_id = \honeysec\User::find($user_id)->sessions->first();
    $session_code = "a".substr(md5($first_session_id."b73"), 0, 10)."7";
    $completion += 25;
}

@endphp


<style text="css">
    .disabled {
        pointer-events: none;
        opacity: 0.3;
    }
</style>


<div class="" style="margin: auto; padding: 10px; align: center">
    
    {{ csrf_field()}}

    <div class="card text-center" style="width: 50rem; height: 17rem; align: center; margin: 0auto">

        <div class="card-block">
            <p>
                Welcome to Honey Intrusion! In this scenario, you play the role of an attacker infiltrating a system protected by a defender.
                Please progress through the various pages below.
            </p>

            <div style="padding-bottom: 20px;" class="container">
                <h4>Completion</h4>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-val      uemax="100" style="width:{{ $completion }}%">
                        <span class="sr-only">70% Complete</span>
                    </div>
                </div>
            </div>

            <button type="button" onclick="window.location ='{{ url("/survey/pre") }}'" style="cursor:pointer"  class="btn btn-outline-primary">Take survey</button>
            <button type="button" onclick="window.location ='{{ url("/instruction") }}'" style="cursor:pointer;" class="btn btn-outline-primary
                    @if(Session::get('survey_completed') != true)
                    disabled
                    @endif
                    ">Instructions</button>
            <button type="button" onclick="window.location ='{{ url("/play/practice") }}'" style="cursor:pointer;" class="btn btn-outline-primary
                    @if(Session::get('concept_completed') != true)
                    disabled
                    @endif
                    ">Practice Game</button>
            <button type="button" onclick="window.location ='{{ url("/session/create/def1") }}'" style="cursor:pointer;"  class="btn btn-outline-primary
                    @if(Session::get('practice_completed') != true)
                    disabled
                    @endif
                    ">Play Defender 1</button>
            <button type="button" onclick="window.location ='{{ url("/session/create/def2") }}'" style="cursor:pointer;"  class="btn btn-outline-primary
                    @if(Session::get('practice_completed') != true)
                    disabled
                    @endif
                    ">Play Defender 2</button>
        </div>

    </div>


</div>

@endsection('content')


