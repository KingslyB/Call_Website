<?php

    // pg_prepare(db_connect(), "add_new_user", 
    //     'INSERT INTO users(email, password)
    //     VALUES($1, crypt($2, gen_salt(\'bf\')))'
    // );

    pg_prepare(db_connect(), "add_new_user", 
        'INSERT INTO users(emailaddress, password, firstname, lastname, enrolldate, lastaccess, phoneext, type, isactive)
        VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9)'
    );

    pg_prepare(db_connect(), "login_query", 
        'SELECT password
        FROM users
        WHERE emailaddress=$1'
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

    


    function loginAuthenticate($email, $plaintextPassword){
        $results = pg_execute(db_connect(), "login_query", [$email]);
        $results = pg_fetch_assoc($results);
        
        return password_verify($plaintextPassword, $results['password']);
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

