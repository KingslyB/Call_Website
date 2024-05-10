<?php
$title = "Email Change";
include("./includes/header.php");


if(!isset($_SESSION["id"])){
    header("Location: sign-in.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["new-email"]);
    $confirmEmail = trim($_POST["confirmation-email"]);

    if(validateNewEmail($email, $confirmEmail, $_SESSION["id"])){
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
    <h1 class="h3 mb-3 font-weight-normal">New Email Address</h1>
    Current Email: <input type="text" name="current-email" value="<?php echo($_SESSION["emailaddress"])?>" disabled>
    New Email: <input type="email" name="new-email" placeholder="New Email Address">
    Confirmation Email: <input type="email" name="confirmation-email" placeholder="New Email Address">
    <button class="btn btn-lg btn-primary btn-block mt-2" type="submit">Apply</button>
</form>

<a href="index.php"><button class="btn btn-lg btn-warning btn-block">Cancel</button></a>

<?php
include("./includes/footer.php");
?>
