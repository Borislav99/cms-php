<?php include "includes/header.php" ?>
<!-- Navigation -->
<?php include "includes/navigation.php" ?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            /* ----- PRIKAZIVANJE SVIH KATEGORIJA ----- */
            //broj objava po stranici
            $per_page = 5;
            if(isset($_GET['page'])) {
            //trenutna stranica na kojoj se nalazimo
                $page = $_GET['page'];
            } else {
            //ukoliko nije definisano, znaci da se nalazimo na indeksu tako da je var page prazna
                $page = "";
            };
            if($page=="" || $page == 1) {
            //ako smo na pocetnoj stranici, govorimo da krecemo od objave 0
              $page_1 = 0;  
            } else {
            //ukoliko smo na nekoj drugoj stranici, recimo na stranici 2, ona treba krenuti od objave 5. 2*5 - 5 = 5
                $page_1 = ($page*$per_page) - $per_page;
            };
            //zavisno od onoga sto se nalazi unutar user_role pisemo upit, ukoliko je korisnik admin biramo sve objave, ukoliko nije onda biramo samo one koje su published
            if(isset($_SESSION['user_role']) && $_SESSION['user_role']== 'admin') {
                $post_query_count = "SELECT * FROM posts";
            } else {
                $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
            }
            $find_count = mysqli_query($connection, $post_query_count);
            //broj objava
            $count = mysqli_num_rows($find_count);
            //ukoliko je broj objava nula
            if($count<1) {
                echo "<h1 class='text-center'>NO POSTS</h1>";
            } else {
            //ukoliko je broj objava veci od 0, koristimo funkciju ceil zato sto ako imamo npr 11 objava, 11 na 5 je 2.2, ceil ce uraditi da dobijemo 3
            $count = ceil($count/5);
            //slanje upita
            //$query = "SELECT * FROM posts LIMIT $page_1, $per_page";
                

            $query = $post_query_count. " LIMIT $page_1, $per_page";
            $select_all_post_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_all_post_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 100);
                $post_status = $row['post_status'];
                $post_time_creation = $row['time'];
                $delete_in = $row['delete_in'];
            ?>
            <!-- First Blog Post -->
            <!-- -->
                        <h2>
                <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
            </h2>
            <p class="lead">
                by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
            <hr>
            <!-- Ako pritisnemo na sliku ona nas odvodi na stranicu gdje prikazuje pojedinacnu objavu -->
            <a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src="./Images/<?php echo $post_image ?>" alt=""></a>
            <hr>
            <p><?php echo $post_content ?>.</p>
            <!-- Ako pritisnemo na link Read more on nas odvodi na stranicu gdje prikazuje pojedinacnu objavu -->
            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
<!-- -->
            <hr>
            <?php
            } 
            }; 
            /* ----- PRIKAZIVANJE SVIH KATEGORIJA ----- */
            ?>
        </div>
        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>
    <!-- /.row -->
    <hr>
    <ul class="pager">
        <?php 
        for($i = 1; $i<= $count; $i++) {
            if($i == $page) {
                echo "<li ><a style='background:black' href='index.php?page=$i'>$i</a></li>";
            } else {
             echo "<li><a href='index.php?page=$i'>$i</a></li>";   
            }
        }
        ?>
    </ul>
    <?php include "includes/footer.php" ?>
