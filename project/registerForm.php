<?php
    require_once 'meekrodb.2.3.class.php';
    DB::$user = 'EnggConnect';
    DB::$password = 'password';
    DB::$dbName = 'EnggConnectTest';

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $check = $_POST['password2'];
    $num = $_POST['studentnumber'];
    if($password != $password || !ctype_digit($num) || strlen($num)!=9){
        header('Location: http://localhost/project/register.html');
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $dept = $_POST['department'];

    DB::insert('Users', array(
            'username' => $username,
            'password' => $hash,
            'dept' => $dept,
            'snum' => $num,
            'type' => 'Contributor'
    ));
    header('Location: http://localhost/project');
?>