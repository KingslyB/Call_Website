<?php
    /**
     * Author: Kingsly Bude
     * Description: Registration for clients page. Only accessible by admins and sales people.
     */
    $title = "Clients";
    include "./includes/header.php";

    if(!isset($_SESSION['user_id'])){
        header("Location: sign-in.php");
    }
    $input_email = "";
    $input_first_name = "";
    $input_last_name = "";
    $input_phone = "";
    $salesperson_id = "";
    $error_list = array();
    $table_page = 0;
    $all_salespeople = find_all_salespeople();
    
    if($_SESSION['user_type'] == 'a'){
        $all_clients = find_all_clients();
    }
    else{
        $all_clients = find_salesperson_clients($_SESSION['user_id']);
    }
    
    if(isset($_GET["table_page"])){
        $table_page = $_GET["table_page"];
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['textbox_client_phone'])){
        $error_list = validate_client($_POST, $_FILES['file_logo']);
        
        #Variable assignments for sticky textboxes and used for sql queries later
        $input_email = trim($_POST['textbox_client_email']);
        $input_first_name = trim($_POST['textbox_client_first_name']);
        $input_last_name = trim($_POST['textbox_client_last_name']);
        $input_phone = trim($_POST['textbox_client_phone']);
        $form_client['first_name']['value'] = $input_first_name;
        $form_client['last_name']['value'] = $input_last_name;
        $form_client['email']['value'] = $input_email;
        $form_client['phone']['value'] = $input_phone;
        if($_SESSION['user_type'] == Administrator){
            $salesperson_id = ($_POST['option_salesperson']);
        }
        else{
            $salesperson_id = $_SESSION['user_id'];
        }
        

        if(count($error_list) == 0){
            $file_path = prep_file_insert($_FILES['file_logo']);
            $registration_info = array($input_email, $input_first_name, $input_last_name, $input_phone, $salesperson_id, $file_path);
            create_client($registration_info);

            $_SESSION['redirect_flash'] = "Succesfully created new client!";
            header("Location: dashboard.php");      
        }
    }
?>

<form class="form-standard" method="post" enctype="multipart/form-data">
    <h1 class="h3 mb-3 font-weight-normal">Register a new client</h1>
    <?php
        display_form($form_client);
        if ($_SESSION['user_type'] == Administrator){
            echo('<select name="option_salesperson" id="input_salesperson">');
            foreach($all_salespeople as $record => $data){
                echo('<option value="'.$data[id].'">' .$data['firstname']. ' ' . $data['lastname'] .'</option>');          
            }    
            echo('</select>');
        }
    ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
</form>
<?php
    if(count($error_list) != 0){
        display_error($error_list);
    }
?>

<table>
    <tr>
        <th colspan=9>
            <h3>Client Information</h3>
            <?php
                if($table_page != 0){
                    echo('<a href="client.php?table_page='.strval($table_page - 1).'">
                        Previous Page
                        </a>');
                }

                if(($table_page + 1)* RECORDS_PER_PAGE < count($all_clients)){
                    echo('<a href="client.php?table_page='.strval($table_page + 1).'">
                        Next Page
                        </a>');
                }
            ?>
        </th>
    </tr>
    <tr>
        <th>Client Email</th>
        <th>Client First Name</th>
        <th>Client Last Name</th>
        <th>Client Phone Number</th>
        <th>Client Phone Extension</th>
        <th>Assigned Salesperson ID</th>
        <th>Logo</th>
    </tr>
    <?php
        display_table($all_clients, $table_page);
    ?>
</table>

<?php
    include "./includes/footer.php";
?>