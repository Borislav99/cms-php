<?php 
//unutar cost radis radi prevencije hacka, znaci usporava password hashing. Sto je veci broj unutar cost, funkcija sporije radi. Samim tim je teze probiti sifru. 
//obicni algoritam
//echo password_hash('secret', PASSWORD_DEFAULT, ['cost' => 12]);
//postoji algoritam bcrypt
echo password_hash('secret', PASSWORD_BCRYPT, ['cost' => 12]);
?>
