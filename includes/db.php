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
    'INSERT INTO passwordresets(startdate, enddate, used, emailaddress, userid)
    VALUES (CURRENT_TIMESTAMP(0),
            CURRENT_TIMESTAMP(0) + \'900\',
            $1,
            $2, 
	        (SELECT users.id 
		    FROM users 
		    WHERE users.emailaddress = $3))'
    );

    //TODO: Change emailaddress to id and do a JOIN to get emailaddress, firstname, lastname
    pg_prepare(db_connect(), "find_reset_attempt" ,
        'SELECT *
        FROM passwordresets
        WHERE attemptid=$1 AND emailaddress=$2'
    );

    pg_prepare(db_connect(), "find_latest_reset_attempt" ,
    'SELECT *
        FROM passwordresets
        WHERE emailaddress=$1
        ORDER BY passwordresets.attemptid DESC
        LIMIT 1'
    );


    pg_prepare(db_connect(), "set_password_reset_used",
    'UPDATE passwordresets
        SET used = \'t\'
        WHERE passwordresets.attemptid = $1;'
    );

    pg_prepare(db_connect(), "use_password_reset",
    'UPDATE users
        SET password = $1
        from passwordresets
        WHERE passwordresets.attemptid = $2 AND passwordresets.userid = users.id;'
    );

    pg_prepare(db_connect(), "update_user_token",
    'INSERT INTO tokens(token, userid)
        VALUES($1,$2)
        ON CONFLICT (userid) DO UPDATE
        SET token = $3
        WHERE tokens.userid = $4;'
    );



    function newResetWindow($emailAddress){
        $result = (pg_execute(db_connect(),
            "new_reset_attempt",
            [
                "false",
                $emailAddress,
                $emailAddress
            ]));
        return $result;
    }

    function findLatestResetAttempt($emailAddress){
        return pg_fetch_assoc(pg_execute(db_connect(), "find_latest_reset_attempt", [$emailAddress]));
    }

    function findResetAttempt($attemptId, $emailAddress){
        return pg_fetch_assoc(pg_execute(db_connect(), "find_reset_attempt", [$attemptId, $emailAddress]));
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

    function storeToken($token, $userid){
        return pg_execute(db_connect(), "update_user_token", [$token, $userid, $token, $userid]);
    }

    function verifyPassword($plaintextPassword, $userID){
        $results = pg_fetch_assoc(pg_execute(db_connect(), "find_password_by_id", [$userID]));
        return password_verify($plaintextPassword, $results['password']);
    }

    function changePassword($newPassword, $userID){
        return pg_execute(db_connect(), "change_password", [password_hash($newPassword, PASSWORD_BCRYPT), $userID]);
    }

    function changePasswordUsingReset($newPassword, $resetAttemptInfo){
        $checks = array();

        array_push($checks,  pg_execute(db_connect(), "set_password_reset_used",
            [$resetAttemptInfo['attemptid']]));

        array_push($checks,  pg_execute(db_connect(), "use_password_reset",
            [password_hash($newPassword, PASSWORD_BCRYPT), $resetAttemptInfo['attemptid']]));

        foreach ($checks as $check){
            if(!$check){
                return false;
            }
        }
        return true;
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

