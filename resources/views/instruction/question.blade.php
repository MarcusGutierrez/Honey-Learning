<fieldset class="form-group row">
    <legend class="col-form-legend col-sm-10"><b>Question {{$question->question_number}})</b> {{ $question->body }}</legend>
        <div class="col-sm-10">
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="{{ $question->question_id }}"  value="1">
                    Strongly Disagree
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="{{ $question->question_id }}"  value="2">
                    Disagree
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="{{ $question->question_id }}" value="3">
                    Neither Agree nor Disagree
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="{{ $question->question_id }}"  value="4">
                    Agree
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="{{ $question->question_id }}" value="5">
                    Strongly Agree
                </label>
            </div>

        </div>
</fieldset>