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
					$que = getQuestions($row['topic_id']);
			?>
				<li class="topic-entry">
					<div id="topic-title" style="clear: both">
						<a href="issue.php?t_id=<?php echo $row['topic_id']?>">
							<h2><?php echo $row['title']?></h2>
						</a>
						<p id="topic-footer">Posted on <?php echo date("m/j/Y", strtotime($row['date_of_post']));?></p>
					</div>
					<div id="topic-detail">
						<p><?php echo substr($row['details'], 0, 250)?>...
						(<a href="issue.php?t_id=<?php echo $row['topic_id']?>">see more</a>)</p>
					</div>
					<?php 
						$iter = 1;
						foreach($que as $que_r):
					?>
					<div id="topic-que">
						<p id="q-sign">Q<?php echo $iter?>:</p>
						<a href="issue.php?t_id=<?php echo $row['topic_id']?>">
							<p id="q-text"><?php echo $que_r['question']?></p>
						</a>
					</div>
					<?php 
						$iter++;
						endforeach;
					?>
				</li>
			<?php endforeach;?>
		</ul>
		<?php include 'footer.php';?>
	</div>
</body>
</html>