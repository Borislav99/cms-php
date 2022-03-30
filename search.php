<?php include "includes/header.php";?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <!-- First Blog Post -->
            <?php 
            /* ----- MASINA PRETRAZIVACA ----- */
            if(isset($_POST['submit'])) {
            //u varijablu stavljamo ono sto se nalazi unutar inputa
            $search = $_POST['search'];
            //upit, gdje ono sto je korisnik upisao slicno onome sa baze
            $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
            $result = mysqli_query($connection, $query);
            if(!$result) {
                    die("query failed");
            };
            //koji je broj objava da se podurara sa navedenim pravilima upita
            $count = mysqli_num_rows($result);
            //rezultat je 0
            if($count==0) {
                echo "<h1>NO RESULTS</h1>";
                } 
            //rezultat je > 0
                else {
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($result)) {
            $post_id = $row['post_id'];
            $post_category_id = $row['post_category_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_status = $row['post_status'];
                ?>
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
            <h2>
                <a href="#"><?php echo $post_title;?></a>
            </h2>
            <p class="lead">
                by <a href="index.php"><?php echo $post_author;?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_image?>" alt="">
            <hr>
            <p><?php echo $post_content;?></p>
            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>
            <?php
                }
            /* ----- MASINA PRETRAZIVACA ----- */
                }
            }
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php";?>
