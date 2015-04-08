<?php 
	require_once 'DBhandle.php';
	if(isset($_GET['logoutG'])) logoutUser();
	$posts = getManyTopics(3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include 'header.php';?>
	<div id="main-block">
		<div id="desc">
			<p>Think.</p>
			<p>Discuss.</p>
			<p>Connect.</p>
		</div>

		<ul id="topic-display" style="clear: both">
			<?php
				foreach($posts as $row):
					$que = getQuestion($row['topic_id']);
			?>
				<li class="topic-entry">
					<div id="topic-title" style="clear: both">
						<a href="issue.php?t_id=<?php echo $row['topic_id']?>">
							<h2><?php echo $row['title']?></h2>
						</a>
						<?php
							$issue = getTopic($row['topic_id']);
						?>
						<p id="topic-footer">Posted on <?php echo $issue['date_of_post'];?></p>
					</div>
					<div id="topic-detail" text-overflow="ellipsis"><?php echo $row['details']?></div>
					<p id="q-sign">Q:</p>
					<a href="issue.php?t_id=<?php echo $row['topic_id']?>">
						<h3><?php echo $que['question']?></h3>
					</a>
				</li>
			<?php endforeach;?>
		</ul>
		<?php include 'footer.php';?>
	</div>
</body>
</html>