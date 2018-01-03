@extends('layouts.honeymaster')

@section('content')

<div class="col-md-10 col-md-offset-2">

    <div class="card">
        
        <div class="card-header">
            <h3>Instructions (3/3)</h3>
        </div>
        <div class="card-block">
            
            
            <h4>How Do I Know If My Attack Was Successful?</h4>
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                After each attack decision you make, you will receive 
                <b>feedback</b> regarding your outcome. The figures below show 
                the case of a successful attack (<b>Figure 2</b>) and the case 
                of an unsuccessful attack (<b>Figure 3</b>). 
            </p>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                In the example below, if you decided to attack node 1 and it was a
                <span style="color: green;"><b>real node</b></span>, you earned 
                15 points, denoted in 
                <span style="color: green;"><b>green</b></span> (<b>Figure 1</b>). If you decided
                to attack node 2 and it were a
                <span style="color: red;"><b>honeypot</b></span>, you lost 15 
                points, denoted in <span style="color: red;"><b>red</b></span> (<b>Figure 3</b>). 
                Therefore, when making the decision which node to attack, you 
                should consider the value.
            </p>
            
            <img class="d-block img-fluid" style="" src="{{URL::asset('/images/instruction2.png')}}">
            <span style="text-align: center"><p class="card-text" style="font-size: 1.2em;"><u><b>Figure 2.  </b>Feedback after <span style="color: green;"><b>successful</b></span> attack decision</u></p></span>
            <br>
            
            <img class="d-block img-fluid" style="" src="{{URL::asset('/images/instruction3.png')}}">
            <span style="text-align: center"><p class="card-text" style="font-size: 1.2em;"><u><b>Figure 3.  </b>Feedback after <span style="color: red;"><b>unsuccessful</b></span> attack decision</u></p></span>
            <br>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                On the next page, you will be asked some questions about the 
                game to make sure you understand the instructions. After 
                completing the quiz, you will play through 
                <b>one practice round</b> before proceeding to the 
                <b>real game</b>.
            </p>
            <a href='{{ url("/instruction/concept") }}' id="nextbutton" class="btn btn-primary">Continue</a>
        </div>
    </div>
</div>

@endsection('content')