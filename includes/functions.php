<?php
    include_once("constants.php");
    include_once("forms.php");
    function endSession(){
        session_unset();
        session_destroy();
        session_reset();
        $_SESSION['signed_out'] = true;
    }

    function display_form($array_form){
        foreach($array_form as $array_inputs){
            echo('<input type="'.$array_inputs['type'].'" name="'.$array_inputs['name'].'" value="'.$array_inputs['value'].'" id="'.$array_inputs['label'].'" placeholder="'.$array_inputs['placeholder'].'" class="'.$array_inputs['class'].'">');   
        }
    }

    function is_image_path($path){
        if(strpos($path, TYPE_PNG) > 0 || strpos($path, TYPE_JPEG) > 0 ){
            return true;
        }
    }
    
    function is_boolean_data($field){
        if($field[0] == "i" && $field[1] == "s" ){
            return true;
        }
    }

    #PROBLEM: This table tries to do every possible table regardless of what data that table will handle
    #   The result is a lot of elseifs and a general lack of readability and flexibility in the long term
    function display_table($table_data, $page_number){
        #table_data is an indexed array of associative arrays

        for($current_record = $page_number * RECORDS_PER_PAGE; $current_record < RECORDS_PER_PAGE * ($page_number + 1); $current_record++){
            if(isset($table_data[$current_record])){
                $found_keys = array_keys($table_data[$current_record]);
                echo('<tr>');

                #Create the table cell for the current value and output either an img tag or a string
                for($current_key = 0; $current_key < count($table_data[$current_record]); $current_key++){
                    echo('<td>');
                    if(is_image_path($table_data[$current_record][$found_keys[$current_key]])){
                        echo('<img class="td-image" src="'.$table_data[$current_record][$found_keys[$current_key]].'">');
                    }
                    elseif(is_boolean_data($found_keys  [$current_key])){
                        #At this point the table is made for the salespeople information table
                        #I really should have made a more modular function for tables.
                        echo('<form class="form-standard" method="POST" action="salesupdate.php/'.$table_data[$current_record]['id'].'">');

                        if($table_data[$current_record][$found_keys[$current_key]] == 't'){
                            echo('<b>True</b> <input type="radio" name="inputIsActive" value="true" checked>');
                            echo('False <input type="radio" name="inputIsActive" value="false">');
                        }
                        elseif($table_data[$current_record][$found_keys[$current_key]] == 'f'){
                            echo('True <input type="radio" name="inputIsActive" value="true">');
                            echo('<b>False</b> <input type="radio" name="inputIsActive" value="false" checked>');
                        }
                        echo('
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
                        </form>
                        ');
                    }
                    else{                            
                        echo($table_data[$current_record][$found_keys[$current_key]]);
                    }
                    echo('</td>');
                }
                echo('</tr>');
            }
        }
    }
    
    function display_error($error_list){
        echo('<div class="error-box visible-border" style="display: block;">');
        echo('<h4>Errors have occured</h4>');
        echo('<ul>');
        foreach($error_list as $error){
            echo('<li>' . $error . '</li>')  ;          
        }
        echo('</ul>');
        echo('</div>');
    }

    function display_redirect_message(){
        if(isset($_SESSION['redirect_flash'])){
            echo($_SESSION['redirect_flash']);
            unset($_SESSION['redirect_flash']);
        }
    }

    function prep_file_insert($file_to_prep){
        $tmp_location = $file_to_prep['tmp_name'];
        $name = basename($file_to_prep['name']);
        move_uploaded_file($tmp_location, UPLOADS_DIR . $name);
        return UPLOADS_DIR . $name;
    }

    function validate_salesperson(&$post_array){
        $input_first_name = trim($post_array['textbox_user_first_name']);
        $input_last_name = trim($post_array['textbox_user_last_name']);
        $input_email = trim($post_array['textbox_user_email']);
        $input_password = trim($post_array['textbox_user_password']);
        $email_check = user_select($input_email);
        $error_list  = array();

        if($input_first_name == "" || $input_last_name == "" || $input_email == "" || $input_password == ""){
			array_push($error_list, "All fields must be set.");
		}
        if(!filter_var($input_email , FILTER_VALIDATE_EMAIL)){
            array_push($error_list, "Email is not in the correct format.");
        }

        if(strlen($input_first_name) < MIN_FIRST_NAME_LENGTH || strlen($input_first_name) > MAX_FIRST_NAME_LENGTH){
            array_push($error_list, "Length of first name must be inbetween " . MIN_FIRST_NAME_LENGTH . " and " . MAX_FIRST_NAME_LENGTH . ".");
            $post_array['textbox_user_first_name'] = "";
        }

        if(strlen($input_last_name) < MIN_LAST_NAME_LENGTH || strlen($input_first_name) > MAX_LAST_NAME_LENGTH){
            array_push($error_list, "Length of last name must be inbetween " . MIN_LAST_NAME_LENGTH . " and " . MAX_LAST_NAME_LENGTH . ".");
            $post_array['textbox_user_last_name'] = "";
        }

        if(strlen($input_email) < MIN_EMAIL_LENGTH || strlen($input_email) > MAX_EMAIL_LENGTH){
            array_push($error_list, "Length of email must be inbetween " . MIN_EMAIL_LENGTH . " and " . MAX_EMAIL_LENGTH . ".");
            $post_array['textbox_user_email'] = "";
        }

        if(array_count_values(pg_fetch_assoc($email_check)) > 0){
            array_push($error_list, "Email is already in use.");
            $post_array['textbox_user_email'] = "";
        }

        if(strlen($input_password) < MIN_PASSWORD_LENGTH || strlen($input_password) > MAX_PASSWORD_LENGTH){
            array_push($error_list, "Length of password must be inbetween " . MIN_PASSWORD_LENGTH . " and " . MAX_PASSWORD_LENGTH . ".");
            $post_array['textbox_user_password'] = "";
        }

        return $error_list;
    }
    
    function validate_client(&$post_array, &$file_logo){
        $input_first_name = trim($post_array['textbox_client_first_name']);
        $input_last_name = trim($post_array['textbox_client_last_name']);
        $input_email = trim($post_array['textbox_client_email']);
        $input_phone = trim($post_array['textbox_client_phone']);
        $error_list  = array();

        


        if($file_logo['size'] > MAX_FILE_SIZE || $file_logo['error'] == 1 || $file_logo['error'] == 2){
            array_push($error_list, "Logo cannot be bigger than 2MB.");
            unset($file_logo);
        }
        elseif($file_logo['error'] > 2){
            array_push($error_list, "An error occured relating to the file uploaded.");
            unset($file_logo);
        }
        elseif($file_logo['type'] != "image/png" && $file_logo['type'] != "image/jpeg"){
            array_push($error_list, "Invalid file type");
            unset($file_logo);
        }


        if($input_first_name == "" || $input_last_name == "" || $input_email == "" || $input_phone == ""){
			array_push($error_list, "All text fields must be set.");
		}
        if(!filter_var($input_email , FILTER_VALIDATE_EMAIL)){
            array_push($error_list, "Email was not in the correct format.");
            $post_array['textbox_client_email'] = "";
        }

        if(strlen($input_first_name) < MIN_FIRST_NAME_LENGTH || strlen($input_first_name) > MAX_FIRST_NAME_LENGTH){
            array_push($error_list, "Length of first name must be inbetween " . MIN_FIRST_NAME_LENGTH . " and " . MAX_FIRST_NAME_LENGTH . ".");
            $post_array['textbox_client_first_name'] = "";
        }

        if(strlen($input_last_name) < MIN_LAST_NAME_LENGTH || strlen($input_first_name) > MAX_LAST_NAME_LENGTH){
            array_push($error_list, "Length of last name must be inbetween " . MIN_LAST_NAME_LENGTH . " and " . MAX_LAST_NAME_LENGTH . ".");
            $post_array['textbox_client_last_name'] = "";
        }

        if(strlen($input_email) < MIN_EMAIL_LENGTH || strlen($input_email) > MAX_EMAIL_LENGTH){
            array_push($error_list, "Length of email must be inbetween " . MIN_EMAIL_LENGTH . " and " . MAX_EMAIL_LENGTH . ".");
            $post_array['textbox_client_email'] = "";

        }

        if($input_phone < MIN_PHONE_LENGTH || $input_phone > MAX_PHONE_LENGTH){
            array_push($error_list, "Phone number must be 10 digits long.");
            $post_array['textbox_client_phone'] = "";
        }

        return $error_list;
    }

    function validate_new_password(&$post_array){
        $input_old_password = trim($post_array['textbox_old_password']);
        $input_new_password = trim($post_array['textbox_new_password']);
        $input_confirm_password = trim($post_array['textbox_confirm_password']);
        $error_list  = array();

        $user = user_select($_SESSION['user_email']);
        if (!password_verify($input_old_password, pg_fetch_result($user, 'password'))){
            array_push($error_list, "Incorrect old password.");
            $post_array['textbox_old_password'] = "";
        }

        if(strlen($input_new_password) < MIN_PASSWORD_LENGTH || strlen($input_new_password) > MAX_PASSWORD_LENGTH){
            array_push($error_list, "Length of new password must be inbetween " . MIN_PASSWORD_LENGTH . " and " . MAX_PASSWORD_LENGTH . ".");
            $post_array['textbox_new_password'] = "";
            $post_array['textbox_confirm_password'] = "";

        }

        if($input_confirm_password != $input_new_password){
            array_push($error_list, "New passwords did not match");
            $post_array['textbox_new_password'] = "";
            $post_array['textbox_confirm_password'] = "";
        }

        return $error_list;
    }

    
    function validate_reset(&$post_array){
        $input_email = trim($post_array['textbox_email']);
        $error_list  = array();
       
        if(!filter_var($input_email , FILTER_VALIDATE_EMAIL)){
            array_push($error_list, "Email is not in the correct format.");
            $post_array['textbox_email'] = "";
        }

        if(strlen($input_email) < MIN_EMAIL_LENGTH || strlen($input_email) > MAX_EMAIL_LENGTH){
            array_push($error_list, "Length of email must be inbetween " . MIN_EMAIL_LENGTH . " and " . MAX_EMAIL_LENGTH . ".");
            $post_array['textbox_email'] = "";
        }

        return $error_list;
    }

    function reset_email($email_address){

        $query_result = user_select($email_address);
        $found_email_address = pg_fetch_result($query_result, 'emailaddress');
        if($found_email_address != ""){
            
            $email = fopen('reset.txt', 'a');
            fwrite($email, "To: ".$found_email_address."\n
                Subject: Account Reset
                This email is being sent because you request an account reset at ".date("Y-m-d H:i:s")." UTC.
                If you did not make this request please disregard this email.\n\n");
            fclose($email);
        }
    }

?>
 