<?php include "includes/admin_header.php" ?>
<?php 
    //ako je trenutni korisnik admin odmah ga odvedi na stranicu index.php, misli se na admin/index.php
    if(!is_admin($_SESSION['username'])) {
        header("Location: index.php");
    };
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
                    <?php 
                    //unutar GET-a saznajemo sta se radi sa korisnikom
                    if(isset($_GET['source'])) {
                        $source = $_GET['source'];
                    } else {
                        $source = "";
                    }
                    switch($source) {
                    //dodavanje novog
                        case 'add_user':
                            include "includes/add_user.php";
                            break;
                    //uredjivanje korisnika
                        case 'edit_user':
                            include "includes/edit_user.php";
                            break;
                    //prikaz svih korisnika
                        default:
                            include "includes/view_all_users.php";
                    }
                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php" ?>
