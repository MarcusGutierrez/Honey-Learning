@extends('layouts.honeymaster')

@section('content')

@php

    $def = session()->get('defender_type', null);

@endphp

<div class="col-md-10 col-md-offset-2">

    <div class="card">
        
        <div class="card-block">
            <h3 style="text-align: justify; text-justify: inner-word;">
                You are about to start the real game. <br>
                From here on, the points 
                will count towards your final bonus payment.  Please pay 
                attention to each decision.
            </h3>
            
            <!-- <a href='{{ url("/session/create/$def") }}' id="nextbutton" class="btn btn-primary">Continue</a> -->
            
            <br>
            
            <form method="POST" action="/pregame/">
                {{ csrf_field()}}
                
                <button type="submit" class="btn btn-primary" style="cursor:pointer">Continue</button>
            </form>
            
        </div>
    </div>
</div>

@endsection('content')