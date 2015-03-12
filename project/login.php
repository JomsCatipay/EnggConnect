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
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login | Eng'g Connect</title>
</head>
<body>
	<?php include 'header.php'; ?>
	<h2>Login</h2>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<span style="color:red;font-weight:bold"><?php echo $err;?></span> </br>
        <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $uname?>" /> </br>
        <input type="password" name="password" id="password" placeholder="Password" value="<?php echo $pass?>" /> </br>
        <input type="submit" name="login" value="Login">
    </form>

	<?php include 'footer.php';?>
</body>
</html>