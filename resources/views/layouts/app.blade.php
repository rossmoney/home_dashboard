<html lang="en"> 
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Weebpad Wallboard</title>
		
		<link type="text/css" rel="stylesheet" href="https://unpkg.com/tailwindcss@0.3.0/dist/tailwind.min.css" />
		<link type="text/css" rel="stylesheet" href="css/wallboard.css"/>

		@yield('css')
	</head>
	<body>
		@yield('content')
	
		@yield('js')
	</body>
</html>