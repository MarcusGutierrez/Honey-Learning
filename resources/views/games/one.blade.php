@extends('layouts.master')


@section('content')




<div id="app"></div>

<div id="app2">
      <div class="row" id="cardrow">
        <div class="col-sm-9">
          <div class="card card-outline-primary" style="width: 52rem; height: 21.5rem;">
            <div class="card-block">

              <h5 class="card-title">Game {{ $id }}</h5>

                  <h4 class="timerclass">Timer! : @{{ timer }}</h4>

                  <a id="startbutton" class="btn btn-primary startbutton" style="cursor:pointer"  @click="startTimer">Click to start</a>
              
                  <a href='{{ url("games/2") }}' id="nextbutton" class="btn btn-primary visible disable nextbutton">Next Game</a>

                  <button id="confirmbutton" class="btn btn-primary confirmbutton visible" @click="confirmAttack">Confirm</button>


                  <div id="nodebuttons" class="visible">


                    
                  
                      <node :id="0"  class=" buton node0-pos " v-bind:neighbors="[]"  v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]"  v-bind:nodevalues= "[15, 5, 1]"></node>
                      <node :id="1" class="  buton node1-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[12, 6, 2]"></node> 
                      <node :id="2"  class="buton node2-pos" v-bind:neighbors="[]"  v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[5, 3, 1]"></node>
                      <node :id="3" class="buton node3-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[25, 10, 3]" ></node>
                      <node :id="4" class="buton node4-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[20, 9, 2]" ></node>
                      

                    
                      </div>

              
            </div>
          </div>
        </div>


        <div class="col-sm-3">
          <div class="card card-outline-primary ">
            <div class="card-block">
              <h3 class="card-title"> </h3>
              
              
              
              
             
              
              <h5>Round : @{{ numberofround }} (@{{ROUND_LIMIT}})</h5>
              <h5>Points : @{{attackerpoints}}</h5>
              

              
            </div>
          </div>
        </div>
      </div>





</div>











<script src="{{ asset('js/app.js') }}" ></script>





@endsection('content')