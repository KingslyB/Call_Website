<?php
$title = "Sign In";
include("./includes/header.php");


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["sign-in-email"]);
    $password = trim($_POST["sign-in-password"]);
    

    if(attemptLogin($email, $password)){
        header("Location: dashboard.php");
    };
    
}
?>
<form method="post">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <input type="text" name="sign-in-email" placeholder="Email">
    <input type="password" name="sign-in-password" placeholder="Password">
    <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Sign in</button>
    <a href="index.php"><button class="btn btn-lg btn-warning btn-block">Cancel</button></a>
</form>

<a href="register.php"><button class="btn btn-lg btn-warning btn-block">Register</button></a>
