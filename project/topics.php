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
		<div id="topics">
			<h2>Topics</h2>
			<?php if(sizeof($posts)<1):?>
				<p>There are no Topics yet.</p>
			<?php
				else: 
					foreach($posts as $row):
						$que = getQuestions($row['topic_id']);
			?>
				<div class="elem-list">
					<a href="issue.php?t_id=<?php echo $row['topic_id']?>">
						<div class="topic-item">
							<h3><?php echo $row['title']?></h3>
							<p><?php echo substr($row['details'], 0, 200)?>...</p>
							<?php if(!empty($que)): ?>
								<p id="questions">Questions:</p>
								<ul>
									<?php foreach($que as $que_r): ?>
										<li><p><?php echo $que_r['question']; ?></p></li>
									<?php endforeach; ?>
								</ul>
							<?php endif;?>
						</div>
					</a>
				</div>
			<?php 
				endforeach;
			endif;
			?>
		</div>
		
		<?php include "footer.php";?>	
	</div>
</body>
</html>