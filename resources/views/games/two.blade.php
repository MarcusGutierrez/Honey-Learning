@extends('layouts.master')


@section('content')





<p>Game {{ $id }}</p>


<button type="button" onclick="window.location='{{ url("games/3") }}'"  class="btn btn-outline-primary"">Next</button>







@endsection('content')