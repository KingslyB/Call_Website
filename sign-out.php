<?php
$title = "Sign-Out";
include "./includes/header.php";

if(isset($_SESSION['id'])){
    logout();
} else{
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