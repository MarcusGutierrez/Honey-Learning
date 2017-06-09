@extends('layouts.master')





@section('content')




<div class="col-md-8 col-md-offset-2" style="margin: 10px; padding: 10px">


@if(Auth::check())


  <div class="card text-center" style="width: 50rem; height: 17rem;">
  
  <div class="card-block">
    <h4 class="card-title"> Welcome {{ Auth::user()->name }}!</h4>
    <p class="card-text">Start by taking a survey.</p>
    <button type="button" onclick="window.location='{{ url("/survey") }}'"  class="btn btn-outline-primary"">Take survey</button>
  </div>
  
</div>



@endif


@if(!Auth::check())

<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block">
        <h3 class="card-title">Register</h3>
        <p class="card-text">Register for full access</p>
        
        

		<button type="button btn btn-primary" onclick="window.location='{{ url("/register") }}'"  class="btn btn-outline-primary"">Register</button>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block">
        <h3 class="card-title">Login</h3>
        <p class="card-text">Login to play the games</p>
        <button type="button btn btn-primary" onclick="window.location='{{ url("/login") }}'"  class="btn btn-outline-primary"">Login</button>
      </div>
    </div>
  </div>
</div>
@endif
	

</div>

@endsection('content')


