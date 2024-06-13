<?php
require_once 'mail.php';

/**
 * @return false|resource
 * Database connection
 */
function db_connect(){
    return pg_connect("host=".DB_HOST.
        " port=" .DB_PORT.
        " dbname=" .DB_NAME.
        " user=" .DB_ADMIN_LOGIN.
        " password=" .DB_ADMIN_PASSWORD);
}

/**
 * @param string $emailAddress Client's email address
 * @param string $password Client's plaintext password
 * @return bool boolean depends on if the DB query was successful.
 * @throws \Random\RandomException
 * Find a user depending on the given credentials.
 * If a user is found, the session is reset with account details and an auth "token" is saved to the DB.
 */
function attemptLogin(string $emailAddress, string $password) : bool{
    $_SESSION["errorList"] = array();

    if(!loginAuthenticate($emailAddress, $password)){
        array_push($_SESSION["errorList"], "Invalid email or password");
        return false;
    }
    clearSession();
    addSessionData(getSessionData($emailAddress));
    generateAuthSessionCookie(true);
    return true;
}

/**
 * @return void
 * Immediately clears the client's auth cookie and session data
 */
function logout(){
    setcookie("a_cookie",
        "",
        ['expires' => time() - 1,
            "path" => "/",
            "domain" => "",
            "secure" => true,
            "httponly" => true]);

    clearSession();
}

/**
 * @param bool $rememberMe
 * @return void
 * @throws \Random\RandomException
 * Generates an auth cookie that is stored in the DB
 */
//TODO: Implement "remember me" checkbox on sign-in.php page
function generateAuthSessionCookie(bool $rememberMe){
    $token = bin2hex(random_bytes(16));

    setcookie("a_cookie",
        ($token),
        ['expires' => time() + 60 * 60 * 24 * 7,
            "path" => "/",
            "domain" => "",
            "secure" => true,
            "httponly" => true]);

    storeToken($token, $_SESSION['id']);
}

/**
 * @return bool Returns true if a valid auth token was found in the DB and user data related to that token was updated in the session storage.
 */
function UpdateAuth() : bool{
    if(isset($_COOKIE["a_cookie"])){
        $updatedInfo = AuthCheck($_COOKIE["a_cookie"]);

        if(count($updatedInfo) > 0){
            addSessionData($updatedInfo);
            return true;
        }
    }
    return false;
}

/**
 * @param $oldPassword User's old plaintext password
 * @param $newPassword User's new plaintext password
 * @param $confirmPassword User's new plaintext password again
 * @param $userSessionID User's ID that is retrieved from the session storage.
 * @return bool Returns true if ALL validation was successful AND the password was successfully changed in the DB
 * Validate the arguments against password requirements.
 * If they are ALL valid then the user specified by the logged-in user's session id has its password updated.
 */
function validateNewPassword(string $oldPassword, string $newPassword, string $confirmPassword, int $userSessionID) : bool{
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
 * @param array $data Incoming session data.
 * @return bool Returns false if $data is not an array or if any of the keys do not contain a string.
 * Sets data from an  array into the current session
 */
function addSessionData(array $data) : bool{
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

/**
 * @return void
 * Clears the current session and starts a new one immediately
 */
function clearSession(){
    session_unset();
    session_destroy();
    session_reset();

    session_start();
    ob_start();
}

/**
 * @param string $newEmailAddress User's new email address again.
 * @param string $confirmEmail User's new email address again.
 * @param int $userID ID from the logged-in session.
 * @return bool Returns true if ALL validation was successful AND the email address was successfully changed in the DB.
 * Validate the arguments against email requirements.
 * If they are ALL valid then the user specified by the logged-in user's session id has its email address updated.
 */
function validateNewEmail(string $newEmailAddress, string $confirmEmail, int $userID): bool
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

/**
 * @param string $email New user's email address.
 * @param string $password New user's plaintext password.
 * @param string $confirmPassword New user's plaintext password again.
 * @param string $firstName New user's first name.
 * @param string $lastName New user's last name.
 * @return bool Returns true if ALL validation was successful AND the new user was successfully added to the DB.
 * Validate the arguments for creating a new user.
 * If they are ALL valid then a new user will be created based on the information from the form.
 */
function attemptRegistration(string $email, string $password, string $confirmPassword, string $firstName, string $lastName): bool{
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
    $newResetExists = newResetAttempt($emailAddress);

    if($newResetExists){
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
    return true;
}

function displayErrorList(){
    if (isset($_SESSION["errorList"])){

        echo('<div class="error-box visible-border"> <ul>');
        foreach($_SESSION["errorList"] as $error){
            echo('<li>'.$error.'</li>');
        }
        echo('</ul></div>');
    }
}
?>


