<?php
    /**
     * Author: Kingsly Bude
     * Description: Reset page. Only accessible by people signed in.
     */
    $title = "Reset Account";
    include "./includes/header.php";

    if(!isset($_SESSION['user_id'])){
        header("Location: sign-in.php");
    }

    $input_email = "";
    $error_list = array();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $error_list = validate_reset($_POST);
        $input_email = trim($_POST['textbox_email']);
        
        print_r(reset_email($input_email));

        if(count($error_list) == 0){

            $_SESSION['redirect_flash'] = "A reset email has been sent to the specified email.";
            header("Location: dashboard.php");
        }
    }
?>

<form class="form-standard" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Account Reset</h1>
    <?php display_form($form_reset); ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
</form>
   
<?php
    if(count($error_list) != 0){
        display_error($error_list);
    }
    include "./includes/footer.php";
?>    