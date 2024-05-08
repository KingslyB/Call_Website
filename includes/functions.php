<?php
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

function attemptRegistration($email, $password, $confirmPassword): bool{
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
    

    if (count($_SESSION["errorList"]) == 0){
        registerNewUser($email, $password);
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
?>


