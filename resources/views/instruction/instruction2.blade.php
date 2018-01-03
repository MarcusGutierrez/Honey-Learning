@extends('layouts.honeymaster')

@section('content')

<div class="col-md-10 col-md-offset-2">

    <div class="card">
        
        <div class="card-header">
            <h3>Instructions (2/3)</h3>
        </div>
        <div class="card-block">
            
            <h4>Which Nodes Are Honeypots?</h4>
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                The combination of nodes that can be "turned into" 
                <span style="color: red;"><b>honeypots</b></span> is determined
                by the defender's <b>budget</b>.  The cost to the
                defender is the value of the node, shown in 
                <span style="color: green;"><b>green</b></span>. The combined 
                value of the honeypots cannot exceed the defender's budget.
            </p>
            
            <p class="card-text" style="text-align: justify; text-justify: inner-word; font-size: 1.15em;">
                In this case, the defender's budget is <b>40</b>. To turn 
                nodes 1 through 5 into 
                <span style="color: red;"><b>honeypots</b></span> would cost the 
                defender 15, 20, 10, 20, 15 points respectively. Therefore,
                the defender <i>cannot</i> turn all the nodes into 
                <span style="color: red;"><b>honeypots</b></span>, but only
                some combination of them. In the figure below, the possible
                combinations of <span style="color: red;"><b>honeypots</b></span>
                are:
                <ul>
                    <li>Nodes 1, 3, and 5. These add up to 40 cost, which is within the defender's budget</li>
                    <li>Nodes 1 and 2, which adds up to 35, which is below the defender's budget </li>
                    <li>Nodes 1 and 4, which adds up to 35</li>
                    <li>Nodes 2 and 3 add up to 30</li>
                    <li>Nodes 2 and 4 add up to 40</li>
                    <li>Nodes 2 and 5 add up to 35</li>
                    <li>Nodes 3 and 4 add up to 30</li>
                    <li>Nodes 4 and 5 add up to 35</li>
                </ul>
            </p>
            
            <br>
            <img class="d-block img-fluid" style="" src="{{URL::asset('/images/instruction1.png')}}">
            <span style="text-align: center"><p class="card-text" style="font-size: 1.2em; "><u><b>Figure 1.  </b>Game Interface</u></p></span>
            <br>
            
            <a href='{{ url("/instruction/3") }}' id="nextbutton" class="btn btn-primary">Continue</a>
        </div>
    </div>
</div>

@endsection('content')