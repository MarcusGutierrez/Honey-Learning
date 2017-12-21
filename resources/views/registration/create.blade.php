@extends('layouts.master')

@section('content')
    
<div class="col-sm-8">
    <p style="text-align: justify; text-justify: inner-word; font-size: 1.1em;">
        In this study you will be making repeated decisions in the honey intrusion cybersecurity game. 
        Every cyber-security situation involves at least two players: one that aims 
        at attacking a network (i.e., Attacker), and another one that aims at 
        defending a network (i.e., Defender).   In this game you will play the role 
        of the Attacker, while the Defender is played by the computer.
    </p>

    <p style="text-align: justify; text-justify: inner-word; font-size: 1.1em;">
        Each decision you make can result in gaining or losing points. Your goal is 
        to earn as many points as possible by attacking “real” nodes in the 
        network and avoiding “honeypots”. Honeypots are nodes a defender assigns to 
        deceive an attacker. These fake nodes may look like real nodes, but they 
        cause you to <b>lose</b> points rather than <b>gain</b> points in the game.
    </p>

    <p style="text-align: justify; text-justify: inner-word; font-size: 1.1em;">
        You make decisions for 50 rounds of the game. After completing the game, 
        you will also be asked to answer 3 short questionnaires. This study is 
        expected to take 30 minutes. You will be paid $2.50 for fully completing 
        the experiment. You will also be awarded $0.01 for every point 
        accumulated in the game. Every point counts, and thus, you need to pay 
        attention to every decision while aiming to avoid honeypots.
    </p>
</div>

<div  id="regform" class="col-sm-4">

    <h2>Sign In</h2>
    <form method="POST" action="/signin">

        {{ csrf_field()}}

        <div class="form-group">
            <label for="turk_id" style="font-size: 1.1em;">Mechanical Turk Worker ID</label>
            <input type="text" class="form-control" @change="createId" name="turk_id" id="school" required>
        </div>

        <div class="form-group">
            <input type="hidden"  v-model="user_id" class="form-control" name="user_id" id="user_id" required>
        </div>

        <div class="form-group">
            <button type="submit" @click="createId" style="cursor:pointer" class="btn btn-primary">Submit</button>
        </div>

        <div>	
            @include('layouts.errors')
        </div>

    </form>


</div>

<script src="https://unpkg.com/vue" ></script>
<script src="{{ asset('js/main.js') }}" ></script>

@endsection('content')