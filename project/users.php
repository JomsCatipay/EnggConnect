<?php
	if(isset($_SESSION['loggedin'])) header('Location: http://localhost/project/login.php');
	require_once 'DBhandle.php';

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(!empty($_POST['enqueue'])){
			if($_POST['type']=='Contributor') enqueueUser($_POST['id'], 'Upgrade');
			else enqueueUser($_POST['id'], 'Downgrade');
		}
		if(!empty($_POST['confirm'])){
			updateQueue($_POST['id']);
		}
	}

	$queue = getQueuedUsers();
	$users = searchUsers();
	shuffle($users);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Users | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include "header.php";?>

	<!-- queue -->
	<div id="main-block">
	<h2>Upgrade/Downgrade Requests for Approval</h2>
	<?php foreach($queue as $que): 
		$row = getUser($que['u_id']);
	?>
		<div id="u_<?php echo $row['user_id']?>">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<p> <h3><?php echo $row['username']?></h3>
					<?php if(isset($row['snum'])) echo $row['snum']?></br>
					<?php echo $row['dept']?></br>
					<input type="hidden" name="id" value="<?php echo $que['u_id'];?>">
					<?php if($row['type']=='Administrator'):?>
						<input type="submit" name="confirm" value="Confirm Degrade"></input>
					<?php else:?>
						<input type="submit" name="confirm" value="Confirm Upgrade"></input>
					<?php endif;?></br>
					____________________________________________________________________
				</p>
			</form>
		</div>
	<?php endforeach;?>

	<!-- others -->
	<h2>Users not in Queue</h2>
	<?php foreach($users as $row): ?>
		<div id="u_<?php echo $row['user_id']?>">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<p> <h3><?php echo $row['username']?></h3>
					<?php if(isset($row['snum'])) echo $row['snum']?></br>
					<?php echo $row['dept']?></br>
					<input type="hidden" name="type" value="<?php echo $row['type'];?>">
					<input type="hidden" name="id" value="<?php echo $row['user_id'];?>">
					<?php if($row['type']=='Administrator'):?>
						<input type="submit" name="enqueue" value="Degrade Account"></input>
					<?php else:?>
						<input type="submit" name="enqueue" value="Upgrade Account"></input>
					<?php endif;?></br>
					____________________________________________________________________
				</p>
			</form>
		</div>
	<?php endforeach;?>

	<?php include "footer.php";?>	
	</div>
</body>
</html>