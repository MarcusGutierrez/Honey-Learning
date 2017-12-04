@extends('layouts.master')

@section('content')

<div class="col-md-10 col-md-offset-2">

    <div class="card" style="width: 65rem;">

        <div>
            @include('layouts.errors')
        </div>
        
        <div class="card-header">
            <h4 class="card-title">Survey</h4>
        </div>
        <div class="card-block">
            <p class="card-text">Please indicate how much you agree with the following questions using the scale below:</p>
            <p class="card-text">Strongly Disagree(1)   Disagree(2) Neither Agree nor Disagree(3) Agree(4) Strongly Agree(5)</p>

            <form method="POST" action="/storesurvey/{{ $survey_type }}">
	 	
                {{ csrf_field()}}
                
                @foreach ($questions as $question)

                    @include('instruction.question')

                @endforeach	

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="cursor:pointer">Submit</button>
                </div>

            </form>

        </div>
        
    </div>

</div>

@endsection('content')