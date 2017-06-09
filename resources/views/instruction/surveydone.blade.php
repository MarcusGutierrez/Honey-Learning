@extends('layouts.master')





@section('content')




<div class="col-md-10 col-md-offset-2">


	



	<div class="card" style="width: 65rem; height: 390rem;">
  <div class="card-header">
    
  </div>
  <div class="card-block">
    <h4 class="card-title">Thanks!</h4>
    <p class="card-text">Now start playing some games!</p>
 
    <button type="button" onclick="window.location='{{ url("games/1") }}'"  class="btn btn-outline-primary"">Start Psycho Game</button>
    <button type="button" onclick="window.location='{{ url("honey/1") }}'"  class="btn btn-outline-primary"">Start Honeypot Game</button>

    



    
  </div>
</div>

  







</div>

@endsection('content')