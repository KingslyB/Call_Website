<?php
/**
     * Author: Kingsly Bude
     * Description: Sign-out.
     */
$title = "Sign-Out Page";
include "./includes/header.php";

if(isset($_SESSION['user_id'])){
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