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
                width: 5vw;
                height: 5vw;
                text-align: center;
                padding: 0px 0;
                font-size: 2vw;
                line-height: 50%;
                border-radius: 50px;
            }
            
            .btn-circle-key {
                width: 5.3vw;
                height: 5.3vw;
                text-align: center;
                padding: 0px 0;
                font-size: 2vw;
                line-height: 0.9;
                border-radius: 50px;
            }
            
            
            .node-key {
                height: 85px;
                width: 85px;
            }

            
            h3 {
                font-size: 1.8vw;
            }
            
            h5 {
                font-size: 1.2vw;
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


            .attacked_honeypot {
                background-color: red;
            }

            .attacked_regular {
                background-color: green;
            }

            .public {
                background-color: purple;
            }

            .tentative_attacked{
                background-color: purple;
            }
            
            .node .attacked_honeypot{
                width: 6vw;
                height: 6vw;
            }
            
            .node .attacked_regular{
                width: 6vw;
                height: 6vw;
            }
            
            .attacked_honeypot .btn-circle {
                width: 5.5vw;
                height: 5.5vw;
                line-height: 0.9;
                border-radius: 60px;
                font-size: 110%;
            }
            
            .attacked_regular .btn-circle {
                width: 5.5vw;
                height: 5.5vw;
                line-height: 0.9;
                border-radius: 60px;
                font-size: 110%;
            }

            .buton {
                border-radius: 50%; 
                width: 50px;
                height: 50px;
                color: black;
            }

            .nextbutton {
                text-align: center;
                font-size: 1.5vw;
                width: 10vw;
                height: 3vw;
            }
            
            .passbutton {

                position: absolute;
                left: 600px;
                top: 290px;

            }

            .node {
                height: 5.5vw;
                width: 5.5vw;
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