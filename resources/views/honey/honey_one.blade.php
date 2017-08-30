@extends('layouts.honeymaster')

@section('content')


<div id="honeyapp">
    
    <!-- <img src="http://localhost/images/test.png"> -->
    
    <div class="row" id="cardrow">
        <div class="col-sm-9">
            <div class="card card-outline-primary" style="left: -200px; width: 140%; height: 480px;">
                <div class="card-block">

                    @if ( $honey_network->network_id == 2)
                        <h3 class="card-title">Practice Game</h3>
                    @else 
                        <h3 class="card-title">Game {{ $round_number }} / {{ $max_round }}</h3>
                    @endif

                    <!-- <h4 class="timerclass">Timer: @{{ timer }}</h4> -->

                    <a id="startbutton" class="button btn btn-primary startbutton" style="cursor:pointer"  @click="startTimer">Click to start</a>
                    
                    <button onclick="window.location='{{ url('/honey/play/nextround') }}'" style="cursor:pointer" id="nextbutton" class="button btn btn-primary visible disable nextbutton">
                        @if ( $honey_network->network_id == 2)
                            Return Home
                        @elseif ($lastround == true)
                            Results
                        @else
                            Next Game
                        @endif
                    </button>

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
                            <div v-if="TIME_LIMIT - timer < 3">
                                <h4>@{{ 3 - TIME_LIMIT + timer }}</h4>
                            </div>
                            </node>
                            
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-3">
            <div class="card card-outline-primary" style="left: 120px; width: 140%;">
                <div class="card-block">
                    <h3>Round: @{{ numberofround }} / @{{ attackAttemptsBase }}</h3>
                    <h3>Time Remaining: @{{ timer }}</h3>
                    <h3>Defender Budget: {{ $honey_network->def_budget }}</h3>
                    <h3>Attacker Points: @{{ attackerpoints }}</h3>
                    <br>
                    <h3>Game History</h3>
                    <div class="card card-outline-primary" style="left: -13px; top: 10px; width: 108%;">
                        <h5><gamelog v-for="item in gamelog" :nid="item[0]" :val="item[1]" :atkcost="item[2]" :ishp="item[3]" :round="item[4]"></gamelog></h5>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
</div>
                            
                            

<script src="{{ asset('js/honeyapp.js') }}" ></script>

@endsection('content')