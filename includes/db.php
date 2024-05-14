<?php

    pg_prepare(db_connect(), "add_new_user", 
        'INSERT INTO users(emailaddress, password, firstname, lastname, enrolldate, lastaccess, phoneext, type, isactive)
        VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9)'
    );

    pg_prepare(db_connect(), "find_id_by_email",
    'SELECT id 
        FROM users 
        WHERE emailaddress=$1'
    );

    pg_prepare(db_connect(), "update_user_email",
    'UPDATE users 
        SET emailaddress = $1
        WHERE id = $2'
    );

    pg_prepare(db_connect(), "find_password_by_email",
        'SELECT password
        FROM users
        WHERE emailaddress=$1'
    );

    pg_prepare(db_connect(), "find_password_by_id",
        'SELECT password
            FROM users
            WHERE id=$1'
    );

    pg_prepare(db_connect(), "get_session_data",
        'SELECT id, emailaddress, firstname, lastname, enrolldate, lastaccess, phoneext, type, isactive
        FROM users
        WHERE emailaddress=$1'
    );

    pg_prepare(db_connect(), "all_client_data",
    'SELECT * 
    FROM clients'
    );

    pg_prepare(db_connect(), "change_password",
    'UPDATE users
    SET password = $1
    WHERE id = $2'
    );

    //TODO: Change emailaddress to id
    pg_prepare(db_connect(), "new_reset_attempt",
    'INSERT INTO passwordresets(startdate, enddate, used, emailaddress) 
        VALUES ($1, $2, $3, $4)'
    );

    //TODO: Change emailaddress to id and do a JOIN to get emailaddress, firstname, lastname
    pg_prepare(db_connect(), "find_reset_attempt" ,
    'SELECT *
    FROM passwordresets
    WHERE emailaddress=$1'
    );

    

    function newResetWindow($emailAddress){
        $result = (pg_execute(db_connect(),
            "new_reset_attempt",
            [
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
                "false",
                $emailAddress
            ]));
        return $result;
    }

    function findResetAttempt($emailAddress){
        return pg_fetch_assoc(pg_execute(db_connect(), "find_reset_attempt", [$emailAddress]));
    }

    function findUserID($emailAddress){
        return pg_fetch_assoc(pg_execute(db_connect(), "find_id_by_email", [$emailAddress]));

    }

    function changeEmailAddress($newEmailAddress, $userID){
        return pg_execute(db_connect(), "update_user_email", [$newEmailAddress, $userID]);
    }

    function loginAuthenticate($email, $plaintextPassword){
        $results = pg_execute(db_connect(), "find_password_by_email", [$email]);
        $results = pg_fetch_assoc($results);
        
        return password_verify($plaintextPassword, $results['password']);
    }

    function verifyPassword($plaintextPassword, $userID){
        $results = pg_fetch_assoc(pg_execute(db_connect(), "find_password_by_id", [$userID]));
        return password_verify($plaintextPassword, $results['password']);
    }

    function changePassword($newPassword, $userID){
        return pg_execute(db_connect(), "change_password", [password_hash($newPassword, PASSWORD_BCRYPT), $userID]);
    }

    function registerNewUser($email, $plaintextPassword, $firstname, $lastname): bool
    {
        $results = pg_execute(db_connect(), "add_new_user",
            [
                $email,
                password_hash($plaintextPassword, PASSWORD_BCRYPT),
                $firstname,
                $lastname,
                date("Y-m-d H:i:s"),
                date("Y-m-d H:i:s"),
                0,
                's',
                true
            ]);
        return true;


    }

    function getSessionData($email){
        return pg_fetch_assoc(pg_execute(db_connect(), "get_session_data", [$email]));
        
    }

    function allClientData(){
        $results = pg_execute(db_connect(), "all_client_data", []);
        $results = pg_fetch_all($results, PGSQL_ASSOC);
        return $results;
    }
?>

