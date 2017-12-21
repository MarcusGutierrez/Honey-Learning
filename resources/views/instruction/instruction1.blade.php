@extends('layouts.honeymaster')

@section('content')

<div class="col-md-10 col-md-offset-2">

    <div class="card">
        
        <div class="card-header">
            <h3>Instructions (1/3)</h3>
        </div>
        <div class="card-block">
            
            <img class="d-block img-fluid" style="" src="{{URL::asset('/images/instruction1.png')}}">
            <span style="text-align: center"><p class="card-text" style="font-size: 1.2em; "><u><b>Figure 1.  </b>Game Interface</u></p></span>
            <br>
            
            <h4><ul>What Decisions Can I Make?</ul></h4>
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                <b>Figure 1</b> below shows one round of the game. Each circle denotes 
                a node in the network. In each round of this game, you decide
                where to attack a real node in the network or to 
                “<span style="color: blue;"><b>pass</b></span>”.
            </p>
            
            <h4>Attacking</h4>
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em; padding-left: 2em;">
                Attacking a <span style="color: green;"><b>real</b></span> node earns you points,
                shown in  <span style="color: green;"><b>green</b></span> in 
                <b>Figure 1</b>. These points reflect how <b>valuable</b> the 
                information in the node is. The more  points, the more 
                potentially valuable the nodes is.
            </p>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em; padding-left: 2em;">
                However, attacking a <span style="color: red;"><b>honeypot</b></span>
                will cause you to lose points, denoted in 
                <span style="color: red;"><b>red</b></span>. The problem is that
                you don't know which nodes the Defender assigned as honeypots
                and which nodes are real. You will need to discover that by
                playing this game.
            </p>
            
            <h4>Passing</h4>
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em; padding-left: 2em;">
                If you choose to “<span style="color: blue;"><b>Pass</b></span>” 
                you will not attack any node in this round. Although this is a
                safe option, <span style="color: blue;"><b>passing</b></span> 
                will not earn you any points.
            </p>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                You will have a limited time to make each decision; the amount 
                of time remaining is presented in the “<b>Time Remaining:</b>” 
                in upper center of the interface.  
                For example, in this case seen in <b>Figure 1</b>, you have 
                <b>7 seconds</b> to make your decision.  If you don’t make a 
                decision within the allocated time, we will assume that your 
                decision is "<span style="color: blue;"><b>Pass</b></span>", 
                and will be given 0 points for that round.
            </p>
            
            <a href='{{ url("/instruction/2") }}' id="nextbutton" class="btn btn-primary">Continue</a>
        </div>
    </div>
</div>

@endsection('content')