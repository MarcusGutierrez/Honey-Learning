@extends('layouts.master')

@section('content')

<div  id="qaform"  class="col-sm-8">

    <h1>Basic Questions</h1>

    <img  style="width: 120%; height: 120%" src="{{URL::asset('/images/qa1.png')}}" alt="Fourth slide">
    <h4>All Questions below refer to the above scenario</h4>
    
    <div>
        @include('layouts.errors')
    </div>

    <form method="POST" action="/instruction/concept">

        {{ csrf_field()}}

        <fieldset class="form-group row">
            <legend class="col-form-legend col-sm-10">1. What is the <b>maximum number</b> of nodes that the defender can turn into <b>honeypots</b> in the above scenario?</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_1"  value="1" >
                        0
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_1"  value="2">
                        1
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_1" value="3" >
                        2
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_1" value="4" >
                        3
                    </label>
                </div>

            </div>
        </fieldset>	

        <fieldset class="form-group row">
            <legend class="col-form-legend col-sm-10">2. How many points will be <b>lost</b> if you attack the right most node?</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_2"  value="1" >
                        15
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_2"  value="2">
                        20
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_2" value="3" >
                        10
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_2" value="4" >
                        0
                    </label>
                </div>

            </div>
        </fieldset>	
        <fieldset class="form-group row">
            <legend class="col-form-legend col-sm-10">3. True or False: <b>Passing</b> will deduct points from your score.</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_3"  value="1" >
                        true
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_3"  value="2">
                        false
                    </label>
                </div>

            </div>
        </fieldset>		  	  

        <div class="form-group">
            <button type="submit" style="cursor:pointer" class="btn btn-primary">Submit</button>
        </div>

    </form>

</div>

<script src="https://unpkg.com/vue" ></script>
<script src="{{ asset('js/qa.js') }}" ></script>



@endsection('content')