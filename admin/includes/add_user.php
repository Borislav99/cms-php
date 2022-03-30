<?php 
if(isset($_POST['create_user'])) {
//kada korisnik pritisne submit novog korisnika, uzimaju se informacije iz inputa
$user_firstname = $_POST['user_firstname'];
$user_lastname = $_POST['user_lastname'];
$user_role = $_POST['user_role'];
$username = $_POST['username'];
$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];
//sifrovanje lozinke, prvi parametar sifra, drugi algoritam, treci tezina sto je veca to treba duze da se sifruje lozinka
$user_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost'=>12]);
//upit
$query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) VALUES('$user_firstname', '$user_lastname', '$user_role', '$username', '$user_email', '$user_password')";
$create_user = mysqli_query($connection, $query);
//povratna informacija
echo "User $username Created". " ". "<a href='users.php'>View Users</a>";
}
?>
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="author">Firstname</label>
        <input class="form-control" type="text" name="user_firstname" id="">

    </div>
    <div class="form-group">
        <label for="status">Lastname</label>
        <input class="form-control" type="text" name="user_lastname" id="">

    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="subscriber">Select options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
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
        <input type="text" class="form-control" name="username">
    </div>


    <div class="form-group">
        <label for="post_content">Email</label>
        <br>
        <input type="email" name="user_email" class="form-control" id="">
    </div>

    <div class="form-group">
        <label for="post_tags">Password</label>
        <input type="password" name="user_password" class="form-control" id="">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>

</form>
