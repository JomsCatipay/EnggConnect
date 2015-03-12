<?php 
	require_once 'DBhandle.php';
	$issue = getTopic($_GET['t_id']);
	$question = getQuestion($issue['topic_id']);
	$answers = getAnswers($question['q_id']);
	$posts = getPosts($question['q_id']);

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$p_ans = clean_up($_POST['answer']);
		$p_exp = clean_up($_POST['explination']);
		post($p_ans, $p_exp);
	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $issue['title'];?> | Eng'g Connect</title>
</head>
<body>
	<?php include "header.php"; ?>

	<div id="main_block">
		<div id="title">
			<h2><?php echo $issue['title']; ?></h2>
		</div>
		<div id="sub">
			<p> Posted on <?php echo $issue['date_of_post'];?> by <?php echo getUsername($issue['poster_id'])?> </p> </br>
		</div>
		<div id="details">
			<p> <?php echo $issue['details']?> </p>
		</div>
		<div id="question_block">
			<div id="question">
				<p> Question: </br>
					<?php
						if(!$question) echo "there is no question for this topic";
						else echo $question['question'];
					?>
				<p>
			</div>
			<div id="answer_choice">
				<?php 
					if(isset($_SESSION['loggedin']) && !empty($answers)):
				?>
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?t_id=<?php echo $_GET['t_id']?>">
					<?php foreach($answers as $row):?>
						<input type="radio" name="answer" value="<?php echo $row['a_id'];?>">
						<?php echo $row['answer'];?> </br>
					<?php endforeach;?>
					<input type="text" name="explination" placeholder="you may add an explanation">
					<input type="Submit" value="Submit">
				</form>
			<?php endif;?>
			</div>
		</div>
		<div id="answer_block">
			<!-- blah blah -->
		</div>
	</div>
	
	</br>
	<?php include 'footer.php';?>
</body>
</html>