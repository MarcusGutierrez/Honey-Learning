<!DOCTYPE html>
<html>
<head>
	<title>Honey Learning Game</title>
        
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

	<style type="text/css">

            input[type=radio] {
              display: inline;
              margin: 5px;
            }
            
            .btn-circle {
                width: 85px;
                height: 85px;
                text-align: center;
                padding: 0px 0;
                font-size: 28px;
                line-height: 2.35;
                border-radius: 50px;
            }
            
            .btn-circle-key {
                width: 75px;
                height: 75px;
                text-align: center;
                padding: 0px 0;
                font-size: 23px;
                line-height: 2.35;
                border-radius: 50px;
            }
            
            
            .node-key {
                height: 85px;
                width: 85px;
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
            
            .node .tentative_attacked{
                width: 105px;
                height: 105px;
            }
            
            .tentative_attacked .btn-circle {
                width: 90px;
                height: 90px;
                font-size: 31px;
            }

            .buton {
                border-radius: 50%; 
                width: 50px;
                height: 50px;
                color: black;
            }
            
            .button {
                font-size: 22px;
            }

            .nextbutton {
                text-align: center;
                position: absolute;
                left: 495px;
                top: 420px;
            }
            
            .passbutton {

                position: absolute;
                left: 600px;
                top: 290px;

            }

            .startbutton {
                text-align: center;
                position: absolute;
                left: 485px;
                top: 420px;
                background-color: white;

            }

            .confirmbutton {
                text-align: center;
                position: absolute;
                left: 500px;
                top: 420px;
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
            
            .tooltip{
                display: inline;
                position: relative;
            }
            
            .tooltip:hover:before{
                border: solid;
                border-color: #333 transparent;
                border-width: 6px 6px 0 6px;
                bottom: 20px;
                content: "";
                left: 50%;
                position: absolute;
                z-index: 99;
            }
            
            .tooltip:hover:after{
                background: #333;
                background: rgba(0,0,0,.8);
                border-radius: 5px;
                bottom: 26px;
                color: #fff;
                content: attr(title);
                left: 20%;
                padding: 5px 15px;
                position: absolute;
                z-index: 98;
                width: 220px;
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