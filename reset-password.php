<?php
$title = "Password Reset";
include("./includes/header.php");


if(!isset($_SESSION["id"])){
    header("Location: sign-in.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $oldPassword = trim($_POST["oldPassword"]);
    $newPassword = trim($_POST["new-password"]);
    $confirmPassword = trim($_POST["confirmation-password"]);

    if(validateNewPassword($oldPassword, $newPassword, $confirmPassword, $_SESSION["id"])){
        header("Location: sign-out.php");
    }
}

if (isset($_SESSION["errorList"])){
    echo('<div class="error-box visible-border"> <ul>');
    foreach($_SESSION["errorList"] as $error){
        echo('<li>'.$error.'</li>');
    }
    echo('</ul></div>');
    unset($_SESSION["errorList"]);
}
?>



<form method="post">
    <h1 class="h3 mb-3 font-weight-normal">Password Change</h1>
    Old Password: <input type="password" name="old-password" placeholder="Old Password">" disabled>
    New Password: <input type="password" name="new-password" placeholder="New Password">
    Confirmation Password: <input type="password" name="confirm-password" placeholder="New Password">
    <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Apply</button>
</form>

<a href="index.php"><button class="btn btn-lg btn-warning btn-block">Cancel</button></a>

<?php
include("./includes/footer.php");
?>
