<?php 
//pokrece sesiju
session_start();
//sve sesije stavlja na null
        $_SESSION['username'] = null;
        $_SESSION['firstname'] = null;
        $_SESSION['lastname'] = null;
        $_SESSION['user_role'] = null;
//vraca nas na pocetnu stranicu
header("Location: ../index.php");
?>


