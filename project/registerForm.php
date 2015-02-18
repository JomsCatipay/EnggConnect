<?php
        require_once 'meekrodb.2.3.class.php';
        DB::$user = 'joms';
        DB::$password = 'IaMj0ej0e';
        DB::$dbName = 'MicroBlog';

        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);

        DB::insert('Credentials', array(
                'username' => $username,
                'password' => $hash
        ));

        header('Location: http://localhost/project');
?>