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
	<link rel="stylesheet" type="text/css" href="style.css" -->
</head>
<body>
	<?php include "header.php";?>
	<div id="main-block">
		<?php foreach($topics as $t_row):?>
			<h3><?php echo $t_row['title'];?></h3>
			<ul>
			<?php 
				$questions = getQuestions($t_row['topic_id']);
				if(empty($questions)):
			?>
			<p>Topic has no Question<p>
			<?php endif;?>
			<?php foreach($questions as $q_row):?>
				<li>
					<p><?php echo $q_row['question'];?></p>
					<?php 
						$answers = getAnswers($q_row['q_id']);	
						$total_votes = 0;
					?>
					<ul>
						<?php foreach($answers as $a_row):?>
						<li>
							<p><?php echo $a_row['answer'];?> | Votes: <?php echo $a_row['vote_count'];?></p>
							<?php $total_votes=$total_votes+$a_row['vote_count']; ?>
							<!-- lagay na per department -->
							</br>
							<?php
								$posts = getPosts($a_row['a_id'],$q_row['q_id']);

								foreach($posts as $p_row){
									$deptPawn = getUser($p_row['poster_id'])['dept'];
									for($i=0; $i<8; $i++){
										if($deptPawn==$depts[$i]) $counts[$i]++;
										break;
									}
									echo "here";
								}

								for($i=0; $i<8; $i++):
							?>
								<p><?php echo $depts[$i];?> : <?php echo $counts[$i]?></p>
							<?php endfor;?>
							</br>
						</li>
						<?php endforeach;?>
					</ul>
					<p>Total Voters: <?php echo $total_votes;?></p> 
					</br>
				</li>
			<?php endforeach;?>
			</ul>
		</br></br>
		<?php endforeach;?>

	<?php include "footer.php";?>	
	</div>
</body>
</html>