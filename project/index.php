<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
</head>
<body>
	<?php
	if(isset($_SESSION['loggedin'])){
		header('Location: http://localhost/project/home.html');
	}
    else {
	    header('Location: http://localhost/project/login.html');    	
    }
	?> 
</body>
</html>