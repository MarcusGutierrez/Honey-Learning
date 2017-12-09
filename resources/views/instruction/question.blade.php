<fieldset class="form-group row">
    <tr>
        <th style="border-right: 1px solid #000; width: 40%;">
            <legend class="col-form-legend col-sm-12"><b>{{$question->question_number}}.</b> {{ $question->body }}</legend>
        </th>
        <td>
            <span class="form-check form-check-inline" style="text-align: center;>
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}"  value="1"
                    {{ old('q'.$question->question_number) == "1" ? 'checked="checked"' : '' }}>
                </label>
            </span>
        </td>
        <td>
            <span class="form-check form-check-inline" style="text-align: center;>
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}"  value="2"
                    {{ old('q'.$question->question_number)=="2" ? 'checked="checked"' : '' }}>
                </label>
            </span>
        </td>
        <td>
            <span class="form-check form-check-inline" style="text-align: center;>
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}" value="3"
                    {{ old('q'.$question->question_number)=="3" ? 'checked="checked"' : '' }}>
                </label>
            </span>
        </td>
        <td>
            <span class="form-check form-check-inline" style="text-align: center;>
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}"  value="4"
                    {{ old('q'.$question->question_number)=="4" ? 'checked="checked"' : '' }}>
                </label>
            </span>
        </td>
        <td>
            <span class="form-check form-check-inline" style="text-align: center;>
                <label class="form-check-label">
                    <input class="form-check-input" type="radio" name="q{{ $question->question_number }}" value="5"
                    {{ old('q'.$question->question_number)=="5" ? 'checked="checked"' : '' }}>
                </label>
            </span>
        </td>
    </tr>
</fieldset>