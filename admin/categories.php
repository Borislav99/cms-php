<!-- Ovdje se nalazi baza i funkcije -->
<?php include "includes/admin_header.php"?>;
<div id="wrapper">
    <?php
    /* ----- KATEGORIJE UNUTAR ADMINA ----- */
    //brisanje kategorija
    deleteCategories();
?>
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php";?>;

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin
                        <small>Author</small>
                    </h1>
                    <div class="col-xs-6">
                        <?php 
                        //dodavanje kategorija
                        insert_categories();
                        ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title">Add Category</label>
                                <input class="form-control" type="text" name="cat_title" id="">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" id="" value="Add Category">
                            </div>
                        </form>
                        <!-- INCLUDE -->
                        <?php 
                        //ako je unutar GET-a edit, otvori ubaci update_categories.php za uredjivanje objava
                        if(isset($_GET['edit'])) {
                            $cat_id = $_GET['edit'];
                            include "includes/update_categories.php";
                        }
                        ?>
                        <!-- INCLUDE -->

                    </div>
                    <div class="col-xs-6">
                        <!-- Tabela za kategorije -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                //prikazi sve kategorije
                                findAllCategories();
                                ?>
                            </tbody>
                        </table>
                        <!-- Tabela za kategorije -->
                    </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php 
    /* ----- KATEGORIJE UNUTAR ADMINA ----- */
    include "includes/admin_footer.php"
    ?>;
