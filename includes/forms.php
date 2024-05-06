<?php
    $form_salesperson = array(
        'first_name' => array(
            "type" => "text",
            "name" => "textbox_user_first_name",
            "value" => "",
            "label" => "inputFirstName",
            "placeholder" => "First Name",
            "class" => "form-control"
        ),
        'last_name' => array(
            "type" => "text",
            "name" => "textbox_user_last_name",
            "value" => "",
            "label" => "inputLastName",
            "placeholder" => "Last Name",
            "class" => "form-control"
        ),
        'email' => array(
            "type" => "text",
            "name" => "textbox_user_email",
            "value" => "",
            "label" => "inputEmail",
            "placeholder" => "Email Address",
            "class" => "form-control"
        ),
        'password' => array(
            "type" => "password",
            "name" => "textbox_user_password",
            "value" => "",
            "label" => "inputPassword",
            "placeholder" => "Password",
            "class" => "form-control"
        )
    );

    $form_client = array(
        'first_name' => array(
            "type" => "text",
            "name" => "textbox_client_first_name",
            "value" => "",
            "label" => "inputFirstName",
            "placeholder" => "First Name",
            "class" => "form-control"
        ),
        'last_name' => array(
            "type" => "text",
            "name" => "textbox_client_last_name",
            "value" => "",
            "label" => "inputLastName",
            "placeholder" => "Last Name",
            "class" => "form-control"
        ),
        'email' => array(
            "type" => "text",
            "name" => "textbox_client_email",
            "value" => "",
            "label" => "inputEmail",
            "placeholder" => "Email Address",
            "class" => "form-control"
        ),
        'phone' => array(
            "type" => "text",
            "name" => "textbox_client_phone",
            "value" => "",
            "label" => "inputPhone",
            "placeholder" => "Phone Number",
            "class" => "form-control"
        ),
        'logo' => array(
            "type" => "file",
            "name" => "file_logo",
            "value" => "",
            "label" => "file_upload_logo",
            "placeholder" => "",
            "class" => ""
        )
    );

    $form_change_password = array(
        'first_name' => array(
            "type" => "password",
            "name" => "textbox_old_password",
            "value" => "",
            "label" => "inputOldPassword",
            "placeholder" => "Old Password",
            "class" => "form-control"
        ),
        'last_name' => array(
            "type" => "password",
            "name" => "textbox_new_password",
            "value" => "",
            "label" => "inputNewPassword",
            "placeholder" => "New Password",
            "class" => "form-control"
        ),
        'email' => array(
            "type" => "password",
            "name" => "textbox_confirm_password",
            "value" => "",
            "label" => "inputConfirmPassword",
            "placeholder" => "Retype New Password",
            "class" => "form-control"
        )
    );

    $form_reset = array(
        'first_name' => array(
            "type" => "email",
            "name" => "textbox_email",
            "value" => "",
            "label" => "inputEmail",
            "placeholder" => "Email Address",
            "class" => "form-control"
        )
    );

    $form_generic_boolean = array(
        'true' => array(
            "type" => "radio",
            "name" => "NEEDS TO BE SET",
            "value" => "true",
            "label" => "inputTrue",
            "placeholder" => "",
            "class" => ""
        ),
        'false' => array(
            "type" => "radio",
            "name" => "NEEDS TO BE SET",
            "value" => "false",
            "label" => "inputFalse",
            "placeholder" => "",
            "class" => ""
        )
    );
?>