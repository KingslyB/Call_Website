<?php
    /**
     * Author: Kingsly Bude
     * Description: List of salespeople page. Only accessible by admins.
     */
    $title = "Sales People";
    include "./includes/header.php";

    if(!isset($_SESSION['user_id'])){
        header("Location: sign-in.php");
    }
    if ($_SESSION['user_type'] != Administrator){
        header("Location: index.php");
        $_SESSION['login_banner'] = false;
    }

    $table_page = 0;
    $input_email = "";
    $input_password = "";
    $input_first_name = "";
    $input_last_name = ""; 
    $error_list = array();

    $all_salespeople = find_all_salespeople_minimal();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $error_list = validate_salesperson($_POST);
        
        $input_email = trim($_POST['textbox_user_email']);
        $input_password = trim($_POST['textbox_user_password']);
        $input_first_name = trim($_POST['textbox_user_first_name']);
        $input_last_name = trim($_POST['textbox_user_last_name']);
        $form_salesperson['first_name']['value'] = $input_first_name;
        $form_salesperson['last_name']['value'] = $input_last_name;
        $form_salesperson['email']['value'] = $input_email;
        $form_salesperson['password']['value'] = $input_password;
        
        if(count($error_list) == 0){
            $registration_info = array($input_email, $input_password, $input_first_name, $input_last_name);
            create_salesperson($registration_info);

            $_SESSION['redirect_flash'] = "Succesfully created new salesperson!";
            header("Location: dashboard.php");
        }
    }

?>

<form class="form-standard" method="post">
    <h1 class="h3 mb-3 font-weight-normal">Register a new salesperson</h1>
    <?php display_form($form_salesperson); ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
</form>

<table>
    <tr>
        <th colspan=9>
            <h3>Salespeople Information</h3>
            <?php
                if($table_page != 0){
                    echo('<a href="salespeople.php?table_page='.strval($table_page - 1).'">
                        Previous Page
                        </a>');
                }

                if(($table_page + 1)* RECORDS_PER_PAGE < count($all_salespeople)){
                    echo('<a href="salespeople.php?table_page='.strval($table_page + 1).'">
                        Next Page
                        </a>');
                }
            ?>
        </th>
    </tr>
    <tr>
        <th>ID</th>
        <th>Email Address</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Is Active?</th>
    </tr>
    <?php
        display_table($all_salespeople, $table_page);
    ?>
</table>
   
<?php
    if(count($error_list) != 0){
        display_error($error_list);
    }
    include "./includes/footer.php";
?>    