@extends('layouts.master')

@section('content')

<div id="app">
    <div  class="col-sm-8">
        
        <h3>
            <span style="color: red;"><b>Warning!</b></span> The information on
            this page will not be accessible if you refresh the page.
        </h3>

        <h1>Games Results</h1>
        <h4>Total Points: {{ $total_points }}</h4>
        <h4>A total bonus payment of ${{ $bonus_payment }} will be added to the base payment
        <h4>Triggered Honeypots: {{ $honeypots_triggered }}</h4>
        <h4>Number of Passes: {{ $total_passes }}</h4>
        <h4>Completion Code: {{ $session_code }}</h4>

        <div>
            <br>
            <h5>
                Thank you for participating! Please copy the completion code to 
                your clipboard and close this window when you are ready.
            </h5>
        </div>


    </div>
</div>

@endsection('content')