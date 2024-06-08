<?php
    $title = "Index";

    include("./includes/header.php");
    //print_r(openssl_get_cipher_methods());
    //print_r(openssl_encrypt("test", "aes128", "abc", 0, "16chars000000000"));
    //print_r(openssl_decrypt("/+Ja8nQ7qtr05jtmnxbMCw", "aes128", "abc", 0, "16chars000000000"));
echo (date('d-m-Y H:i:s e'));
$test =  date('d-m-Y H:i:s');
$test = strtotime($test);
//setcookie("testCookie", openssl_encrypt("test", "aes128", "abc", 0, "16chars000000000"), time() + (1000), "/");
//print_r(openssl_decrypt($_COOKIE["testCookie"], "aes128", "abc", 0, "16chars000000000"));

if($test == false){
    echo("<br />". "failure");

} else{
    echo("<br />". $test);
}
?>

<h1>PHP DEMO</h1>