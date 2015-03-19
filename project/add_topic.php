<?php
	require_once 'DBhandle.php';

	$title = $question = "";
	$detail = "These are the details for the issue";
	$titErr = $detErr = $queErr = "";
	$clearedFlag = 0;

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_POST["title"])){ $uErr = " * Required"; $clearedFlag=1; }
		else $user = clean_up($_POST["username"]);		

		$answers = $_POST["answers"];
		foreach ($answers as $eachInput) {
		}
	}
}?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add New Topic | Eng'g Connect</title>
	<meta charset="utf-8">
	<script src="myFirst.js"></script>
</head>
<body>
	<?php include "header.php";?>
	<h2>Add New Topic</h2>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="text" name="topic_title" id="title" placeholder="Title" value="<?php echo $title;?>"> </br>
		<textarea name="topic_detail" id="detail" rows="5" cols="50"><?php echo $detail;?></textarea></br> 
		<input name="topic_question" id="question" type="text" size="39" placeholder="Question" value="<?php echo $question;?>"></br>
		Answers: </br>
		<div id="answers">
		</div>
		<input type="button" name="add_answer" id="addAnswerButton" value="Add an answer" onclick="addAnswer()"></br>
		<input type="button" name="del_answer" id="delAnswerButton" value="Delete last answer" onclick="delAnswer()"></br>
		</br>
		<input type="submit" name="submit_issue" id="submitButton" value="Add">
	</form>
	<?php include "footer.php";?>
</body>
</html>