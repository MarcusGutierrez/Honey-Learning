@extends('layouts.master')


@section('content')




<div id="app"></div>

<div id="app2">



      <div class="row" id="cardrow">
        <div class="col-sm-9">
          <div class="card card-outline-primary" style="width: 52rem; height: 21.5rem;">
            <div class="card-block">

              <h3 class="card-title">Game {{ $id }}</h3>
              
                  <a href='{{ url("games/2") }}' id="nextbutton" class="btn btn-primary visible disable nextbutton">Next Game</a>
                  <div id="nodebuttons" class="visible">


                    
                  
                      <node :id="0"  class=" buton node0-pos " v-bind:neighbors="[]"  v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]"  v-bind:nodevalues= "[15, 5, 1]"></node>
                      <node :id="1" class="  buton node1-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[12, 10, 2]"></node> 
                      <node :id="2"  class="buton node2-pos" v-bind:neighbors="[]"  v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[5, 3, 1]"></node>
                      <node :id="3" class="buton node3-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[25, 1, 3]" ></node>
                      <node :id="4" class="buton node4-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[20, 5, 2]" ></node>
                      <node :id="5" class="buton node5-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[15, 5, 2]" ></node> 
                      <node :id="6" class="buton node6-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[35, 10, 3]" ></node>
                      <node :id="7" class="buton node7-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[2, 1, 1]" ></node>
                      <node :id="8" class="buton node8-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[25, 5, 3]" ></node>
                      <node :id="9" class="buton node9-pos " v-bind:neighbors="[]" v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]" v-bind:nodevalues= "[30, 9, 2]" ></node> 

                    
                      </div>

              
            </div>
          </div>
        </div>


        <div class="col-sm-3">
          <div class="card card-outline-primary ">
            <div class="card-block">
              <h3 class="card-title"> </h3>
              
              <button id="startbutton" class="btn btn-outline-primary startbutton"  @click="startTimer">start</button>
              <button id="confirmbutton" class="btn btn-outline-primary confirmbutton" @click="confirmAttack">confirm</button>
              
             
              <h4>Timer : @{{ timer }}</h4>
              <h4>Round : @{{ numberofround }} (@{{ROUND_LIMIT}})</h4>
              <p>Points : @{{attackerpoints}}</p>
              

              
            </div>
          </div>
        </div>
      </div>





</div>











<script src="{{ asset('js/app.js') }}" ></script>





@endsection('content')