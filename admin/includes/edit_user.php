<?php 
if(isset($_GET['edit_user'])) {
    //preko GET dobijamo ID broj korisnika
    $the_user_id = $_GET['edit_user'];
    //preko upita uzimamo informacije od korisnika
    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $get_data = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($get_data)) {
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_role = $row['user_role'];
    $username = $row['username'];
    $user_email = $row['user_email'];
    $user_password = $row['user_password'];
    }

?>
<?php 
//kada korisnik submituje, podaci se uzimaju iz inputa
if(isset($_POST['edit_user'])) {
$user_firstname = $_POST['user_firstname'];
$user_lastname = $_POST['user_lastname'];
$user_role = $_POST['user_role'];
$username = $_POST['username'];
$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];
//ako polja nisu prazna
if(!empty($user_password) && !empty($user_firstname) && !empty($user_lastname) && !empty($user_role) && !empty($username) && !empty($user_email)) {
    //ovaj query nam daje samo jedan rezultat odnosno sifru, tako da ne moramo raditi while petlju
    $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
    $get_user_query = mysqli_query($connection, $query_password);
    $row = mysqli_fetch_assoc($get_user_query);
    //dobijas sifru iz baze kako bi je mogao uporediti sa onom koju je korisnik upisao
    $db_user_password = $row['user_password'];
    //ako hashovana sifra korisnika iz baze, nije jednaka onoj kojoj je napisao u input
    if($db_user_password != $user_password) {
    //hashuj je
    $hash_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => 12]);
}
    //enkriptuj
$query = "UPDATE users SET user_firstname = '$user_firstname', user_lastname = '$user_lastname', user_role = '$user_role', username = '$username', user_email = '$user_email', user_password = '$hash_password' WHERE user_id = $the_user_id";
$update_query = mysqli_query($connection, $query);
echo "User $username updated ". "<a href='users.php?source=view_all_users'>View All Users</a>";
} else {
    //ako polja jesu prazna
    header("Location: ./users.php?source=edit_user&edit_user=$the_user_id");
}
};
} else {
    //ako korisnik nekako udje na stranicu, a unutar GET-a ne postoji ID broj
    header("Location: ./index.php");
}
?>
<!-- Prikaz uzetih informacija iz GET-a -->
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="author">Firstname</label>
        <input class="form-control" type="text" name="user_firstname" id="" value="<?php echo $user_firstname?>">

    </div>
    <div class="form-group">
        <label for="status">Lastname</label>
        <input class="form-control" type="text" name="user_lastname" id="" value="<?php echo $user_lastname?>">

    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="<?php echo $user_role?>"><?php echo ucfirst($user_role)?></option>
            <?php 
            //ako je korisnik korisnik admin, zelis da mu se to pokaze kao prva opcija, a pretplatnik kao druga i obrnuto za pretp;latnika
            if($user_role == 'admin') {
                echo "<option value='subscriber'>Subscriber</option>";
            } else {
                echo "<option value='admin'>Admin</option>";
            }
            ?>
        </select>
    </div>

    <!-- <div class="form-group">
         <label for="title">Post Author</label>
          <input type="text" class="form-control" name="author">
      </div> -->

    <!--
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>
-->
    <div class="form-group">
        <label for="post_tags">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username?>">
    </div>


    <div class="form-group">
        <label for="post_content">Email</label>
        <br>
        <input type="email" name="user_email" class="form-control" id="" value="<?php echo $user_email?>">
    </div>

    <div class="form-group">
        <label for="post_tags">Password</label>
        <input type="password" name="user_password" class="form-control" id="" value="" autocomplete="off">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
    </div>

</form>
