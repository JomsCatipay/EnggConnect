<?php
	require_once 'DBhandle.php';
	if(!isset($_SESSION['loggedin'])) header('Location: http://localhost/project/login.php');
	if($_SESSION['loggedUser']['type']== 'Contributor') header('Location: http://localhost/project/index.php');

	$depts = ['ChE', 'CE', 'CS', 'EEE', 'GE', 'IE', 'ME', 'MMM'];
	$counts = [0,0,0,0,0,0,0,0];

	$topics = getManyTopics(-1);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Statistics | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="style-manage.css">
</head>
<body>
	<?php include "header.php";?>
	<div id="main-block">
		<div id="topics">
			<h2>Statistics</h2>
			<div class="elem-list">
			<?php if(sizeof($topics)<1):?>
				<p>There are no Topics yet.</p>
			<?php else:
				foreach($topics as $t_row):
			?>
				<div class="topic-item">
				<h3><?php echo $t_row['title'];?></h3>
				<ul>
				<?php 
					$questions = getQuestions($t_row['topic_id']);
					if(empty($questions)):
				?>
					<p>Topic has no question.</p>
				<?php endif;?>
				<?php foreach($questions as $q_row):?>
					<li>
						<p id="questions"><?php echo $q_row['question'];?></p>
						<?php 
							$answers = getAnswers($q_row['q_id']);	
							$total_votes = 0;
						?>
						<ul>
							<?php foreach($answers as $a_row):?>
							<li>
								<p id="ans"><?php echo $a_row['answer'];?></p>
								<p id="ans-cnt">Votes: <?php echo $a_row['vote_count'];?></p>
								</br>
								<?php 
									$total_votes=$total_votes+$a_row['vote_count']; 
									$counts = [0,0,0,0,0,0,0,0];
								?>
								<!-- lagay na per department -->
								<div id="dept-list">
									<?php
										$posts = getPosts($a_row['a_id'],$q_row['q_id']);
										foreach($posts as $p_row){
											$deptPawn = getUser($p_row['poster_id'])['dept'];
											for($i=0; $i<8; $i++){
												if($deptPawn==$depts[$i]):
													$counts[$i]++;
													break;
												endif;
											}
										}
										for($i=0; $i<8; $i++):
									?>
										<p class="dept-item"><?php echo $depts[$i];?>: <?php echo $counts[$i]?></p>
									<?php endfor;?>
								</div>
							</li>
							<?php endforeach;?>
						</ul>
						<p id="total">Total Voters: <?php echo $total_votes;?></p>
					</li>
				<?php endforeach;?>
				</ul>
				</div>
			<?php endforeach;
			endif; ?>
			</div>
		</div>
		
		<?php include "footer.php";?>	
	</div>
</body>
</html>