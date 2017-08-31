<fieldset class="form-group row">
    <legend class="col-form-legend col-sm-10"><b>Question {{$question->question_number}})</b> {{ $question->body }}</legend>
        <div class="col-sm-10">
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}"  value="1"
                    {{ old('q'.$question->question_number) == "1" ? 'checked="checked"' : '' }}>
                    Strongly Disagree
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}"  value="2"
                    {{ old('q'.$question->question_number)=="2" ? 'checked="checked"' : '' }}>
                    Disagree
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}" value="3"
                    {{ old('q'.$question->question_number)=="3" ? 'checked="checked"' : '' }}>
                    Neither Agree nor Disagree
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}"  value="4"
                    {{ old('q'.$question->question_number)=="4" ? 'checked="checked"' : '' }}>
                    Agree
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}" value="5"
                    {{ old('q'.$question->question_number)=="5" ? 'checked="checked"' : '' }}>
                    Strongly Agree
                </label>
            </div>

        </div>
</fieldset>