<?php
/**
     * Author: Kingsly Bude
     * Description: Sign-in Page.
     */
$title = "Sign-In Page";
include "./includes/header.php";

$user_email = "";
$user_plain_password = "";
$_SESSION['error'] = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user_email = trim($_POST["textbox_user_email"]);
    $user_plain_password = trim($_POST["textbox_user_password"]);

    if($user_email == ""){
        $_SESSION['error'] .= "- The email field must be set\n";
    }
    if($user_plain_password == ""){
        $_SESSION['error'] .= "- The email field must be set\n";
    }
    
    if($_SESSION['error'] == ""){
        if(user_authenticate($user_email, $user_plain_password)){
            $results = user_select($user_email);
            $rows = pg_fetch_assoc($results);          
            $_SESSION['user_id'] = $rows['id'];
            $_SESSION['user_email'] = $rows['emailaddress'];
            $_SESSION['user_firstname'] = $rows['firstname'];
            $_SESSION['user_lastname'] = $rows['lastname'];
            $_SESSION['user_enrolldate'] = $rows['enrolldate'];
            $_SESSION['user_lastaccess'] = $rows['lastaccess'];
            $_SESSION['user_phoneext'] = $rows['phoneext'];
            $_SESSION['user_type'] = $rows['type'];
            $_SESSION['login_banner'] = true;
            
            #Redirect to dashboard
            header("Location: dashboard.php");
        }
        else{
            $_SESSION['error'] .= "- Invalid email address or password\n";
        }
    }
    
}
?>
   
<form class="form-standard" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="textbox_user_email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="textbox_user_password" id="inputPassword" class="form-control" placeholder="Password" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    
    <!--Error message for empty textboxes won't be displayed because of "required" attributes on input textboxes-->
    <?php
        if($_SESSION['error'] != ""){
            echo('<p class="error-box visible-border">'.$_SESSION['error'].'</p>');
        }
    ?>
        
</form>

<?php
include "./includes/footer.php";
?>    