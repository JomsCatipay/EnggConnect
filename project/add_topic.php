<?php
	require_once 'DBhandle.php';
	$ans_count=2;
	$i=0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add New Topic | Eng'g Connect</title>
	<meta charset="utf-8">
</head>
<body>
	<?php include "header.php";?>
	<h2>Add New Topic</h2>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<input type="text" name="topic_title" id="title" placeholder="Title"> </br>
		<textarea name="topic_detail" id="detail" rows="5" cols="50">These are the details for the issue</textarea></br> 
		<!-- <input type="text" name="topic_detail" id="detail" rows="5" placeholder="Details"> </br> -->
		<input name="topic_question" id="question" type="text" size="39" placeholder="Question"></br>
		Answers: </br>
		<?php for($i=0; $i<$ans_count; $i = $i+1): ?>
			<input type="text" size="100" name="answer<?php echo $i?>" id="answer<?php echo $i?>" placeholder="answer <?php echo $i+1; ?>"></br>
		<?php endfor; ?>
		<input type="button" name="add_answer" id="addAnswerButton" value="Add another answer" onclick="<?php $ans_count++; ?>"></br>
		</br>
		<input type="submit" name="submit_issue" id="submitButton" value="Add">
	</form>
	<?php include "footer.php";?>
</body>
</html>