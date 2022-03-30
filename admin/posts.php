<?php include "includes/admin_header.php" ?>
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
                    /* ----- OBJAVE ZAVISNO OD GET-A ----- */
                    if(isset($_GET['source'])) {
                    //hvatamo vrijednost iz GET-a
                        $source = $_GET['source'];
                    } else {
                    //ukoliko je nam onda je prazno
                        $source = "";
                    }
                    switch($source) {
                    //slucaj add_post, ubacujemo stranicu add_post
                        case 'add_post':
                            include "includes/add_post.php";
                            break;
                    //slucaj edit_post, ubacujemo stranicu edit_post
                        case 'edit_post':
                            include "includes/edit_post.php";
                            break;
                    //slucaj prazno, prikazi sve objave
                        default:
                            include "includes/view_all_posts.php";
                    }
                    /* ----- OBJAVE ZAVISNO OD GET-A ----- */
                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php" ?>
