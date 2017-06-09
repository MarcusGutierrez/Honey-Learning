@extends('layouts.honeymaster')

@section('content')

<div id="honeyapp">
    <div class="row" id="cardrow">
        <div class="col-sm-9">
            <div class="card card-outline-primary" style="width: 52rem; height: 21.5rem;">
                <div class="card-block">

                    <h5 class="card-title">Game ID: {{ $honey_game->gid }}</h5>

                    <!-- <h4 class="timerclass">Timer: @{{ timer }}</h4> -->

                    <a id="startbutton" class="btn btn-primary startbutton" style="cursor:pointer"  @click="startTimer">Click to start</a>

                    <!--<a href='{{ url("honey/2") }}' id="nextbutton" class="btn btn-primary visible disable nextbutton">Next Game</a>-->

                    <button id="confirmbutton" class="btn btn-primary confirmbutton visible" style="cursor:pointer" @click="confirmAttack">Confirm</button>

                    <div id="nodebuttons" class="visible">
                        
                        @foreach ($honey_nodes as $node)
                        
                        
                            <node
                                :id="{{ $node->nid }}"
                                :val="{{ $node->value }}"
                                :defcost="{{ $node->defender_cost }}"
                                :atkcost="{{ $node->attacker_cost }}"
                                :hp="{{ $node->is_honeypot }}"  
                                :pub="{{ $node->is_public }}"
                                :succ="{{ $node->probability }}"
                                :disc="{{ $node->discount }}"
                                :style="{ position: 'absolute', left: {{ $node->x_axis }}+'px', top: {{ $node->y_axis }}+'px' }"
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
            <div class="card card-outline-primary ">
                <div class="card-block">
                    <h3 class="card-title"> </h3>
                    <h4>Round: @{{ numberofround }}</h4>
                    <h5>Attacker Points: @{{ attackerpoints }}</h5>
                    <h5>Attacks Remaining: @{{ attackAttempts }}</h5>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row" id="cardrow2">
        <div class="col-sm-9">
            <div class="card card-outline-primary" style="width: 52rem; height: 16.5rem;">
                <div class="card-block">

                    <h5 class="card-title"><b>Defender View</b><br>Budget: {{ $honey_game->def_budget }}</h5>

                    <div id="testid">
                        
                        @foreach ($honey_nodes as $node)
                        
                            <div style="position:absolute; left:{{ $node->x_axis }}px; top: {{ $node->y_axis }}px;">
                                <button class="btn btn-circle node">
                                    <span class="btn btn-circle normal">
                                        {{ $node->value }}
                                    </span>
                                </button>
                                <div style="text-align:center; font-size:25px">
                                    C: {{ $node->defender_cost }}
                                </div>
                            </div>
                            
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                            
                            

<script src="{{ asset('js/honeyapp.js') }}" ></script>

@endsection('content')