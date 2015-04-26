<?php
	require_once 'DBhandle.php';
	if(!isset($_SESSION['loggedin'])) header('Location: http://localhost/project/login.php');
	if($_SESSION['loggedUser']['type']== 'Contributor') header('Location: http://localhost/project/index.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(!empty($_POST['confirmP'])){
			deletePost($_POST['id']);
		}
		else if(!empty($_POST['ignoreP'])){
			deleteReportP($_POST['id']);
		}
		if(!empty($_POST['confirmR'])){
			deleteReply($_POST['id']);
		}
		else if(!empty($_POST['ignoreR'])){
			deleteReportR($_POST['id']);
		}
	}

	$posts = getReportedPosts();
	$replies = getReportedReplies();

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reports | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css" -->
</head>
<body>
	<?php include "header.php";?>
	<div id="main-block">
		<h2>Reports</h2>

		<h3>Reported Posts:</h3>
		<?php foreach ($posts as $row): 
				$po = getPost($row['post_id']);
		?>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<p> <h3><?php echo $po['explanation']; ?></h3>
					- Posted by <?php echo getUser($po['poster_id'])['username']; ?></br>
					- Reported by <?php echo getUser($row['reporter_id'])['username']; ?> at <?php echo $row['date_of_post']; ?>
					<input type="hidden" name="id" value="<?php echo $po['p_id'];?>"></br>
					<input type="submit" name="confirmP" value="Delete Post"></input>
					<input type="submit" name="ignoreP" value="Ignore Report"></input>
					</br>
					____________________________________________________________________
				</p>
		<?php endforeach; ?>

		
		<h3>Reported Replies:</h3>
		<?php foreach ($replies as $row): 
				$po = getReply($row['reply_id']);
		?>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<p> <h3><?php echo $po['reply']; ?></h3>
					- Posted by <?php echo $po['poster_name']; ?></br>
					- Reported by <?php echo getUser($row['reporter_id'])['username']; ?> at <?php echo $row['date_of_post']; ?>
					<input type="hidden" name="id" value="<?php echo $po['r_id'];?>"></br>
					<input type="submit" name="confirmR" value="Delete Reply"></input>
					<input type="submit" name="ignoreR" value="Ignore Report"></input>
					</br>
					____________________________________________________________________
				</p>
		<?php endforeach; ?>
		
	<?php include "footer.php";?>	
	</div>
</body>
</html>