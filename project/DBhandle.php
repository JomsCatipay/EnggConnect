<?php
	session_start();
	ob_start();
	require_once 'meekrodb.2.3.class.php';
	DB::$user = 'root';
	DB::$password = '';
	DB::$dbName = 'EnggConnectTest';

	//--USER FUNCTIONS
	function loginUser($uname, $pass){
		$result = DB::query("SELECT * FROM users where username = %s", $uname);
		if(!$result) return 1;
		foreach($result as $row){
			$hash = $row['password'];
			if(password_verify($pass, $hash)){
				$_SESSION['loggedin'] = 1;
				$_SESSION['loggedUser'] = $row;
				return 0;
			}
		}
		return 2;
	}
	function logoutUser(){
		session_destroy();
		header('Location: http://localhost/project');
	}
	function enqueueUser($user, $action){
		DB::insert('UserQueue', array(
	            'u_id' => $user,
	            'action' => $action,
	            'vote_count' => 0
	    ));
	}
	function updateQueue($entry){
		DB::insert('queuePosts', array(
			'admin_id' => $_SESSION['loggedUser']['user_id'],
			'pawn_id' => $entry
		));

		DB::query("UPDATE UserQueue SET vote_count=vote_count+1 WHERE u_id=%d", $entry);

		$result = DB::queryFirstRow("SELECT * FROM UserQueue WHERE u_id=%d", $entry);
		$check = DB::query("SELECT * FROM Users WHERE type='Administrator'");

		if($result['vote_count']>((count($check)-1)/2)){
			$pawn = DB::queryFirstRow("SELECT * FROM Users WHERE user_id=%d", $entry);
			if($pawn['type']=='Contributor') DB::query("UPDATE Users SET type='Administrator' WHERE user_id=%d", $entry);
			else DB::query("UPDATE Users SET type='Contributor' WHERE user_id=%d", $entry);

			DB::query("DELETE FROM UserQueue WHERE u_id=%d", $entry);
		}
	}

	//--GETTERS
	function getManyTopics($count){
		$result = DB::query("SELECT * FROM Topics ORDER BY date_of_post DESC");
		//$queM = DB::queryFirstRow("SELECT * FROM Questions WHERE topic_id = %d", $result[0]['topic_id']);
		if($count<0 || count($result)<=$count) return $result;
		$out = array();
		for($i=0; $i<$count; $i++){
			$out[] = $result[$i];
		}
		return $out;
	}
	function searchUsers(){
		$result = DB::query("SELECT * FROM Users WHERE user_id NOT IN(SELECT u_id FROM UserQueue) AND user_id!=%d", $_SESSION['loggedUser']['user_id']);
		//$queM = DB::queryFirstRow("SELECT * FROM Questions WHERE topic_id = %d", $result[0]['topic_id']);
		return $result;
		/*
		$out = array();
		foreach($result as $row){
			if($row['user_id']!=$_SESSION['user_id']){
				$out[] = $row;
			}
		}
		return $out;		
		//*/
	}
	function getQueuedUsers(){
		$result = DB::query("SELECT * FROM UserQueue ORDER BY date_of_post DESC", $_SESSION['loggedUser']['user_id']);
		return $result;
	}
	function getTopic($topic_id){
		$result = DB::queryFirstRow("SELECT * FROM Topics WHERE topic_id = %d", $topic_id);
		return $result;
	}
	function getUser($usr_id){
		$result = DB::queryFirstRow("SELECT * FROM Users WHERE user_id = %d", $usr_id);
		if(!$result) return array();
		return $result;
	}
	function getQuestions($topic_id){
		$result = DB::query("SELECT * FROM Questions WHERE topic_id = %d", $topic_id);
		return $result;
	}
	function getQuestion($id){
		$result = DB::queryFirstRow("SELECT * FROM Questions WHERE q_id = %d", $id);
		return $result;
	}
	function getAnswer($a_id){
		$result = DB::queryFirstRow("SELECT * FROM Answers WHERE a_id = %d", $a_id);
		return $result;
	}
	function getAnswers($q_id){
		$result = DB::query("SELECT * FROM Answers WHERE q_id = %d", $q_id);
		return $result;
	}
	function getPost($p_id){
		$result = DB::queryFirstRow("SELECT * FROM Posts WHERE p_id=%d",$p_id);
		return $result;
	}
	function getPosts($answer_id, $q_id){
		$result = DB::query("SELECT * FROM Posts WHERE answer_id=%d AND question_id=%d",$answer_id, $q_id);
		return $result;
	}
	function getPostsWithComments($q_id){
		$result = DB::query("SELECT * FROM Posts WHERE question_id=%d AND explanation!='' ", $q_id);
		return $result;
	}
	function getReportedPosts(){
		$result = DB::query("SELECT * FROM ReportedPosts");
		return $result;
	}
	function getReply($r_id){
		$result = DB::queryFirstRow("SELECT * FROM Replies WHERE r_id=%d",$r_id);
		return $result;
	}
	function getReplies($p_id){
		$result = DB::query("SELECT * FROM Replies WHERE p_id=%d",$p_id);
		return $result;
	}
	function getReportedReplies(){
		$result = DB::query("SELECT * FROM ReportedReplies");
		return $result;
	}

	//--ADDERS
	function addUser($uname, $pass, $snum, $dept){
	    $hash = password_hash($pass, PASSWORD_DEFAULT);
	    DB::insert('Users', array(
	            'username' => $uname,
	            'password' => $hash,
	            'dept' => $dept,
	            'snum' => $snum,
	            'type' => 'Contributor'
	    ));
	}
	function addTopic($title, $detail){
		DB::insert('Topics',array(
				'poster_id' => $_SESSION['loggedUser']['user_id'],
				'title' => $title,
				'details' => $detail
		));
		$result = DB::queryFirstRow("SELECT * FROM Topics WHERE title = %s", $title);
		return $result['topic_id'];
	}
	function addQuestion($topic_id, $question){
		DB::insert('Questions', array(
				'topic_id' => $topic_id,
				'question' => $question
		));
		$result = DB::queryFirstRow("SELECT * FROM Questions WHERE topic_id = %d AND question = %s", $topic_id, $question);
		return $result['q_id'];
	}
	function addAnswer($que_id, $answer){
		DB::insert('Answers', array(
				'q_id' => $que_id,
				'answer' => $answer
		));
	}
	function post($a_id, $que_id, $exp){
		$pawn = DB::queryFirstRow("SELECT * FROM Answers WHERE a_id = %d", $a_id);

	    DB::insert('Posts', array(
	          	'poster_id' => $_SESSION['loggedUser']['user_id'],
	            'answer_id' => $pawn['a_id'],
	            'question_id' => $que_id,
	            'explanation' => $exp
	    ));

	    DB::query("UPDATE Answers SET vote_count=vote_count+1 WHERE a_id=%d", $a_id);
	}
	function reply($reply,$p_id){
		DB::insert('Replies', array(
			'p_id' => $p_id,
			'poster_name' => $_SESSION['loggedUser']['username'],
			'reply' => $reply
		));
	}
	function reportPost($id){
		DB::insert('ReportedPosts', array(
				'post_id' => $id,
				'reporter_id' => $_SESSION['loggedUser']['user_id']
			));
	}
	function reportReply($id){
		DB::insert('ReportedReplies', array(
				'reply_id' => $id,
				'reporter_id' => $_SESSION['loggedUser']['user_id']
			));
	}

	//--DELETE
	function deletePost($id){
		echo $id;
	    DB::query("UPDATE Posts SET explanation='' WHERE p_id=%d", $id);
		DB::query("DELETE FROM Replies WHERE p_id=%d", $id);
		DB::query("DELETE FROM ReportedPosts WHERE post_id=%d", $id);
	}
	function deleteReportP($id){
		DB::query("DELETE FROM ReportedPosts WHERE post_id=%d", $id);
	}
	function deleteReply($id){
		DB::query("DELETE FROM Replies WHERE r_id=%d", $id);
		DB::query("DELETE FROM ReportedReplies WHERE reply_id=%d", $id);		
	}
	function deleteReportR($id){
		DB::query("DELETE FROM ReportedReplies WHERE reply_id=%d", $id);		
	}

	//--AUXILLARY
	function clean_up($input){
		return htmlspecialchars(stripslashes(trim($input)));
	}
	function hasUserAnswered($q_id){
		$result = DB::query("SELECT * FROM Posts WHERE poster_id=%d AND question_id=%d", $_SESSION['loggedUser']['user_id'], $q_id);
		//echo sizeof($result);
		return !empty($result);
	}
	function hasUserReplied($p_id){
		$result = DB::query("SELECT * FROM Replies WHERE poster_name=%s AND p_id=%d", $_SESSION['loggedUser']['username'], $p_id);
		return !empty($result);
	}
	function hasVoted($u_id){
		$result = DB::query("SELECT * FROM QueuePosts WHERE admin_id=%s AND pawn_id=%s", $_SESSION['loggedUser']['user_id'], $u_id);
		return !empty($result);
	}
	function postHasReport($id){
		$result = DB::query("SELECT * FROM ReportedPosts WHERE post_id=%d",$id);
		return !empty($result);
	}
	function replyHasReport($id){
		$result = DB::query("SELECT * FROM ReportedReplies WHERE reply_id=%d",$id);
		return !empty($result);
	}
?>