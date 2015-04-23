<?php
	if(isset($_SESSION['loggedin'])) header('Location: http://localhost/EnggConnect/project/login.php');
	require_once 'DBhandle.php';

	$title = $detail = "";
	$qList = array();
	$aList = array();
	$titErr = $detErr = $queErr = $ansErr = "";
	$clearedFlag = 37;

	//nested arrays
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty($_POST["topic_title"])){ $titErr = " * Required"; $clearedFlag=1; }
		else $title = clean_up($_POST["topic_title"]);

		if(strcmp($_POST["topic_detail"],"")==0){ $detErr = " * Required"; $clearedFlag=1; }
		else $detail = clean_up($_POST["topic_detail"]);

		$i = 1;
		foreach ($_POST["questions[]"] as $eachInput) {
			$tag = "answers{$i}";
			if(strcmp($eachInput, "")==0){ $queErr = "* A question is not filled"; $clearedFlag=1;}
			else{
				$qList[] = $eachInput;
				$ansList = array();
				foreach ($_POST[$tag] as $lol) {
					if(strcmp($lol, "")!=0){ $ansList[] = $lol; }
				}
				if(sizeof($ansList)<2){ $ansErr = "* There must be atleast 2 answers to a question"; $clearedFlag=1;}
				array_push($aList, $ansList);
			}
			$i++;
		}

		if($clearedFlag==37){
			$t_id = addTopic($title, $detail);
			$index=0;
			$q_id=0;
			foreach ($qList as $eachInput) {
				//echo $eachInput;
				$q_id = addQuestion($t_id, $eachInput);
				//echo "-".$q_id."-";
				foreach($aList[$index] as $row){
					//echo $row." ";
					addAnswer($q_id, $row);
				}
				//echo " out ";
				$index++;
			}
			header('Location: http://localhost/EnggConnect/project');
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add New Topic | Eng'g Connect</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="style-manage.css">
	<script src="AddIssueDynamics.js"></script>
</head>
<body>
	<?php include "header.php";?>

	<div id="main-block">
		<div id="add-topic">
			<h2>Add New Topic</h2>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<input type="text" name="topic_title" id="title" placeholder="Title" value="<?php echo $title;?>" required/><span style="color:red;font-weight:bold"><?php echo $titErr;?></span></br>
				<textarea name="topic_detail" id="detail" placeholder="These are the details for the issue." rows="5" cols="50" required><?php echo $detail;?></textarea><span style="color:red;font-weight:bold"><?php echo $detErr;?></span></br> 
				<h3>Questions:</h3>
				<div id="questions">
				<?php
					$i = 1; 
					foreach ($qList as $quest): ?>
					<div class="question-item" id='question<?php echo $i;?>'>
						<input name='questions[]' type='text' size='50' placeholder='Question' value='<?php echo $quest;?>' onload="queCountAdd()" required/>
						<h3>Answers:</h3>
						<div id='answers<?php echo $i;?>'>
							<?php
								$j = 0; 
								foreach($aList[$i-1] as $ans):?>
							<div id='answer<?php echo $i;?>-<?php echo $j; ?>'>
								<input type='text' size='50' name='answers<?php echo $i?>[]' placeholder='Answer' value='<?php echo $ans?>' required/></br>
							</div>
							<?php
								$j++;
							endforeach;?>
						</div>
						<div class="answer-commands">
							<input type='button' name='add_answer' id='addAnswerButton' value='Add an Answer' onclick='addAnswer(<?php echo $i?>)'>
							<input type='button' name='del_answer' id='delAnswerButton' value='Delete last Answer' onclick='delAnswer(<?php echo $i?>)'>
						</div>
					</div>
					<script type="text/javascript">
						var count = <?php echo $j; ?>;
						queCountAdd(count);
					</script>
				<?php
						$i++;
					endforeach;
				?>
				</div>
				<div id="question-commands">
					<input type="button" name="add_question" id="addQuestionButton" value="Add a Question" onclick="addQuestion()">
					<input type="button" name="del_question" id="delQuestionButton" value="Delete last Question" onclick="delQuestion()">
				</div>
				</br></br>
				<span class="error-msg"><?php echo $queErr;?></span>
				<span class="error-msg"><?php echo $ansErr;?></span>
				<input type="submit" name="submit_issue" id="submitButton" value="Add">
			</form>
		</div>
		<?php include "footer.php";?>
	</div>
</body>
</html>