<?php
	if(isset($_SESSION['loggedin'])) header('Location: http://localhost/project/login.php');
	require_once 'DBhandle.php';

	$title = $question = $detail = "";
	$titErr = $detErr = $queErr = "";
	$clearedFlag = 37;

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_POST["topic_title"])){ $titErr = " * Required"; $clearedFlag=1; }
		else $title = clean_up($_POST["topic_title"]);

		if(strcmp($_POST["topic_detail"],"These are the details for the issue")==0){ $detErr = " * Required"; $clearedFlag=1; }
		else $detail = clean_up($_POST["topic_detail"]);
//*/
		if(empty($_POST["topic_question"])){ $queErr = " * Required"; $clearedFlag=1; }
		else $question = clean_up($_POST["topic_question"]);

		if($clearedFlag==37){
			$t_id = addTopic($title, $detail);
			$q_id = addQuestion($t_id, $question);
			if(isset($_POST["answers"])){
				$answers = $_POST["answers"];
				foreach ($answers as $eachInput) {
					if(strcmp($eachInput, "")!=0){ addAnswer($q_id, $eachInput); }
				}
			}
			header('Location: http://localhost/project');
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add New Topic | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="AddIssueDynamics.js"></script>
</head>
<body>
	<?php include "header.php";?>

	<div id="main-block">
		<div id="add-topic">
			<h2>Add New Topic</h2>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<input type="text" name="topic_title" id="title" placeholder="Title" value="<?php echo $title;?>"></br>
				<textarea name="topic_detail" id="detail" placeholder="These are the details for the issue." rows="5" cols="50"><?php echo $detail;?></textarea></br> 
				<input name="topic_question" id="question" type="text" size="39" placeholder="Question" value="<?php echo $question;?>">
				<h3>Answers:</h3>
				<div id="answers">
				</div>
				<input type="button" name="add_answer" id="addAnswerButton" value="Add an answer" onclick="addAnswer()">
				<input type="button" name="del_answer" id="delAnswerButton" value="Delete last answer" onclick="delAnswer()">
				</br></br>
				<input type="submit" name="submit_issue" id="submitButton" value="Add">
			</form>
		</div>
		<?php include "footer.php";?>
	</div>
</body>
</html>