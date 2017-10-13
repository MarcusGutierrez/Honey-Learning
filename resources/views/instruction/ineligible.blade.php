@extends('layouts.master')

@section('content')

@php

$completion = 100;

@endphp

<div class="col-md-10 col-md-offset-2">

    <div class="card" style="width: 56vw;">
        
        <div class="card-header">
            <h4 class="card-title">Ineligibility</h4>
        </div>
        <div class="card-block">
            <p class="card-text">Apologies, but you are not eligible to participate in this experiment.
                You may close this window at any time.
            </p>

            
        </div>
        
    </div>

</div>

@endsection('content')