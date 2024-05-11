<?php
$title = "Password Reset";
include("./includes/header.php");


if(isset($_SESSION["id"])){
    header("Location: dashboard.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $emailAddress = trim($_POST["email-address"]);
    $foundUser = findUserID($emailAddress);

    if($foundUser){
        if(preparePasswordReset($foundUser['id'], $emailAddress)){
            header("Location: index.php");
        }
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
    <h1 class="h3 mb-3 font-weight-normal">Password Reset</h1>
    <p>Enter the Email Address you would like to reset the password for</p>
    Email Address: <input type="email" name="email-address" placeholder="Email Address">
    <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Send Request</button>
</form>

<a href="index.php"><button class="btn btn-lg btn-warning btn-block">Cancel</button></a>

<?php
include("./includes/footer.php");
?>
