<?php session_start(); ?>
<?php
	require_once 'meekrodb.2.3.class.php';
    DB::$user = 'EnggConnect';
    DB::$password = 'password';
    DB::$dbName = 'EnggConnectTest';
	DB::debugMode();

	$microBlog = $_POST['microBlog'];
	DB::insert('Posts', array('post' => $microBlog));

	header('Location: http://localhost/project');
?>