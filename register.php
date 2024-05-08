<?php
$title = "User Registration";
include("./includes/header.php");


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["registration-email"]);
    $password = trim($_POST["registration-password"]);
    $confirmPassword = trim($_POST["registration-confirm"]);
    

    if(attemptRegistration($email, $password, $confirmPassword)){
        echo("SUCCESSS");
    }
    else{
    }

}
?>

<div class="error-box visible-border">
    <?php
    if (isset($_SESSION["errorList"])){
        echo('<ul>');
        foreach($_SESSION["errorList"] as $error){
            echo('<li>'.$error.'</li>');
        }
        echo('</ul>');
    }
    ?>
</div>


<form method="post">
    <h1 class="h3 mb-3 font-weight-normal">Registration Form</h1>
    <input type="text" name="registration-email" placeholder="Email">
    <input type="password" name="registration-password" placeholder="Password">
    <input type="password" name="registration-confirm" placeholder="Confirm Password">
    <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Register</button>
</form>

<a href="index.php"><button class="btn btn-lg btn-warning btn-block">Cancel</button></a>

<?php
unset($_SESSION["errorList"]);
include("./includes/footer.php");
?>
