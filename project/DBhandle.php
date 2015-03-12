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
				$_SESSION['loggedUser'] = $row['user_id'];
				return 0;
			}
		}
		return 2;
	}
	function logoutUser(){
		session_destroy();
		header('Location: http://localhost/project');
	}

	//--GETTERS
	function getHomeTopics(){
		$result = DB::query("SELECT * FROM Topics ORDER BY date_of_post");
		//$queM = DB::queryFirstRow("SELECT * FROM Questions WHERE topic_id = %d", $result[0]['topic_id']);
		if(count($result)<=3) return $result;
		return array($result[0],$result[1],$result[2]);
	}
	function getTopic($topic_id){
		$result = DB::queryFirstRow("SELECT * FROM Topics WHERE topic_id = %d", $topic_id);
		return $result;
	}
	function getUsername($usr_id){
		$result = DB::queryFirstRow("SELECT * FROM Users WHERE user_id = %d", $usr_id);
		if(!$result) return "Anonymous";
		return $result['username'];
	}
	function getQuestion($topic_id){
		$result = DB::queryFirstRow("SELECT * FROM Questions WHERE topic_id = %d", $topic_id);
		return $result;
	}
	function getAnswers($q_id){
		$result = DB::query("SELECT * FROM Answers WHERE q_id = %d", $q_id);
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
	function post($ans_id, $exp){
	    DB::insert('Posts', array(
	          	'poster_id' => $_SESSION['loggedUser'],
	            'answer_id' => $ans_id,
	            'explanation' => $exp,
	    ));
	}

	function clean_up($input){
		return htmlspecialchars(stripslashes(trim($input)));
	}
?>