@extends('layouts.master')

@section('content')

<div  id="qaform"  class="col-sm-10">

    <h1>Basic Questions</h1>

    <img style="width:100%; height:100%;" src="{{URL::asset('/images/qa1.png')}}" alt="Fourth slide">
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
                        <input class="form-check-input" type="radio" name="question_1"  value="1" 
                            {{ old('question_1') == "1" ? 'checked="checked"' : '' }}>
                        0
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_1"  value="2"
                            {{ old('question_1') == "2" ? 'checked="checked"' : '' }}>
                        1
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_1" value="3" 
                            {{ old('question_1') == "3" ? 'checked="checked"' : '' }}>
                        2
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_1" value="4" 
                            {{ old('question_1') == "4" ? 'checked="checked"' : '' }}>
                        3
                    </label>
                </div>

            </div>
        </fieldset>	

        <fieldset class="form-group row">
            <legend class="col-form-legend col-sm-10">2. How many points will be <b>lost</b> if you attack the right most node and it were a honeypot?</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-inputon 2')" type="radio" name="question_2"  value="1" 
                            {{ old('question_2') == "1" ? 'checked="checked"' : '' }}>
                        15
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_2"  value="2"
                            {{ old('question_2') == "2" ? 'checked="checked"' : '' }}>
                        20
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_2" value="3" 
                            {{ old('question_2') == "3" ? 'checked="checked"' : '' }}>
                        10
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_2" value="4" 
                            {{ old('question_2') == "4" ? 'checked="checked"' : '' }}>
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
                        <input class="form-check-input" type="radio" name="question_3"  value="1" 
                            {{ old('question_3') == "1" ? 'checked="checked"' : '' }}>
                        true
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="question_3"  value="2"
                            {{ old('question_3') == "2" ? 'checked="checked"' : '' }}>
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



@endsection('content')