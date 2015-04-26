<?php
	require_once 'DBhandle.php';

	//$keywords = $_GET['key'];
	//$posts = getManyTopics(-1,$keywords);
	$posts = getManyTopics(-1);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Topics | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php include "header.php";?>
	<!-- possible search bar here -->

	<div id="main-block">
		<h2>Topics</h2>
		<div id="main-block">
			<div class="elem-list">
			<?php if(sizeof($posts)<1):?>
			<p>There are no Topics Yet.</p>
			<?php
				else: 
					foreach($posts as $row):
						$que = getQuestions($row['topic_id']);
			?>
				<a href="issue.php?t_id=<?php echo $row['topic_id']?>">
					<div class="topic-item">
						<h3><?php echo $row['title']?></h3>
						<p><?php echo substr($row['details'], 0, 350)?>...</p>
						<p id="questions">Questions:</p>
						<ul>
							<?php foreach($que as $que_r): ?>
								<li><p><?php echo $que_r['question']; ?></p></li>
							<?php endforeach; ?>
						</ul>
						
					</div>
				</a>
			<?php 
					endforeach;
				endif;
			?>
			</div>
		</div>

		<?php include "footer.php";?>	
	</div>
</body>
</html>