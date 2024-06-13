<?php
$title = "User Registration";
include("./includes/header.php");


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["registration-email"]);
    $password = trim($_POST["registration-password"]);
    $confirmPassword = trim($_POST["registration-confirm"]);
    $firstName = trim($_POST["registration-first-name"]);
    $lastName = trim($_POST["registration-last-name"]);

    if(attemptRegistration($email, $password, $confirmPassword, $firstName, $lastName)){
        header("Location: index.php");
    }

}
?>

<?php displayErrorList(); ?>

<form method="post">
    <h1 class="h3 mb-3 font-weight-normal">Registration Form</h1>
    <input type="text" name="registration-email" placeholder="Email">
    <input type="password" name="registration-password" placeholder="Password">
    <input type="password" name="registration-confirm" placeholder="Confirm Password">
    <input type="text" name="registration-first-name" placeholder="First Name">
    <input type="text" name="registration-last-name" placeholder="Last Name">
    <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Register</button>
</form>

<a href="index.php"><button class="btn btn-lg btn-warning btn-block">Cancel</button></a>

<?php
unset($_SESSION["errorList"]);
include("./includes/footer.php");
?>
