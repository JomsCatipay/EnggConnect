<?php 
	require_once 'DBhandle.php';

	$clearedFlag = 0;
	$err = $uname = $pass = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uname = clean_up($_POST["username"]);
		$pass = clean_up($_POST["password"]);
		if(loginUser($uname, $pass)!=0){ $err = "Invalid Username or Password"; }
		else header('Location: http://localhost/project');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Log In | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include 'header.php'; ?>

	<div id="main-block">
		<div id="form-content">
			<h2>Log In</h2>
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		    <input type="text" name="username" id="username" placeholder="Username" required/></br>
		    <input type="password" name="password" id="password" placeholder="Password" required/></br>
				<span><?php echo $err;?></span></br>
		    <input type="submit" id="submit" name="login" value="Login">
		  </form>
		</div>
		<div id="statements">
			<p>I am a statement.</p>
		</div>

		<?php include 'footer.php';?>
	</div>
		
</body>
</html>