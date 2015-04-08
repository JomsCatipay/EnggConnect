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
	<?php foreach($posts as $row): 
		$que = getQuestion($row['topic_id']);
	?>
		<div id="l_<?php echo $row['topic_id']?>">
			<p> <a href="issue.php?t_id=<?php echo $row['topic_id']?>">
				<h3><?php echo $row['title']?></h3>
				<?php echo $row['details']?> </br></br>
				<?php echo $que['question']?>
				</a>
				</br>
				____________________________________________________________________
			</p>
		</div>
	<?php endforeach;?>

	<?php include "footer.php";?>	
	</div>

</body>
</html>