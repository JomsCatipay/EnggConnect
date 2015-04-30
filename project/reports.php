<?php
	require_once 'DBhandle.php';
	if(!isset($_SESSION['loggedin'])) header('Location: http://localhost/project/login.php');
	if($_SESSION['loggedUser']['type']== 'Contributor') header('Location: http://localhost/project/index.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(!empty($_POST['confirmP'])){
			deletePost($_POST['pid']);
		}
		else if(!empty($_POST['ignoreP'])){
			deleteReportP($_POST['pid']);
		}
		if(!empty($_POST['confirmR'])){
			deleteReply($_POST['rid']);
		}
		else if(!empty($_POST['ignoreR'])){
			deleteReportR($_POST['rid']);
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
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="style-manage.css">
</head>
<body>
	<?php include "header.php";?>
	<div id="main-block">
		<div id="rep-posts">
			<h2 style="margin-bottom: 10px">Reported Comments</h2>
			<?php foreach ($posts as $row): 
					$post = getPost($row['post_id']);
			?>
				<div class="rep-item">
					<p id="message"><?php echo $post['explanation']; ?></p>
					<p id="poster">Posted by <?php echo getUser($post['poster_id'])['username']; ?></p>
					<p id="reporter">Reported by <?php echo getUser($row['reporter_id'])['username']; ?> at <?php echo date("m/j/Y", strtotime($row['date_of_post'])); ?></p>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<input type="hidden" name="pid" value="<?php echo $row['post_id'];?>" />
						<input type="submit" name="confirmP" value="Delete Post" />
						<input type="submit" name="ignoreP" value="Ignore Report" />
					</form>
				</div>
			<?php endforeach; ?>
		</div>
		
		<div id="rep-replies">
			<h2>Reported Replies</h2>
			<?php foreach ($replies as $row): 
					$reply = getReply($row['reply_id']);
			?>
				<div class="rep-item">
					<p id="message"><?php echo $reply['reply']; ?></p>
					<p id="poster">Posted by <?php echo $reply['poster_name']; ?></p>
					<p id="reporter">Reported by <?php echo getUser($row['reporter_id'])['username']; ?> at <?php echo date("m/j/Y", strtotime($row['date_of_post'])); ?></p>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<input type="hidden" name="rid" value="<?php echo $reply['r_id'];?>" />
						<input type="submit" name="confirmR" value="Delete Reply" />
						<input type="submit" name="ignoreR" value="Ignore Report" />
					</form>
				</div>
			<?php endforeach; ?>
		</div>

		<?php include "footer.php";?>	
	</div>
</body>
</html>