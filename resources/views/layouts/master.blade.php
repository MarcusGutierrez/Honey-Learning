<!DOCTYPE html>
<html>
<head>
	<title>IASRL Experiment 2</title>
        
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

	<style type="text/css">

            input[type=radio] {
              display: inline;
              margin: 5px;
            }


            .visible {
                visibility: hidden;
            }



            .disable {
                pointer-events: none;
                opacity: 0.4;
            }


            .normal {
                    background-color: white;
            }


            .attacked {
                    background-color: red;
            }

            .possible {
                    background-color: yellow;
            }

            .public {
                    background-color: green;
            }

            .tentative_attacked{
                    background-color: purple;

            }

            .buton {
                    border-radius: 50%; 
                width: 50px;
                height: 50px;
                color: black;
            }

            .node0-pos {
                position: absolute;
                left: 20px;
                top: 100px;
            }

            .node1-pos {
                position: absolute;
                left: 150px;
                top: 200px;
            }

            .node2-pos {
                position: absolute;
                left: 200px;
                top: 10px;
            }

            .node3-pos {
                position: absolute;
                left: 420px;
                top: 90px;
            }

            .node4-pos {
                position: absolute;
                left: 600px;
                top: 150px;
            }
            .node5-pos {
                position: absolute;
                left: 400px;
                top: 10px;
            }
            .node6-pos {
                position: absolute;
                left: 200px;
                top: 200px;
            }
            .node7-pos {
                position: absolute;
                left: 300px;
                top: 240px;
            }
            .node8-pos {
                position: absolute;
                left: 750px;
                top: 30px;
            }
            .node9-pos {
                position: absolute;
                left: 750px;
                top: 120px;
            }

            .nextbutton {

                position: absolute;
                left: 365px;
                top: 290px;

            }

            .startbutton {

                position: absolute;
                left: 365px;
                top: 120px;
                background-color: white;

            }

            .confirmbutton {

                position: absolute;
                left: 365px;
                top: 290px;
                height: 50px;
                width: 100px;
            }

            .node {
                height: 100px;
                width: 100px;
            }

            .timerclass {
                position: absolute;
                left: 710px;
                top: 10px;
                background-color: gray;
                padding: 5px;
                color: blue;
            }
	</style>
</head>
<body>
    @include('layouts.header')
    @if($flash = session('message'))

    <div class="alert alert-success" role="alert" id="flashmessage">
        
        {{$flash}}

    </div>

    @endif   

    <div class="container">

            @yield('content')

    </div>

	@include('layouts.footer')



</body>
</html>