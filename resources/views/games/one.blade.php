@extends('layouts.master')


@section('content')


<div id="app">
	


  <p>Game {{ $id }}</p>


  <button class="btn btn-outline-primary" @click="startTimer">start</button>
  <p>Timer : @{{ timer }} (move before timer goes down to 0)</p>
  <p>Round : @{{ numberofround }} (3)</p>
  <p>Points : @{{attackerpoints}}</p>



  <node :id="1"  class="buton relative" v-bind:neighbors="[2, 3]"  v-on:applied="onCouponApplied(id)" v-bind:cla="[true, false, false, false]"  v-bind:nodevalues= "[10, 5, 1]"></node>
  <node :id="2" class="buton relative" v-bind:neighbors="[1, 3, 4 ]" v-on:applied="onCouponApplied(id)" v-bind:cla="[false, true, false, false]" v-bind:nodevalues= "[20, 10, 3]"></node>	
  <node :id="3"  class="buton relative" v-bind:neighbors="[1, 2, 4]"  v-on:applied="onCouponApplied(id)" v-bind:cla="[false, true, false, false]" v-bind:nodevalues= "[5, 3, 1]"></node>
  <node :id="4" class="buton relative" v-bind:neighbors="[2, 3]" v-on:applied="onCouponApplied(id)" v-bind:cla="[false, true, false, false]" v-bind:nodevalues= "[2, 1, 1]" ></node>			

</div>







<button type="button" onclick="window.location='{{ url("games/2") }}'"  class="btn btn-outline-primary"">Next</button>





<script src="{{ asset('js/app.js') }}" ></script>





@endsection('content')


