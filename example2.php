<?php 
session_start();
if(isset($_SESSION["greet"])) {
    $value = $_SESSION["greet"];
    echo $value;
} else {
    echo "failed";
}
?>
