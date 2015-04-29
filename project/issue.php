<?php 
	require_once 'DBhandle.php';
	$issue = getTopic($_GET['t_id']);
	$flag = array();
	//$question = getQuestion($issue['topic_id']);

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(!empty($_POST['replyGo'])){
			$reply = clean_up($_POST['replyText']);
			$reply_rec = $_POST['reply_id'];
			//echo "reply ".$reply." to ".$reply_rec;
			reply($reply,$reply_rec);
		}
		else if(!empty($_POST['reportPost'])){
			$id = $_POST['post_id'];
			reportPost($id);
			//$post = getPost($id);
			//echo "reported ".$post['explanation'];
		}
		else if(!empty($_POST['reportReply'])){
			$id = $_POST['reply_id'];
			reportReply($id);
			//$post = getReply($id);
			//echo "reported ".$post['reply'];
		}
		else{	
			$q_id = clean_up($_POST['ans_id']);
			//echo $q_id;
			$p_ans = clean_up($_POST['answer']);
			if(!empty($p_ans)){
				$p_exp = clean_up($_POST['explanation']);
				post($p_ans, $q_id, $p_exp);
				$echos = $_GET['t_id'];
				//header("Location: https://localhost/project/issue.php?t_id=$echos");
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $issue['title'];?> | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="style_issue.css">
	<script src="TopicDynamic.js"></script>
</head>
<body>
	<?php include "header.php"; ?>

	<div id="main-block">
		<div id="main-content">
			<div id="topic-content">
				<div id="topic-header">
					<h2><?php echo $issue['title']; ?></h2>
					<p>Posted on <?php echo date("m/j/Y", strtotime($issue['date_of_post']));?> by <?php echo getUser($issue['poster_id'])['username']?></p>
				</div>
				<div id="topic-details">
					<p><?php echo $issue['details']?></p>
				</div>
			</div>
			<div id="topic-question">
				<?php
					$questions = getQuestions($issue['topic_id']);
					//$q_row = getQuestion($issue['topic_id']);
					//if(empty($q_row)) echo "there is no question for this topic";
					if(!empty($questions)):
						$qnum = 1;
						foreach ($questions as $q_row):
				?>
					<div class="question-item">
						<p id="question">Question #<?php echo $qnum;?>:</p>
						<p><?php echo $q_row['question']; ?></p>
						<ul class="answers">
							<?php 
									$answers = getAnswers($q_row['q_id']);
										if(!empty($answers)):
							?>
									<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?t_id=<?php echo $_GET['t_id']?>">
								<?php foreach($answers as $row): ?>
									<p class="vote-cnt"><?php echo $row['vote_count'];?></p>
									<?php if(isset($_SESSION['loggedin']) && !hasUserAnswered($q_row['q_id'])):?><input type="radio" name="answer" value="<?php echo $row['a_id'];?>" required><?php endif;?>
									<?php echo $row['answer'];?> </br>
								<?php 	endforeach;?>
								<input type="hidden" name='ans_id' id='ans_id' value='<?php echo $q_row['q_id']?>'>
								<?php if(isset($_SESSION['loggedin']) && !hasUserAnswered($q_row['q_id'])):?><input type="text" name="explanation" placeholder="you may add an explanation"><?php endif;?>
								<?php if(isset($_SESSION['loggedin']) && !hasUserAnswered($q_row['q_id'])):?><input type="Submit" value="Submit Answer"><?php endif;?>
								</form>
							<?php endif;?>
						</ul>
					</div>
				<?php 		$qnum++;
						endforeach;
					else: 
				?>
					<p id="no-question">There is no question for this topic</p>
				<?php endif; ?>
			</div>
			<div id="comments-section">
				<h3>Comments:</h3>
				<ul id="comments">
					<?php 
						foreach ($questions as $q_row):
							$posts = getPostsWithComments($q_row['q_id']);
							foreach($posts as $row): 
					?>
						<li class="comment-item">
							<p id="message"><?php echo $row['explanation']?></p></br>
							<p id="author">- <?php echo getUser($row['poster_id'])['username']?></p>
							<p id="author-info">answered <i><?php echo getAnswer($row['answer_id'])['answer']?></i> to <i><?php echo getQuestion($row['question_id'])['question']; ?></i></p>
							<?php if(isset($_SESSION['loggedin']) && !postHasReport($row['p_id'])):?>
							<form method='POST' id='rp<?php echo $row['p_id'];?>' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?t_id=<?php echo $_GET['t_id']?>'>
								<input type='hidden' name='post_id' value='<?php echo $row['p_id'];?>'>
								<input type='submit' name="reportPost" value='Report Post'>
							</form>
							<?php else:?>
							<p>Post has been reported</p>
							<?php endif;?>
							<ul class="replies_to_<?php echo $row['p_id']?>">
								<?php
									$reps = getReplies($row['p_id']); 
									foreach($reps as $r_row):?>
								<li class="reply-item">
									<p id="message"><?php echo $r_row['reply']?></p>
									<p id="replier">- <?php echo $r_row['poster_name'];?></p>
									<?php if(isset($_SESSION['loggedin']) && !replyHasReport($r_row['r_id'])):?>
									<form method='POST' id='rc<?php echo $r_row['r_id'];?>' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?t_id=<?php echo $_GET['t_id']?>'>
										<input type='hidden' name='reply_id' value='<?php echo $r_row['r_id'];?>'>
										<input type='submit' name="reportReply" value='Report Comment'>
									</form>
									<?php else:?>
									<p>Reply has been reported</p>
									<?php endif;?>
								</li>
								<?php endforeach;?>
							</ul>
							<div id="reply_button">
								<?php if(isset($_SESSION['loggedin']) && !hasUserReplied($row['p_id'])):?><input type='button' name='reply' id='rep<?php echo $row['p_id'];?>' value='Reply to this Comment' onclick="addReply(<?php echo $row['p_id'];?>); getElementById('reply_button').style.display = 'block'; this.style.display = 'none';"><?php endif;?>
							</div>
							<form method='POST' id='<?php echo $row['p_id'];?>' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?t_id=<?php echo $_GET['t_id']?>'>
							</form>
						</li>
					<?php
							endforeach;
						endforeach;
					?>
				</ul>
			</div>
		</div>
		<div id="aside">
			<h3>Related Topics</h3>
			<ul id="rel-topics">
				<?php
					$topics = getManyTopics(6);
					foreach($topics as $row):
				?>
				<li>
					<a href="issue.php?t_id=<?php echo $row['topic_id']?>"><?php echo $row['title']?></a>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
		<?php include 'footer.php';?>
	</div>

</body>
</html>