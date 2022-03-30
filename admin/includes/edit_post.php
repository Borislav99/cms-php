<?php 
//kada pritisnemo na link edit dobijamo
if(isset($_GET['p_id'])) {
//id broj objave na osnovu koga mozemo izvuci informacije o pojedinacnoj objavi
    $the_post_id = $_GET['p_id'];
    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
    $select_posts_by_id = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id = $row['post_id'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_content = $row['post_content'];
    }
}
?>
<?php 
//kada korisnik pritisne link za uredjivanje objave
if(isset($_POST['update_post'])) {
//izvlace se informacije
$post_title = $_POST['title'];
$post_user = $_POST['post_user'];  
$post_category_id = $_POST['post_category'];
$post_status = $_POST['post_status'];
$post_image = $_FILES['image']['name'];
$post_image_temp = $_FILES['image']['tmp_name'];
move_uploaded_file($post_image_temp, "../images/$post_image");
//ako je slika prazna
if(empty($post_image)) {
    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
    $query_select_image = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($query_select_image)) {
        //uzmi sliku
        $post_image = $row['post_image'];
    }
}
$post_content = $_POST['post_content'];
$post_tags = $_POST['post_tags'];
//upit
$query = "UPDATE posts SET post_title = '$post_title', post_user = '$post_user', post_category_id = '$post_category_id', post_date = now(), post_status = '$post_status', post_image = '$post_image', post_content = '$post_content', post_tags = '$post_tags' WHERE post_id = $the_post_id";
$update_post = mysqli_query($connection, $query);
//povratna informacija
echo "<p class='bg-success'>Post updated. <a href='../post.php?p_id=$the_post_id'> View Post</a><a href='./posts.php'> Edit Other Posts</a></p>";
}
?>
<form action="" method="post" enctype="multipart/form-data">



<!-- Prikaz informacija -->
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $post_title ;?>">
    </div>


    <div class="form-group">
        <label for="categories">Categories</label>
        <br>
        <select name="post_category" id="">
            <?php 
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_categories)) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                if($cat_id==$post_category_id) {
                //zbog napravljene relacije, kategorije i objave imaju isti ID broj, prvo prikazujemo onu kategoriju kojoj objava pripada
                echo "<option selected value='$cat_id'>$cat_title</option>";                    
                }
                else {
                //poslije prikazujemo sve objave
                echo "<option value='$cat_id'>$cat_title</option>";
                };
            }
            ?>

        </select>
    </div>
    <div class="form-group">
        <label for="users">User</label>
        <br>
        <!--<input class="form-control" type="text" name="author" id="" value="<?php //echo $post_user ;?>"> -->
        <select name="post_user" id="">
            <?php 
            //korisnik koji je napisao objavu
            echo "<option value='$post_user'>$post_user</option>";
            ?>
            <?php 
            //svi ostali korisnici
            $select_users = "SELECT * FROM users WHERE NOT username = '$post_user'";
            $get_data = mysqli_query($connection, $select_users);
            while($row = mysqli_fetch_assoc($get_data)) {
                $username = $row['username'];
                echo "<option value='$username'>$username</option>";
            }
            ?>
        </select>

    </div>
    <!--
    <div class="form-group">
        <label for="status">Post Status</label>
        <input class="form-control" type="text" name="post_status" id="" value="">


    </div>
-->
    <div class="form-group">
        <label for="status">Post Status</label>
        <br>
        <select name="post_status" id="">
        <!-- Prva vrijednost je ona koja je sacuvana u bazi -->
            <option value="<?php echo $post_status?>"><?php echo ucwords($post_status)?></option>
            <?php 
            //ukoliko je prva vrijednost published, onda je druga draft
            if($post_status=='published') {
                echo "<option value='draft'>Draft</option>";
            } else {
            //obrnuto
                echo "<option value='published'>Published</option>";
            };
            ?>
        </select>
    </div>

    <!-- <div class="form-group">
         <label for="title">Post Author</label>
          <input type="text" class="form-control" name="author">
      </div> -->


    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img src="../images/<?php echo $post_image?>" width="100px" alt="">
        <input type="file" name="image" id="">
    </div>


    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags ;?>">
    </div>


    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control " name="post_content" id="body" cols="30" rows="10"><?php echo $post_content ;?></textarea>
    </div>






    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Publish Post">
    </div>




</form>
