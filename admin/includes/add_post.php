<?php 
//dolazimo na stranicu sa praznim inputima
if(isset($_POST['create_post'])) {
//uzimamo podatke preko POST-a
$post_title = $_POST['title'];
$post_user = $_POST['post_user'];
$post_category_id = $_POST['post_category'];
$post_status = $_POST['post_status'];
//ime slike
$post_image = $_FILES['image']['name'];
//tmp lokacija slike
$post_image_temp = $_FILES['image']['tmp_name'];
//pomjeri sa tmp lokacije na lokaciju root/images/ime slike
move_uploaded_file($post_image_temp, "../images/$post_image");
$post_tags = $_POST['post_tags'];
$post_content = $_POST['post_content'];
$post_date = date('d-m-y');
//upit
$query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status) VALUES ($post_category_id, '$post_title', '$post_user', now(), '$post_image', '$post_content', '$post_tags', '$post_status')";
$result = mysqli_query($connection, $query);
//zadnji uneseni id broj
$the_post_id = mysqli_insert_id($connection);
//pregledaj novonapravljenu objavu
echo "<p class='bg-success'>Post updated. <a href='../post.php?p_id=$the_post_id'> View Post</a></p>";
}
?>
<form action="" method="post" enctype="multipart/form-data">




    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>


    <div class="form-group">
        <label for="post_category">Category</label>
        <br>
        <select name="post_category" id="">
            <?php 
            //izbor kategorija preko dropdowna
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_categories)) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="users">User</label>
        <br>
        <select name="post_user" id="">
            <?php 
            //izbor korisnika preko dropdown
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_users)) {
                $username = $row['username'];
                $user_id = $row['user_id'];
                echo "<option value='$username'>$username</option>";
            }
            ?>
        </select>


    </div>
    <div class="form-group">
        <label for="status">Post Status</label>
        <br>
        <!-- Status objave -->
        <select name="post_status" id="">
            <option value=" draft">Select Options</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
    </div>


    <!-- <div class="form-group">
         <label for="title">Post Author</label>
          <input type="text" class="form-control" name="author">
      </div> -->


    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div>


    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>


    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control " name="post_content" id="body" cols="30" rows="10">
         </textarea>
    </div>



    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>




</form>
