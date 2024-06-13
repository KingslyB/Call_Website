<?php
$title = "Password Reset";
include("./includes/header.php");

$foundUser = validatePasswordResetPage($_REQUEST['id'], $_REQUEST['email']);
if (!$foundUser){
    echo "<script>alert('Invalid');</script>";
    header("Location: index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPassword = trim($_POST["newPassword"]);
    $confirmPassword = trim($_POST["confirmPassword"]);
    if(validatePasswordReset($newPassword, $confirmPassword, $foundUser)){
        header("Location: index.php");
    }
}
?>

<?php displayErrorList(); ?>


<h1 class="h3 mb-3 font-weight-normal"> Password Reset</h1>
    <form method="POST" action="reset-password.php?id=<?php echo $_REQUEST['id'];?>&email=<?php echo $_REQUEST['email'];?>">
        <label for="new-password">Enter your new password</label>
        <input type="password" id="new-password" name="newPassword" placeholder="New Password">
        <label for="confirm-password">Re-Enter your new password</label>
        <input type="password" id="confirm-password" name="confirmPassword" placeholder="Confirm Password">
        <input class="btn btn-lg btn-primary btn-block mt-2" type="submit" value="Submit">
    </form>


<a href="index.php"><button class="btn btn-lg btn-warning btn-block">Cancel</button></a>

<?php
unset($_SESSION["errorList"]);
include("./includes/footer.php");
?>
