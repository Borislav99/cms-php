<?php include "db.php" ?>
<?php include "../admin/functions.php" ?>
<?php 
    //pokrece sesiju
    session_start();
?>
<?php 
    //ubacujemo informacije iz inputa u varijable
    if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];  
    //saljemo ih u funkciju login_user
    login_user($username, $password);
}
        
?>
