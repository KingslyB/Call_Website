<?php
$title = "Password Reset";
include("./includes/header.php");

$details = findResetAttempt($_REQUEST['id'], $_REQUEST['email']);

//TODO: Use try?
if (!validatePasswordResetPage($_REQUEST)) {
    echo "<script>alert('Invalid Email');</script>";
    header("Location: index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //validatePasswordReset();
}





//if($_SERVER["REQUEST_METHOD"] == "POST"){
//    $emailAddress = trim($_POST["email-address"]);
//    $foundUser = findUserID($emailAddress);
//
//    if($foundUser){
//        if(preparePasswordReset($emailAddress)){
//            header("Location: index.php");
//        }
//    }
//}
//
//if (isset($_SESSION["errorList"])){
//    echo('<div class="error-box visible-border"> <ul>');
//    foreach($_SESSION["errorList"] as $error){
//        echo('<li>'.$error.'</li>');
//    }
//    echo('</ul></div>');
//    unset($_SESSION["errorList"]);
//}
?>

<p>nothing here yet</p>
<?php
print_r($details)
?>
<!---->
<!--<form method="post">-->
<!--    <h1 class="h3 mb-3 font-weight-normal">Password Reset</h1>-->
<!--    <p>Enter the Email Address you would like to reset the password for</p>-->
<!--    Email Address: <input type="email" name="email-address" placeholder="Email Address">-->
<!--    <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Send Request</button>-->
<!--</form>-->

<a href="index.php"><button class="btn btn-lg btn-warning btn-block">Cancel</button></a>

<?php
include("./includes/footer.php");
?>
