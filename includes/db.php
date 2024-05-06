<?php
    /**
        * Author: Kingsly Bude
        * Description: Database related functions
    */


    /*PREPARED STATEMENTS */
    pg_prepare(db_connect(), "all_salespeople",
        'SELECT *
        FROM users
        WHERE type = \'s\''
    );

    pg_prepare(db_connect(), "all_salespeople_minimal",
        'SELECT id, emailaddress, firstname, lastname, isActive
        FROM users
        WHERE type = \'s\' 
        ORDER BY id'
    );
    
    pg_prepare(db_connect(), "find_salesperson",
        'SELECT *
        FROM users
        WHERE type = \'s\' AND id = $1'
    );

    pg_prepare(db_connect(), "set_salesperson_activity",
        'UPDATE users 
        SET isactive = $2 
        WHERE id = $1'
    );
    
    pg_prepare(db_connect(), "all_calls_detailed",
        'SELECT callId as "call_id",
            calls.callDate as "call_timestamp",
            clients.firstName as "client_first_name",
            clients.lastName as "client_last_name",
            clients.emailAddress as "client_email",
            clients.PhoneNum as "client_phone",
            users.firstName as "salesperson_first_name",
            users.lastName as "salesperson_last_name",
            users.emailaddress as "salesperson_email"
        FROM calls
            INNER JOIN clients ON clients.emailAddress = calls.clientEmailAddress
            INNER JOIN users ON calls.associatedSalesperson = users.id'
    );
    /*Even though the query only queries the calls table, it gets information from the clients and users tables as well
	it will add the information from a single matching record from the clients table everytime the clients.emailaddress is the same as the clientEmaillAddress as the query checks every record in the calls table
    */

    pg_prepare(db_connect(), "all_clients",
        'SELECT *
        FROM clients'
    );

    pg_prepare(db_connect(), "salesperson_clients",
        'SELECT *
        FROM clients
        WHERE salesperson = $1'
    );

    pg_prepare(db_connect(), "user_select",
        'SELECT *
        FROM users
        WHERE emailAddress = $1'
    );
    pg_prepare(db_connect(), "user_update_login_time",
        'UPDATE users
        SET lastAccess = $1
        WHERE emailAddress = $2'
    );
    pg_prepare(db_connect(), "create_salesperson",
        'INSERT INTO users (emailAddress, password, firstName, lastName, enrollDate, type, isActive)
        VALUES ($1, crypt($2, gen_salt(\'bf\')), $3, $4, $5, \'s\', false)'
    );
    pg_prepare(db_connect(), "create_client",
        'INSERT INTO clients (emailAddress, firstName, lastName, phoneNum, salesperson, logopath)
        VALUES ($1, $2, $3, $4, $5, $6)'
    );
    pg_prepare(db_connect(), "user_update_password",
        'UPDATE users
        SET password = crypt($2, gen_salt(\'bf\'))
        WHERE   id = $1'
    );
    /*END OF PREPARED STATEMENTS*/


    /*DATABASE RELATED FUNCTIONS*/
    function db_connect(){
        return pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DATABASE." user=".DB_ADMIN." password=".DB_PASSWORD);
    }
    
    function find_all_salespeople(){
        $query_result = pg_execute(db_connect(), 'all_salespeople', array());
        $information = pg_fetch_all($query_result);
        return $information;
    }

    function find_all_salespeople_minimal(){
        $query_result = pg_execute(db_connect(), 'all_salespeople_minimal', array());
        $information = pg_fetch_all($query_result);
        return $information;
    }

    function find_salesperson($id){
        $query_result = pg_execute(db_connect(), 'find_salesperson', array($id));
        $information = pg_fetch_all($query_result);
        return $information;
    }

    function update_salesperson_activity($id, $new_status){
        if (!empty(find_salesperson($id))){
            $query_result = pg_execute(db_connect(), 'set_salesperson_activity', array($id, $new_status));
            $information = pg_fetch_all($query_result);
            return $information;
        }
        return "NOTHING FOUND";
    }
    

    function find_all_clients(){
        $query_result = pg_execute(db_connect(), 'all_clients', array());
        $information = pg_fetch_all($query_result);
        return $information;
    }

    function find_salesperson_clients($salesperson_id){
        $query_result = pg_execute(db_connect(), 'salesperson_clients', array($salesperson_id));
        $information = pg_fetch_all($query_result);
        return $information;
    }

    function find_all_calls_detailed(){
        $query_result = pg_execute(db_connect(), 'all_calls_detailed', array());
        $information = pg_fetch_all($query_result);
        return $information;
    }

    function user_select($user_email){
        $result = pg_execute(db_connect(), 'user_select', array($user_email));
        return $result;
    }

    function user_update_login_time($user_email, $current_time){
        $result = pg_execute(db_connect(), 'user_update_login_time', array($current_time, $user_email));
        return $result;
    }

    function user_authenticate($user_email, $user_plain_password){
        $user = user_select($user_email);
        $date = date("Y-m-d H:i:s");
        if (password_verify($user_plain_password, pg_fetch_result($user, 'password'))){
            user_update_login_time($user_email, $date);
            $log = fopen('DATE_log.txt', 'a');
            fwrite($log, "Sign in success at ".$date.". User ".$user_email." sign in.\n");
            fclose($log);
            return true;
        }
        else{
            return false;
        }
    }

    function create_salesperson($salesperson_data){
        array_push($salesperson_data, date("Y-m-d H:i:s"));
        $result = pg_execute(db_connect(), 'create_salesperson', $salesperson_data);
        return $result;
    }

    function create_client($client_data){
        $result = pg_execute(db_connect(), 'create_client', $client_data);
        return $result;
    }

    function change_password($user_id, $new_password){
        pg_execute(db_connect(), 'user_update_password', array($user_id, $new_password));
    }
    
    /*END OF DATABASE RELATED FUNCTIONS*/
?>