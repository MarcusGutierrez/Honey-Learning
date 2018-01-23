@extends('layouts.honeymaster')

@section('content')

<div class="col-md-10 col-md-offset-2">

    <div class="card">
        
        <div class="card-block">
            <h3 style="text-align: justify; text-justify: inner-word;">
                You are about to start the real game. <br>
                From here on, the points 
                will count towards your final bonus payment.  Please pay 
                attention to each decision.
                
                <br>
                <br>
                
                Please <b>do <i>not</i></b> refresh the page during the 
                game. Doing so will disqualify you from receiving a bonus 
                payment.
            </h3>
            <br>
            
            <form method="POST" action="/pregame/store">
                {{ csrf_field()}}
                
                <button type="submit" class="btn btn-primary" style="cursor:pointer">Continue</button>
            </form>
            
        </div>
    </div>
</div>

@endsection('content')