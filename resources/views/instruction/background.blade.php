@extends('layouts.master')

@section('content')

<div class="col-md-10 col-md-offset-2">

    <div class="card" style="width: 65rem;">

        <div>
            @include('layouts.errors')
        </div>
        
        <div class="card-header">
            <h4>Background Survey</h4>
        </div>
        <div class="card-block">

            <form method="POST" action="/storesurvey/{{ $survey_type }}">
	 	
                {{ csrf_field()}}
                
                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">1. What is your gender?</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q1"  value="male" 
                                    {{ old('q1') == "male" ? 'checked="checked"' : '' }}>
                                Male
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q1"  value="female"
                                    {{ old('q1') == "female" ? 'checked="checked"' : '' }}>
                                Female
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q1"  value="other"
                                    {{ old('q1') == "other" ? 'checked="checked"' : '' }}>
                                Other
                            </label>
                        </div>
                    </div>
                </fieldset>
                
                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">2. What is your age?</legend>
                    <div class="col-sm-10">
                        <input class="field" name="q2" type="text" value="{{ old('q2') }}">
                    </div>
                </fieldset>
                
                <!--
                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">What country do you live in?</legend>
                    <div class="col-sm-10">
                        <input class="field" name="q3" type="text" value="{{ old('q3') }}">
                    </div>
                </fieldset>
                -->
                
                <!--
                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">What is your race/ethnicity?</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q4"  value="black" 
                                    {{ old('q4') == "black" ? 'checked="checked"' : '' }}>
                                Black
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q4"  value="native north american"
                                    {{ old('q4') == "native north american" ? 'checked="checked"' : '' }}>
                                Native North American
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q4"  value="white"
                                    {{ old('q4') == "white" ? 'checked="checked"' : '' }}>
                                White/Caucasian
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q4"  value="asian"
                                    {{ old('q4') == "asian" ? 'checked="checked"' : '' }}>
                                Asian
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q4"  value="latino"
                                    {{ old('q4') == "latino" ? 'checked="checked"' : '' }}>
                                Latino/a
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q4"  value="other"
                                    {{ old('q4') == "other" ? 'checked="checked"' : '' }}>
                                Other
                            </label>
                        </div>
                    </div>
                </fieldset>
                -->
                
                <!--
                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">What is your highest completed form of education?</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q5"  value="some high school" 
                                    {{ old('q5') == "some high school" ? 'checked="checked"' : '' }}>
                                Some High School
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q5"  value="high school diploma"
                                    {{ old('q5') == "high school diploma" ? 'checked="checked"' : '' }}>
                                High School Diploma / GED
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q5"  value="some college"
                                    {{ old('q5') == "some college" ? 'checked="checked"' : '' }}>
                                Some College
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q5"  value="associates"
                                    {{ old('q5') == "associates" ? 'checked="checked"' : '' }}>
                                Associate's Degree
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q5"  value="bachelors"
                                    {{ old('q5') == "bachelors" ? 'checked="checked"' : '' }}>
                                Bachelor's Degree
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q5"  value="some graduate"
                                    {{ old('q5') == "some graduate" ? 'checked="checked"' : '' }}>
                                Some Graduate Education
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q5"  value="phd"
                                    {{ old('q5') == "phd" ? 'checked="checked"' : '' }}>
                                Ph.D.
                            </label>
                        </div>
                    </div>
                </fieldset>
                -->
                
                <!--
                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">What is your annual income (in U.S. Dollars)?</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q6"  value="0 - 15k" 
                                    {{ old('q6') == "0 - 15k" ? 'checked="checked"' : '' }}>
                                0 - 15,000
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q6"  value="15k - 30k"
                                    {{ old('q6') == "15k - 30k" ? 'checked="checked"' : '' }}>
                                15,000 - 30,000
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q6"  value="30k - 50k"
                                    {{ old('q6') == "30k - 50k" ? 'checked="checked"' : '' }}>
                                30,000 - 50,000
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q6"  value="50k - 75k"
                                    {{ old('q6') == "50k - 75k" ? 'checked="checked"' : '' }}>
                                50,000 - 75,000
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q6"  value="75k - 100k"
                                    {{ old('q6') == "75k - 100k" ? 'checked="checked"' : '' }}>
                                75,000 - 100,000
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q6"  value="above 100k"
                                    {{ old('q6') == "above 100k" ? 'checked="checked"' : '' }}>
                                Above 100,000
                            </label>
                        </div>
                    </div>
                </fieldset>
                -->
                
                <fieldset class="form-group row">
                    <legend class="col-form-legend col-sm-10">3. On what type of device did you complete this experiment on?</legend>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q3"  value="desktop computer" 
                                    {{ old('q3') == "desktop computer" ? 'checked="checked"' : '' }}>
                                Desktop Computer
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q3"  value="laptop mouse"
                                    {{ old('q3') == "laptop mouse" ? 'checked="checked"' : '' }}>
                                Laptop Computer with Mouse
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q3"  value="laptop touchpad"
                                    {{ old('q3') == "laptop touchpad" ? 'checked="checked"' : '' }}>
                                Laptop Computer with Touchpad
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q3"  value="tablet"
                                    {{ old('q3') == "tablet" ? 'checked="checked"' : '' }}>
                                Tablet
                            </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="radio" name="q3"  value="mobile"
                                    {{ old('q3') == "mobile" ? 'checked="checked"' : '' }}>
                                Mobile Phone
                            </label>
                        </div>
                    </div>
                </fieldset>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="cursor:pointer">Submit</button>
                </div>

            </form>

        </div>
        
    </div>

</div>

@endsection('content')