<?php session_start(); ?>
<?php
	require_once 'meekrodb.2.3.class.php';
    DB::$user = 'EnggConnect';
    DB::$password = 'password';
    DB::$dbName = 'EnggConnectTest';
	DB::debugMode();

	$post = $_POST['post'];
	DB::insert('Posts', array('post' => $post));

	header('Location: http://localhost/project');
?>