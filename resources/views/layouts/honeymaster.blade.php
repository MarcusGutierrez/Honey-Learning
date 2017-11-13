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
                width: 10vmin;
                height: 10vmin;
                text-align: center;
                padding: 0px 0;
                font-size: 4vmin;
                line-height: 50%;
                border-radius: 50px;
            }
            
            .btn-circle-key {
                width: 9.8vmin;
                height: 9.8vmin;
                text-align: center;
                padding: 0px 0;
                font-size: 4vmin;
                line-height: 0.9;
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
                width: 12vmin;
                height: 12vmin;
            }
            
            .node .attacked_regular{
                width: 12vmin;
                height: 12vmin;
            }
            
            .attacked_honeypot .btn-circle {
                width: 10.6vmin;
                height: 10.6vmin;
                line-height: 0.9;
                font-size: 4.2vmin;
            }
            
            .attacked_regular .btn-circle {
                width: 10.6vmin;
                height: 10.6vmin;
                line-height: 0.9;
                font-size: 4.2vmin;
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
            }
            
            .passbutton {

                position: absolute;
                left: 600px;
                top: 290px;

            }

            .node {
                height: 11.5vmin;
                width: 11.5vmin;
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