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
            //Kada korisnik pritisne na na link neke posebne objave ona ga vodi na stranicu post.php i u GET-u cuva svoj id broj
            if(isset($_GET['p_id'])) {
            //uzimamo ID broj objave
            $the_post_id = $_GET['p_id'];
            //dodaj broj 1 na broj pogleda
            $query = "UPDATE posts SET post_views_counts = post_views_counts + 1 WHERE post_id = $the_post_id";
            $result = mysqli_query($connection, $query);
            //da li je korisnik ulogovan kao admin
            if(isset($_SESSION['user_role']) && $_SESSION['user_role']== 'admin') {
            //upit je prikaz objave gdje je post_id jednak onom iz GET-a
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
            } else {
            //ukoliko nije admin, pored ovog gore upita objava mora biti i published
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
            }
            $result = mysqli_query($connection, $query);
            //broj objava koji odgovaraju gore navedenom upitu
            $count = mysqli_num_rows($result);
            if($count==0) {
            //rezultat je 0
                echo "<h2>NO POSTS</h2>";
            } else {
            //rezultat je > 0
            while($row = mysqli_fetch_assoc($result)) {
                $post_category_id = $row['post_category_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_status = $row['post_status'];
                ?>
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
            <hr>
            <?php
            } ;
            ?>
            <!-- Blog Comments -->
            <!-- Comments Form -->
            <div class="well">
               <!-- POLJE ZA KOMENTARE -->
                <h4>Leave a Comment:</h4>
                <?php 
                //kada korisnik napise komentar i pritisne dugme za slanje komentara
                if(isset($_POST['create_comment'])) {
                //ID broj objave na kojoj je napisan komentar, hvatamo ga preko GET-a
                    $the_post_id = $_GET['p_id'];
                //autor komentara polje
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                //ako polja nisu prazna
                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                //upit
                    $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES($the_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";
                    $create_comment_query = mysqli_query($connection, $query);
                    //update comments count
                    //$query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id";
                    //$update_post_comment_count = mysqli_query($connection, $query);
                    } else {
                    //ako su polja prazna obavijesti korisnika
                        echo "<script>alert('Please enter values in all fields')</script>";
                    }
                }
                ?>
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" name="comment_author" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="comment_email" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your Comment</label>
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>

                </form>
            </div>
            <hr>

            <!-- Posted Comments -->
            <?php 
            //Prikaz komentara na objavi
            //upit prikazi one komentara ciji je comment_post_id jednak the_post_id, preko toga je uradjena relacija. Njihov comment_status je approved i poredani su od najmanjeg ID broja
            $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id AND comment_status = 'approved' ORDER BY comment_id DESC";
            $select_comment_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_comment_query)) {
            //uzmi informacije
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];
                $comment_author = $row['comment_author'];
                ?>
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment_author ?>
                        <small><?php echo $comment_date ?></small>
                    </h4>
                    <?php echo $comment_content ?>
                </div>
            </div>
            <?php
            }}} else {
                header("Location: index.php");
            }
            ?>


        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php";?>
