@php

$completion = 0;
$user_id = session()->get('user_id', null);
$ineligibility = session()->get('ineligible', false);

if($ineligibility == true || session()->get('experiment_completed', false) == true)
    $completion = 100;
else{
    $completion = 0;
    if(session()->get('consent_completed', false))
        $completion += 10;
    if(session()->get('background_completed', false))
        $completion += 0;
    if(session()->get('instruction_completed', false))
        $completion += 10;
    if(session()->get('concept_completed', false))
        $completion += 10;
    if(session()->get('practice_completed', false))
        $completion += 5;
    if(session()->get('session_completed', false))
        $completion += 50;
    else if(session()->get('session_id', false))
        $completion += session()->get('round_number', 0);
    if(session()->get('post_completed', false))
        $completion += 5;
    if(session()->get('triad_completed', false))
        $completion += 10;
}

@endphp

<script>
        history.go = function(){};
</script>


<div class="card text-center" style="position: relative;">
  
    <div class="card-footer text-muted">
        <h2>Honey Intrusion</h2>
        <!-- 
        <div style="padding-bottom: 20px;" class="container">
            <h4>Completion</h4>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-val      uemax="100" style="width:{{ $completion }}%">
                    <span class="sr-only">70% Complete</span>
                </div>
            </div>
        </div>
        -->
    </div>
</div>