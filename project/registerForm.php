<?php
    require_once 'meekrodb.2.3.class.php';
    DB::$user = 'EnggConnect';
    DB::$password = 'password';
    DB::$dbName = 'EnggConnectTest';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    DB::insert('Users', array(
            'username' => $username,
            'password' => $hash
    ));

    header('Location: http://localhost/project');
?>