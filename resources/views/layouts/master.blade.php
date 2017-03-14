<!DOCTYPE html>
<html>
<head>
	<title>Risk Reward Game</title>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

	<style type="text/css">
		



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


.buton {
	border-radius: 50%; 
    width: 50px;
    height: 50px;
}

.relative {
    position: relative;
    left: 200px;
    top: 20px;
}

	</style>
</head>
<body>


	@include('layouts.header')



	<div class="container">

		@yield('content')

	</div>



	@include('layouts.footer')



</body>
</html>