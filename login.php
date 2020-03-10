<?php

session_start();

if(isset($_SESSION['loggedIn'])){
    header("Location:tickets.php");
}

$err = '';
if(isset($_POST['login'])){
    $user = $_POST['user'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    $xml = simplexml_load_file("xml/users.xml");

    foreach($xml->user as $u){
        if($user == $u->username && password_verify($_POST['pass'], $u->password)){
            $_SESSION['loggedIn'] = $user;
            header("Location:tickets.php");
            exit();
        }
        else{
            $err = 'Invalid username or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Support Ticket System - Login</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <!-- Used this for help with form styling: https://www.codeply.com/go/nhbdi2FkJm/bootstrap-4-login-form -->
    <body class="text-center">
        <div class="box">
            <div class="col-lg-4 mx-auto">
                <div class="card rounded shadow">
                    <div class="card-header">
                        <h1 class="h2">Sign In</h1>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" autocomplete="off">
                            <div class="form-group">
                                <label for="user" class="sr-only">Username: </label>
                                <input type="text" id="user" name="user" placeholder="Enter a username..." class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="pass" class="sr-only">Password: </label>
                                <input type="password" id="pass" name="pass" placeholder="Enter a password..." class="form-control" required>
                            </div>
                            <span id="err"><?= $err ?></span>
                            <input type="submit" name="login" value="Login" class="btn btn-lg btn-block btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
