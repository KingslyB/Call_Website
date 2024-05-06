<?php
    /**
     * Author: Kingsly Bude
     * Description: Calls page
     */
    $title = "Calls";
    include "./includes/header.php";

    if(!isset($_SESSION['user_id'])){
        header("Location: sign-in.php");
    }
    $error_list = array();
    $all_calls = find_all_calls_detailed();
?>
<table>
    <tr>
            <th>Call ID</th>
            <th>Call Timestamp</th>
            <th>Client's First Name</th>
            <th>Client's Last Name</th>
            <th>Client's Email</th>
            <th>Client's Phone Number</th>
            <th>Salesperson's First Name</th>
            <th>Salesperson's Last Name</th>
            <th>Salesperson's Email</th>
    </tr>
<?php
    foreach($all_calls as $record => $data){
        echo('<tr>');
            echo('<td>'.$data['call_id'].'</td>');
            echo('<td>'.$data['call_timestamp'].'</td>');
            echo('<td>'.$data['client_first_name'].'</td>');
            echo('<td>'.$data['client_last_name'].'</td>');
            echo('<td>'.$data['client_email'].'</td>');
            echo('<td>'.$data['client_phone'].'</td>');
            echo('<td>'.$data['salesperson_first_name'].'</td>');
            echo('<td>'.$data['salesperson_last_name'].'</td>');
            echo('<td>'.$data['salesperson_email'].'</td>');
        echo('</tr>');
    }
?>
</table>
<?php include "./includes/footer.php"; ?>