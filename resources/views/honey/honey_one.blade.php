@extends('layouts.honeymaster')

@section('content')


<div id="honeyapp">
    
    {{ csrf_field()}}
    <!-- <img src="http://localhost/images/test.png"> -->
    
    <div class="row" id="cardrow">
        <div class="col-sm-9">
            <div class="card card-outline-primary" style="left: -10vw; width: 60vw; height: 50vh;">
                <div class="card-block">

                    @if ( $honey_network->is_practice == 1)
                        <h3 class="card-title">Practice Game</h3>
                    @else 
                        <h3 class="card-title">Game {{ $round_number }} / {{ $max_round }}</h3>
                    @endif

                    <!-- <h4 class="timerclass">Timer: @{{ timer }}</h4> -->

                    <a id="startbutton" class="button btn btn-primary startbutton" style="cursor:pointer"  @click="startTimer">Click to start</a>

                    <button id="confirmbutton" class="button btn btn-primary confirmbutton visible" style="cursor:pointer" @click="confirmAttack">Confirm</button>

                    <div id="nodebuttons" class="visible">
                        
                        @foreach ($honey_nodes as $node)
                        
                            <node
                                :id="{{ $node->node_id }}"
                                :val="{{ $node->value }}"
                                :defcost="{{ $node->defender_cost }}"
                                :atkcost="{{ $node->attacker_cost }}"
                                :hp="{{ $node->is_honeypot }}"  
                                :pub="{{ $node->is_public }}"
                                :succ="{{ $node->probability }}"
                                :disc="{{ $node->discount }}"
                                :style="{ position: 'absolute', left: {{ $node->node_id*15 + 10 }}+'%', top: '40%' }"
                                :neighbors="[]"
                                :nodevalues= "[{{ $node->value }}, 5, 1]"
                                @:applied="onCouponApplied(id)"
                            >
                            </node>
                            
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card card-outline-primary" style="left: 6vw; width: 19vw;">
                <div class="card-block">
                    <h3>Defender Budget: {{ $honey_network->def_budget }}</h3>
                    <h3 v-if="attackAttemptsBase != 1">Round: @{{ numberofround }} / @{{ attackAttemptsBase }}</h3>
                    <h3>Current Points: @{{ attackerpoints }}</h3>
                    <h3>Total Points: @{{ totalattackerpoints }}</h3>
                    <h3>Time Remaining: @{{ timer }}</h3>
                    
                    <div style="text-align: center;">
                        <button onclick="window.location='{{ url('/honey/play/nextround') }}'" style="cursor:pointer;" id="nextbutton" class="button btn btn-primary visible disable nextbutton">
                            @if ( $honey_network->is_practice == 1)
                                Start Real Game
                            @elseif ($lastround == true)
                                Post Survey
                            @else
                                Next Game
                            @endif
                        </button>
                    </div>
                    
                    <br>
                    <h3>Game History</h3>
                    <div class="card card-outline-primary" style="left: -0.5vw; top: 0.5vw; width: 18vw;">
                        <h5><gamelog v-for="item in gamelog" :nid="item[0]" :val="item[1]" :atkcost="item[2]" :ishp="item[3]" :round="item[4]"></gamelog></h5>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</div>
                            
                            

<script src="{{ asset('js/honeyapp.js') }}" ></script>

@endsection('content')