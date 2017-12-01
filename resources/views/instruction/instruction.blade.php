@extends('layouts.honeymaster')

@section('content')

<div class="col-md-10 col-md-offset-2">

    <div class="card">
        
        <div class="card-header">
            <h3>Instructions</h3>
        </div>
        <div class="card-block">
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                The figure below shows one round of the game. Each circle denotes 
                a node in the network. In each round of this game, you decide
                where to attack a real node in the network or to 
                “<span style="color: blue;"><b>pass</b></span>”
            </p>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                Attacking a <span style="color: green;"><b>real</b></span> node earns you points,
                shown in  <span style="color: green;"><b>green</b></span> in the 
                figure below. These points reflect how <b>valuable</b> is the 
                information in the node. The more  points, the more potentially 
                valuable it is.
            </p>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                However, attacking a <span style="color: red;"><b>honeypot</b></span>
                will cause you to lose points, denoted in 
                <span style="color: red;"><b>red</b></span>. The problem is that
                you don't know which nodes the defender assigned as honeypots
                and which nodes are real. You will need to discover that by
                playing this game.
            </p>
                
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                If you choose to “<span style="color: blue;"><b>Pass</b></span>” 
                you will not attack any node in this round. Although this is a
                safe option, <span style="color: blue;"><b>passing</b></span> 
                will not earn you any points.
            </p>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                The combination of nodes that can be "turned into" 
                <span style="color: red;"><b>honeypots</b></span> is determined
                by the defender's <b>budget</b>. The combined value of the
                honeypots cannot exceed the defender's budget. The cost to the
                defender is the value of the node, shown in 
                <span style="color: green;"><b>green</b></span> in the figure
                below. For example, the defender's budget is <b>40</b>, and the 
                nodes 1 through 5 would cost the defender 15, 20, 10, 20, 15
                points respectively, to be turned into 
                <span style="color: red;"><b>honeypots</b></span>. Therefore,
                the defender cannot turn all the nodes into 
                <span style="color: red;"><b>honeypots</b></span>, but only
                some combination of them. For example, in the figure below, it
                is possible to turn nodes 1, 3, and 5 (they add to 40 points,
                which is below the defender's budget), or nodes 2 and 4 (they
                also add to 40 points).
            </p>
            
            <br>
            
            <img class="d-block img-fluid" style="" src="{{URL::asset('/images/instruction1.png')}}">
            
            <br>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                After each Attack decision you make, you will receive 
                <b>feedback</b> regarding your outcome. The figures below show 
                the case of a successful attack (upper figure) and the case of 
                unsuccessful attack (lower figure). 
                <br>
                <br>
                In the example below, if the 
                node you decided to attack was a 
                <span style="color: green;"><b>real node</b></span>, you earned 
                20 points, denoted in 
                <span style="color: green;"><b>green</b></span>. If the node you 
                decided to attack was a 
                <span style="color: red;"><b>honeypot</b></span>, you lost 10 
                points, denoted in <span style="color: red;"><b>red</b></span>. 
                Therefore, when making the decision which node to attack, you 
                should consider the value.
            </p>
            
            <p class="card-text" style="font-size: 1.2em;"><u>Feedback after <span style="color: green;"><b>successful</b></span> attack decision</u></p>
            <img class="d-block img-fluid" style="" src="{{URL::asset('/images/instruction2.png')}}">
            
            <br>
            <br>
            
            <p class="card-text" style="font-size: 1.2em;"><u>Feedback after <span style="color: red;"><b>unsuccessful</b></span> attack decision</u></p>
            <img class="d-block img-fluid" style="" src="{{URL::asset('/images/instruction3.png')}}">
            
            <br>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                In the next page you will be asked some questions about the game 
                to make sure you understand the instructions. If you answer the 
                questions correctly, you will be then asked to do a practice 
                round, before you move on with the real game.
            </p>
            
            <a href='{{ url("/instruction/concept") }}' id="nextbutton" class="btn btn-primary">Continue</a>
        </div>
    </div>
</div>

@endsection('content')