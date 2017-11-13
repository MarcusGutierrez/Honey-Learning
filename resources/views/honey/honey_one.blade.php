@extends('layouts.honeymaster')

@section('content')


<div id="honeyapp">
    
    {{ csrf_field()}}
    <!-- <img src="http://localhost/images/test.png"> -->
    
    <div class="row" id="cardrow" style="width: 80vw; position: relative;">
        <div class="col-sm-9">
            <div class="card card-outline-primary" style="height: 50vh;">
                <div class="card-block">

                    @if ( $honey_network->is_practice == 1)
                        <h3 class="card-title">Practice Game</h3>
                    @else 
                        <h3 class="card-title">Game {{ $round_number }} / {{ $max_round }}</h3>
                    @endif
                    
                    

                    <!-- <h4 class="timerclass">Timer: @{{ timer }}</h4> -->

                    <!-- <div style="text-align: center;">
                        <a id="startbutton" class="button btn btn-primary" style="cursor:pointer; background-color: white; "  @click="startTimer">Click to start</a>
                    </div>
                    -->
                    <!--
                    <div style="text-align: center;">
                        <button id="confirmbutton" class="button btn btn-primary visible" style="cursor:pointer; " @click="confirmAttack">Confirm</button>
                    </div>
                    -->
                    
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
                    
                    <div style="text-align: center;">
                        <button onclick="window.location='{{ url('/honey/play/nextround') }}'" style="cursor:pointer;" id="nextbutton" class="button btn btn-primary visible disable nextbutton">
                            @if ( $honey_network->is_practice == 1)
                                Start Real Game
                            @elseif ($lastround == true)
                                Continue
                            @else
                                Next Game
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card card-outline-primary" style="">
                <div class="card-block">
                    <h3>Defender Budget: {{ $honey_network->def_budget }}</h3>
                    <h3 v-if="attackAttemptsBase != 1">Round: @{{ numberofround }} / @{{ attackAttemptsBase }}</h3>
                    <!--<h3>Current Points: @{{ attackerpoints }}</h3>-->
                    <h3>Total Points: 
                        <span style="color: green;" v-if="totalattackerpoints > 0">
                        @{{ totalattackerpoints }}
                        </span>
                        <span style="color: red;" v-if="totalattackerpoints < 0">
                        @{{ totalattackerpoints }}
                        </span>
                        <span style="color: black;" v-if="totalattackerpoints == 0">
                        @{{ totalattackerpoints }}
                        </span>
                    </h3>
                    <h3>Time Remaining: @{{ timer }}</h3>
                    
                    <br>
                    <h3>Game Log</h3>
                    <div class="card card-outline-primary" style="">
                        <h5><gamelog v-for="item in gamelog" :nid="item[0]" :val="item[1]" :atkcost="item[2]" :ishp="item[3]" :round="item[4]"></gamelog></h5>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</div>
                            
                            

<script src="{{ asset('js/honeyapp.js') }}" ></script>

@endsection('content')