<?php
	require_once 'DBhandle.php';
	if(!isset($_SESSION['loggedin'])) header('Location: http://localhost/project/login.php');
	if($_SESSION['loggedUser']['type']=='Contributor') header('Location: http://localhost/project/index.php');

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
	<link rel="stylesheet" type="text/css" href="style-manage.css">
</head>
<body>
	<?php include "header.php";?>

	<!-- queue -->
	<div id="main-block">
		<div id="requests">
			<h2 style="margin-bottom: 10px">Upgrade/Downgrade Requests for Approval</h2>
			<?php
				$temp = 0; 
				foreach($queue as $que): 
				$row = getUser($que['u_id']);
			?>
				<div id="user">
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<p id="uname"><?php echo $row['username']?></p>
						<p id="snum"><?php if(isset($row['snum'])) echo $row['snum']?></p>
						<p id="dept"><?php echo $row['dept']?></p>
						<input type="hidden" name="id" value="<?php echo $que['u_id'];?>">
						<p id="vote-count">Vote Count: <?php echo $que['vote_count'] ?></p>
						<?php if(!hasVoted($que['u_id'])): ?>
							<?php if($row['type']=='Administrator'):?>
								<input type="submit" name="confirm" value="Confirm Degrade" <?php if($row['user_id']==$_SESSION['loggedUser']['user_id']) echo 'disabled';?> />
							<?php else:?>
								<input type="submit" name="confirm" value="Confirm Upgrade" />
						<?php 
								endif;
							endif;
						?>
					</form>
				</div>
			<?php endforeach;?>
		</div>

	<!-- others -->
		<div id="userlist">
			<h2 style="margin-bottom: 10px">Users not in Queue</h2>
			<?php foreach($users as $row): ?>
				<div id="user">
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<p id="uname"><?php echo $row['username']?></p>
						<p id="snum"><?php if(isset($row['snum'])) echo $row['snum']?></p>
						<p id="dept"><?php echo $row['dept']?></p>
						<input type="hidden" name="type" value="<?php echo $row['type'];?>">
						<input type="hidden" name="id" value="<?php echo $row['user_id'];?>">
						<?php if($row['type']=='Administrator'):?>
							<input type="submit" name="enqueue" value="Degrade Account"></input>
						<?php else:?>
							<input type="submit" name="enqueue" value="Upgrade Account"></input>
						<?php endif;?>
					</form>
				</div>
			<?php endforeach;?>
		</div>
		
		<?php include "footer.php";?>	
	</div>
</body>
</html>