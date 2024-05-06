<?php
    /**
     * Author: Kingsly Bude
     * Description: Change password page. Only accessible by people signed in.
     */
    $title = "Change Password";
    include "./includes/header.php";

    if(!isset($_SESSION['user_id'])){
        header("Location: sign-in.php");
    }

    $input_email = "";
    $input_password = "";
    $input_first_name = "";
    $input_last_name = ""; 
    $error_list = array();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $error_list = validate_new_password($_POST);
        
        $input_old_password = trim($_POST['textbox_old_password']);
        $input_new_password = trim($_POST['textbox_new_password']);
        $input_confirm_password = trim($_POST['textbox_confirm_password']);
        
        if(count($error_list) == 0){
            change_password($_SESSION['user_id'], $input_new_password);

            $_SESSION['redirect_flash'] = "Succesfully changed password!";
            header("Location: dashboard.php");
        }
    }
?>

<form class="form-standard" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Password Change</h1>
    <?php display_form($form_change_password); ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Change Password</button>
</form>
   
<?php
    if(count($error_list) != 0){
        display_error($error_list);
    }
    include "./includes/footer.php";
?>    