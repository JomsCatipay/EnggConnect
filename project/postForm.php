<?php session_start(); ?>
<?php
	require_once 'meekrodb.2.3.class.php';
	DB::$user = 'joms';
	DB::$password = 'IaMj0ej0e';
	DB::$dbName = 'MicroBlog';
	DB::debugMode();

	$microBlog = $_POST['microBlog'];
	DB::insert('MicroBlog', array('post' => $microBlog));

	header('Location: http://localhost/project');
?>