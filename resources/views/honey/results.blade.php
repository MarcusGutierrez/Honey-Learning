@extends('layouts.master')

@section('content')

<div id="app">
    <div  class="col-sm-8">
        
        
        <h1>Games Results</h1>
        <h4>Defender: {{ $defender_type }}</h4>
        <h4>Total Points: {{ $total_points }} / {{ $total_possible }}</h4>
        <h4>Triggered Honeypots: {{ $honeypots_triggered }} / {{ $honeypots_total }}</h4>
        <h4>Number of Passes: {{ $total_passes }}</h4>
        <h4>Amazon Turk Code: {{ $session_code }}</h4>
        
        <a href='{{ url("/session/destroy") }}' id="nextbutton" class="btn btn-primary" style="margin-bottom: 20px;">Return Home</a>
        

    </div>
</div>

@endsection('content')