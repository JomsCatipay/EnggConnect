<?php 
	require_once 'DBhandle.php';
	if(isset($_GET['logoutG'])) logoutUser();
	$posts = getHomeTopics();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home | Eng'g Connect</title>
</head>
<body>
	<?php include 'header.php';?>
	<div id="main_block">
		<div id="desc"> <p> Description of EnggConnect Here </p> </div>

		<?php
			foreach($posts as $row):
				$que = getQuestion($row['topic_id']);
		?>
		<div id="t_<?php echo $row['topic_id']?>">
			<p> <a href="issue.php?t_id=<?php echo $row['topic_id']?>">
				<h3><?php echo $row['title']?></h3>
				<?php echo $row['details']?> </br></br>
				<?php echo $que['question']?>
				</a>
				</br>
			</p>
		</div>
	</div>
	<?php endforeach;?>

	<?php include 'footer.php';?>
</body>
</html>