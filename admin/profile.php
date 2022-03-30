<?php include "includes/admin_header.php" ?>
<?php 
    if(isset($_SESSION['username'])) {
    //na osnovu sesije dobijamo korisnicko ime prijavljenog korisnika
        $username = $_SESSION['username'];
        $query = "SELECT * FROM users WHERE username = '$username'";
        $select_user_profile_query = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_user_profile_query)) {
    //izvlacimo informacije o korisniku
            $user_id = $row['user_id'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_role = $row['user_role'];
            $user_email = $row['user_email'];
            $user_password = $row['user_password'];
        }
    }
?>
<?php 
//kada korisnik pritisne dugme za mijenjanje informacija
if(isset($_POST['update_user'])) {
    //uzimamo informacije iz inputa
    $user_firstname_submit = $_POST['user_firstname'];
    $user_lastname_submit = $_POST['user_lastname'];
    $username_submit = $_POST['username'];
    $user_email_submit = $_POST['user_email'];
    $user_password_submit = $_POST['user_password'];
    //ako polja nisu prazna
    if(!empty($user_firstname_submit) && !empty($user_lastname_submit) && !empty($username_submit) && !empty($user_email_submit) && !empty($user_password_submit)) {
    //sifruj lozinku
    $user_password_submit = password_hash($user_password_submit, PASSWORD_BCRYPT, ['case' => 12]);
    //posalji upit
    $query = "UPDATE users SET user_firstname = '$user_firstname_submit', user_lastname = '$user_lastname_submit',  username = '$username_submit', user_email = '$user_email_submit', user_password = '$user_password_submit' WHERE user_id = $user_id";
    $update_query = mysqli_query($connection, $query);      
    } else {
    //ako je neko od polja prazno vrati ga na stranicu profila
        header("Location: profile.php");
    }
}
?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Author</small>
                    </h1>
                    <!-- Prikaz informacija korisnika -->
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="author">Firstname</label>
                            <input class="form-control" type="text" name="user_firstname" id="" value="<?php echo $user_firstname?>">

                        </div>
                        <div class="form-group">
                            <label for="status">Lastname</label>
                            <input class="form-control" type="text" name="user_lastname" id="" value="<?php echo $user_lastname?>">

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
                            <input class="btn btn-primary" type="submit" name="update_user" value="Update Profile">
                        </div>

                    </form>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php" ?>
