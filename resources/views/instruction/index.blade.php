@extends('layouts.master')




@section('content')




<div class="col-md-8 col-md-offset-2">


	
	<form method="POST" action="/instruction">
	 {{ csrf_field() }}
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" name="pass" id="exampleInputPassword1" placeholder="Password">
  </div>
  
 
  <div class="form-group">
    <label for="exampleTextarea">Action</label>
    <textarea class="form-control" name="action" id="exampleTextarea" rows="3"></textarea>
  </div>
  
  <fieldset class="form-group">
    <legend>Are you a psycho?</legend>
    <div class="form-check">
      <label class="form-check-label">
        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="1" checked>
        Yes
      </label>
    </div>
    <div class="form-check">
    <label class="form-check-label">
        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="0">
        No
      </label>
    </div>
    
  </fieldset>


  <fieldset class="form-group">
    <legend>Are you a narccicist?</legend>
    <div class="form-check">
      <label class="form-check-label">
        <input type="radio" class="form-check-input" name="nar" id="optionsRadios1" value="1" checked>
        Yes
      </label>
    </div>
    <div class="form-check">
    <label class="form-check-label">
        <input type="radio" class="form-check-input" name="nar" id="optionsRadios2" value="0">
        No
      </label>
    </div>
    
  </fieldset>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>

@endsection('content')


