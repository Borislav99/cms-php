<?php include "includes/header.php";?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>

            <!-- First Blog Post -->
            <?php 
            //izvlacimo informacije iz GET-a, o autoru objave
            if(isset($_GET['p_id'])) {
                $the_post_id = $_GET['p_id'];
            //autor objave
                $the_post_author = $_GET['author'];
            }
            //upit za uzimanje informacija o autoru objave
            $query = "SELECT * FROM posts WHERE post_user = '$the_post_author'";
            $result = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($result)) {
                $post_id = $row['post_id'];
                $post_category_id = $row['post_category_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_status = $row['post_status'];
                //ispod prikaz objave
                ?>
            <h2>
                <a href="post.php?p_id=<?php echo $post_id?>"><?php echo $post_title;?></a>
            </h2>
            <p class="lead">
                Post by <?php echo $post_author?>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
            <hr>
            <img class="img-responsive" src="images/<?php echo $post_image?>" alt="">
            <hr>
            <p><?php echo $post_content;?></p>
            <hr>
            <?php
            }
            ?>
            <!-- Blog Comments -->


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php";?>
