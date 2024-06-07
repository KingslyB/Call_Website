<?php
require_once 'mail.php';

function db_connect(){
    $CONNECTION = pg_connect("host=".DB_HOST.
        " port=" .DB_PORT.
        " dbname=" .DB_NAME.
        " user=" .DB_ADMIN_LOGIN.
        " password=" .DB_ADMIN_PASSWORD);
    return $CONNECTION;
}

function attemptLogin($emailAddress, $password){ 
    if(loginAuthenticate($emailAddress, $password)){
        addSessionData(getSessionData($emailAddress));
        return true;
    }

    return false;
}

function validateNewPassword($oldPassword, $newPassword, $confirmPassword, $userSessionID){
    $_SESSION["errorList"] = array();

    if(strcmp($newPassword, $confirmPassword) != 0){
        array_push($_SESSION["errorList"], "Passwords do not match");
    }

    if(strlen($newPassword) < 6 || strlen($newPassword) > 70){
        array_push($_SESSION["errorList"], "New password length must be between 6 and 70 characters long");
    }

    if(count($_SESSION["errorList"]) == 0){
        if(!verifyPassword($oldPassword, $userSessionID)){
            array_push($_SESSION["errorList"], "An error occurred while trying to change the password");
        }
    }

    if(count($_SESSION["errorList"]) == 0){
        changePassword($newPassword, $userSessionID);
        return true;
    }

    return false;
}

/**
 * Sets data from an associative array into the current session
 */
function addSessionData($data){
    #return false if $data is not an array
    if(!is_array($data)){
        return false;
    }

    #return false if any of the keys are not a string
    foreach ($data as $key => $value) {
        if(!is_string($key)){
            return false;
        }
    }

    foreach ($data as $key => $value) {
        $_SESSION[$key] = $value;
    }
    return true;
}

function endSession(){
    session_unset();
    session_destroy();
    session_reset();
}

function validateNewEmail($newEmailAddress, $confirmEmail, $userID) :bool
{
    $_SESSION["errorList"] = array();
    if(strlen($newEmailAddress) < 6 || strlen($newEmailAddress) > 100){
        array_push($_SESSION["errorList"], "New Email length must be between 6 and 100 characters long");
    }

    if(strcmp($newEmailAddress, $confirmEmail) != 0){
        array_push($_SESSION["errorList"], "Confirmation Email must match New Email");
    }

    if(count($_SESSION["errorList"]) == 0){
        changeEmailAddress($newEmailAddress, $userID);
        return true;
    }
    return false;
}

function attemptRegistration($email, $password, $confirmPassword, $firstName, $lastName): bool{
    $_SESSION["errorList"] = array();

    if(strlen($email) < 6 || strlen($email) > 100){
        array_push($_SESSION["errorList"], "Email length must be between 6 and 100 characters long");
    }

    if(strlen($password) < 6 || strlen($password) > 70){
        array_push($_SESSION["errorList"], "Password length must be between 6 and 70 characters long");
    }

    if(strcmp($password, $confirmPassword) != 0){
        array_push($_SESSION["errorList"], "The confirmation password does not match");
    }

    if(strlen($firstName) < 2 || strlen($firstName) > 100){
        array_push($_SESSION["errorList"], "First Name must be at least 2 characters long and at most 100
         characters long");
    }

    if(strlen($lastName) < 2 || strlen($lastName) > 100){
        array_push($_SESSION["errorList"], "Last Name must be at least 2 characters long and at most 100
         characters long");
    }
    

    if (count($_SESSION["errorList"]) == 0){
        registerNewUser($email, $password, $firstName, $lastName);
        return true;
    }

    return false;
}

function displayTable($queryResults){

    $keys = array_keys($queryResults[0]);
    echo("<table>");
    echo("<tr>");
    foreach($keys as $columnHead){
        echo("<th>".$columnHead."</th>");
    }
    echo("</tr>");


    foreach($queryResults as $record){
        echo("<tr>");
        foreach($record as $columnValue){
            displayTableData(current($keys), $columnValue);
            next($keys);
        }
        echo("</tr>");
        reset($keys);
    }
    echo("</table>");
}

function displayTableData($columnHead, $columnValue){

    switch ($columnHead) {
        case PHONENUM:
            echo("<td>".$columnValue."Text</td>");
            break;
        
        default:
            echo("<td>".$columnValue."</td>");
            break;
    }
}

function preparePasswordReset($emailAddress){
    $newWindowExists = newResetWindow($emailAddress);

    if($newWindowExists){
        $details = findLatestResetAttempt($emailAddress);
        $resetUrl = SITE_URL.'/reset-password.php?email='.$details['emailaddress'].'&id='.$details['attemptid'];

        sendPasswordResetMail($details['emailaddress'], $resetUrl );
        return true;
    }
    return false;
}

function validatePasswordResetPage($attemptId, $emailAddress){
    $details = findResetAttempt($attemptId, $emailAddress);

    if(!$details || count($details) == 0 ){
        return false;
    }

    if(strtotime($details['startdate']) > strtotime(date('d-m-Y H:i:s')) ||
        strtotime($details['enddate']) < strtotime(date('d-m-Y H:i:s'))){
        return false;
    }
    return $details;
}

function validatePasswordReset($newPassword, $confirmPassword, $resetAttemptInfo){
    $_SESSION["errorList"] = array();

    if(strlen($newPassword) < 6 || strlen($newPassword) > 70){
        array_push($_SESSION["errorList"], "Password length must be between 6 and 70 characters long");
    }

    if(strcmp($newPassword, $confirmPassword) != 0){
        array_push($_SESSION["errorList"], "The confirmation password does not match");
    }

    if(!is_array($resetAttemptInfo) || count($resetAttemptInfo) == 0){
        array_push($_SESSION["errorList"], "An unknown error has occurred [01]");
    }

    if(count($_SESSION["errorList"]) != 0){
        return false;
    }


    if(!changePasswordUsingReset($newPassword, $resetAttemptInfo)){
        array_push($_SESSION["errorList"], "An unknown error has occurred [02]");
        return false;
    };
    return false;
}
?>


