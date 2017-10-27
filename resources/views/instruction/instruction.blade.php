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
                a node in the network. In each round of this game, attacking a 
                <span style="color: green;"><b>real</b></span> node earns you points. 
                The number of points for attacking  each node is denoted in 
                <span style="color: green;"><b>green</b></span> in the figure 
                below. These points reflect how valuable is the information in 
                the node. The more  points, the more potentially valuable it is.
            </p>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                However, if the node is a <span style="color: red;"><b>honeypot</b></span>, that will cause you 
                to lose points, denoted in 
                <span style="color: red;"><b>red</b></span>. You can also choose 
                to “<span style="color: blue;"><b>Pass</b></span>” - not to 
                attack any node in this round. Although this is a safe option, 
                “<span style="color: blue;"><b>Pass</b></span>” will not earn you 
                any points.
            </p>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                The combination of nodes that are honeypots is determined by the 
                defender’s <b>budget</b> (see the right-hand side of the figure 
                below). Each node can be “turned into” a honeypot at a cost 
                specified below each node. For example, in the figure below, the 
                defender’s budget is <b>10</b>, and the nodes all cost 5 points each to be 
                turned into honeypots.  Therefore, the defended cannot turn all 
                the nodes into honeypots, and only some combination of them can 
                be allowed with the particular defender’s budget.
            </p>
            
            <br>
            
            <img class="d-block img-fluid" style="" src="{{URL::asset('/images/instruction1.png')}}">
            
            <br>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                After each Attack decision you make, you will receive 
                <b>feedback</b> regarding your outcome. The figures below show 
                the case of a successful attack (upper figure) and the case of 
                unsuccessful attack (lower figure). In the example below, if the 
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
            
            <br>
            
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
            
            <a href='{{ url("/next") }}' id="nextbutton" class="btn btn-primary">Continue</a>
        </div>
    </div>
</div>

@endsection('content')