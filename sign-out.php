<?php
$title = "Sign-Out";
include "./includes/header.php";

if(isset($_SESSION['id'])){
    setcookie("a_cookie",
        "",
        ['expires' => time() - 1,
            "path" => "/",
            "domain" => "",
            "secure" => true,
            "httponly" => true]);
    endSession();
}
else{
    header("Location: sign-in.php");
}
?>

<div class="sign-out-box visible-border">
    <p>you have been logged out</p>
    <a href="index.php"><button>Return</button></a>
</div>


<?php
include "./includes/footer.php";

?>    