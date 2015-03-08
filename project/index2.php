<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test</title>
</head>
<body>
	<?php
	require_once 'meekrodb.2.3.class.php';
    DB::$user = 'EnggConnect';
    DB::$password = 'password';
    DB::$dbName = 'EnggConnectTest';
	if(isset($_SESSION['loggedin'])){
		echo '
		<form action="postForm.php" method="post">
			<TextArea name="Post" id="Post" cols="30" rows="10"></TextArea>
			<input type="submit">
		</form>
		';
		 echo '<a href="logout.php">Log Out</a>';
		 $result = DB::query("SELECT post FROM Posts");
		 foreach ($result as $row) {
		 	echo " <div class='Posts'>".$row['post']."</div> ";
		 }
	}
    else {
    	echo '
        <form action="loginForm.php" method="post">
            Username: <input type="text" name="username" id="username" /> </br>
            Password: <input type="text" name="password" id="password" />
            <input type="submit">
	    </form>
	    ';
	     echo '<a href="register.php">Register</a>';
    }
    //header('Location: http://localhost/test.php');
	?> 
</body>
</html>