<?php 
	require_once 'DBhandle.php';
	if(isset($_SESSION['loggedin'])) header('Location: http://localhost/project/index.php');

	$clearedFlag = 37;
	$uErr = $pErr = $p2Err = $dErr = $sErr = "";
	$user = $pass = $pass2 = $dept = $snum = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_POST["username"])){ $uErr = " * Required"; $clearedFlag=1; }
		else $user = clean_up($_POST["username"]);

		if(empty($_POST["studentnumber"])) {$sErr = " * Required";  $clearedFlag=1;}
		elseif(!ctype_digit($_POST["studentnumber"]) || strlen($_POST["studentnumber"])!=9 || strpos($_POST["studentnumber"], "20")!=0){
			$sErr = " * Must follow format 20yyxxxxx";  $clearedFlag=1; }
		else $snum = clean_up($_POST["studentnumber"]);
		
		if(empty($_POST["password"])){ $pErr = " * Required"; $clearedFlag=1; }
		elseif (strlen($_POST["password"])<8){ $pErr = " * Must be atleast 8 characters long";  $clearedFlag=1; }
		else{
			$pass = clean_up($_POST["password"]);
			if($_POST["password2"] != $_POST["password"]) { $p2Err = " * Must be equal to password";  $clearedFlag=1;}
			else $pass2 = clean_up($_POST["password2"]);
		}
				
		if(empty($_POST["department"])){$dErr = " * Required";  $clearedFlag=1;}
		else $dept = clean_up($_POST["department"]);

		if($clearedFlag==37){
			addUser($user, $pass, $snum, $dept);
			loginUser($user, $pass);
			header('Location: http://localhost/project');
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sign Up | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include 'header.php'; ?>
	<div id="main-block">
		<div id="form-content">
			<h2>Sign Up</h2>
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		    <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $user ?>" maxlength="20" required/> <span class="error-msg"><?php echo $uErr;?></span> </br>
		    <input type="text" name="studentnumber" id="snum" placeholder="Student Number" value="<?php echo $snum ?>" required/> <span class="error-msg"><?php echo $sErr;?></span> </br>
		    <input type="password" name="password" id="password" placeholder="Password" value="" required/> <span class="error-msg"><?php echo $pErr;?></span> </br>
		    <input type="password" name="password2" id="p2" placeholder="Retype Password" value="<?php echo $pass2 ?>" required/> <span class="error-msg"><?php echo $p2Err;?></span> </br>
		    <select name="department" required/>
		  		<option value="">Department/Institute</option>
		  		<option value="Che">Department of Chemical Engineering</option>
		  		<option value="CE">Institute of Civil Engineering</option>
		  		<option value="CS">Department of Computer Science</option>
		  		<option value="EEE">Electrical and Electronics Engineering Institute</option>
		  		<option value="GE">Department of Geodetic Engineering</option>
		  		<option value="IE">Department of Industrial Engineeringand Operations Research</option>
		  		<option value="ME">Department of Mechanical Engineering</option>
		  		<option value="MMM">Department of Mining, Metallurgical, and Materials Engineering</option>
		  	</select><span class="error-msg"><?php echo $dErr;?></span></br>
		    <input type="submit" id="submit" value="Create Account">
		  </form>
		</div>
		<div id="statements">
			<p>I am a statement.</p>
		</div>
		<?php include 'footer.php';?>
	</div>
</body>
</html>