@extends('layouts.honeymaster')

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

            <form method="POST" action="/storesurvey/{{ $survey_type }}">
                
                <table style="width: 100%; border-collapse:collapse;">
                    <tr>
                        <th style="border-right: 1px solid #000; border-bottom: 1px solid #000;"></th>
                        <th style="border-bottom: 1px solid #000;">
                            @if ( $survey_type == "post")
                                never
                            @elseif ( $survey_type == "triad")
                                strongly disagree
                            @endif
                            <br>
                            1
                        </th>
                        <th style="border-bottom: 1px solid #000;">
                            @if ( $survey_type == "post")
                                rarely
                            @elseif ( $survey_type == "triad")
                                disagree
                            @endif
                            <br>
                            2
                        </th>
                        <th style="border-bottom: 1px solid #000;">
                            @if ( $survey_type == "post")
                                sometimes
                            @elseif ( $survey_type == "triad")
                                neither agree nor disagree
                            @endif
                            <br>
                            3
                        </th>
                        <th style="border-bottom: 1px solid #000;">
                            @if ( $survey_type == "post")
                                often
                            @elseif ( $survey_type == "triad")
                                agree
                            @endif
                            <br>
                            4
                        </th>
                        <th style="border-bottom: 1px solid #000;">
                            @if ( $survey_type == "post")
                                always
                            @elseif ( $survey_type == "triad")
                                strongly agree
                            @endif
                            <br>
                            5
                        </th>
                    </tr>
                    @foreach ($questions as $question)
                        
                            @include('instruction.question')
                        
                    @endforeach
                    
                    @if ( $survey_type == "post" && ($defender_type == 'def1' || $defender_type == 'def2' || $defender_type == 'def3'))
                        
                        @php
                            $question = \honeysec\Question::where('type', $defender_type)->first();
                        @endphp
                        @include('instruction.question')
                        
                    @endif
                
                </table>
                
                {{ csrf_field()}}
                
                <br><br>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="cursor:pointer">Submit</button>
                </div>

            </form>

        </div>
        
    </div>

</div>

@endsection('content')