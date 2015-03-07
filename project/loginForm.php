<?php
	session_start();
	ob_start();
    require_once 'meekrodb.2.3.class.php';
    DB::$user = 'EnggConnect';
    DB::$password = 'password';
    DB::$dbName = 'EnggConnectTest';

	$username = $_POST['username'];
	$password = $_POST['password'];

	$result = DB::query("SELECT * FROM users where username = %s", $username);
	foreach($result as $row){
		$hash = $row['password'];
		$hash = substr($hash, 0, 60);
		if(password_verify($password, $hash)){
			$_SESSION['loggedin'] = 1;
		}
		//echo "$row['username']";
	}
	header('Location: http://localhost/project');
/*
	$result = DB::queryFirstRow("SELECT * FROM Users where username = %s", $username);
	$hash = $result['password'];

	if (password_verify($password, $hash)) {
		$_SESSION['loggedin'] = 1;
		header('Location: http://localhost/project');
	} else {
		echo "Login failed";
	}
*/
?>