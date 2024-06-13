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

<?php displayErrorList(); ?>

<form method="POST">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <input type="text" name="sign-in-email" placeholder="Email">
    <input type="password" name="sign-in-password" placeholder="Password">
    <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Sign in</button>

</form>
<a href="index.php"><button class="btn btn-lg btn-warning btn-block">Cancel</button></a>
<a href="forgot-password.php"><button class="btn btn-lg btn-danger btn-block">Forgot Password</button></a>

<a href="register.php"><button class="btn btn-lg btn-warning btn-block">Register</button></a>

<?php
unset($_SESSION["errorList"]);
include("./includes/footer.php");
?>