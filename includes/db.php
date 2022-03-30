<?php 
//niz db
$db["db_host"] = "localhost";
$db["db_user"] = "root";
$db["db_pass"] = "";
$db["db_name"] = "cms";
//od svakog elementa niza pravimo konstantu
foreach($db as $key => $value) {
    define(strtoupper($key), $value);
}
//konektovanje na bazu
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if(!$connection) {
    echo "connection failed";
};
?>
