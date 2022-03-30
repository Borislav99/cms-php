<?php 
if(isset($_POST['submit'])) {
    //da li je postavljen checkBoxArray
    if(isset($_POST['checkBoxArray'])) {
    //ako jeste vrijednosti svih elemenata cuvamo unutar nixa
         $arr = $_POST['checkBoxArray'];
        foreach($arr as $postValueId) {
    //svaki pojedinacni element niza predstavljamo sa vrijednostcu postValueId
            $bulk_options = $_POST['bulk_options'];
            switch($bulk_options) {
    //ako je vrijednost published, za svaki od izabranih elemenata stavljamo status na published
                case "published":
                    $query = "UPDATE posts SET post_status = 'published' WHERE post_id = $postValueId";
                    $update_to_published = mysqli_query($connection, $query);
                    break;
    //ako je vrijednost draft, za svaki od izabranih elemenata stavljamo status na draft
                case "draft":
                    $query = "UPDATE posts SET post_status = 'draft' WHERE post_id = $postValueId";
                    $update_to_draft = mysqli_query($connection, $query);
                    break;
    //ako je vrijednost delete, svaki izabrani element brisemo
                case "delete":
                    $query = "DELETE FROM posts WHERE post_id = $postValueId";
                    $delete_query = mysqli_query($connection, $query);
                    break;
    //ako je vrijednost clone
                case "clone":
    //pravimo upit koji za svaku pojedinacnu vrijednost izvlaci informacije
                    $query = "SELECT * FROM posts WHERE post_id = $postValueId";
                    $result = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($result)) {
                        $post_id = $row['post_id'];
                        $post_author = $row['post_user'];
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_comment_count = $row['post_comment_count'];
                        $post_date = $row['post_date'];
                        $post_content = $row['post_content'];
                    };
    //kada izvuce informacije stavlja informacije na bazu
                    $query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status) VALUES ($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', $post_comment_count, '$post_status')";
                    $result = mysqli_query($connection, $query);
            }
        }
    }
}
?>
<form action="" method="post">
    <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select name="bulk_options" id="" class="form-control">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
        <thead>
            <tr>
               <!-- Prikaz svih objava tabela --->
                <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                <th>Id</th>
                <th>User</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                <th>Link</th>
                <th>Edit</th>
                <th>Delete</th>
            <!-- Prikaz svih objava tabela --->
            </tr>
        </thead>
        <tbody>
            <?php 
                            //upit za izbor svih objava, tom upitu udruzujemo upit za kategorije. Njihova relacija je sljedeca isti je post_category_id unutar posta i cat_id unutar categories i zelimo poredati rezultat pocevsi od namjanjeg id broj
                            $query = "SELECT * FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
                            $result = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                            //izvlacenje podataka
                                $post_id = $row['post_id'];
                                $post_author = $row['post_author'];
                                $post_user = $row['post_user'];
                                $post_title = $row['post_title'];
                                $post_category_id = $row['post_category_id'];
                                $post_status = $row['post_status'];
                                $post_image = $row['post_image'];
                                $post_tags = $row['post_tags'];
                                $post_comment_count = $row['post_comment_count'];
                                $post_date = $row['post_date'];
                                $post_views_counts = $row['post_views_counts'];
                                $cat_title = $row['cat_title'];
                                $cat_id = $row['cat_id'];
                                echo "<tr>";
?>
           <!-- Za svaku od objava postoji checkbox, ime checkBoxa je checkBoxArray i vrijednosti pojedinacnih elemenata cuvamo u value -->
            <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value="<?php echo $post_id ?>"></input></td>;
            <?php
                                //prikaz zpodataka
                                echo "<td>$post_id</td>";
                                // ----->
                                if(!empty($post_author)) {
                                echo "<td>$post_author</td>";
                                } else if(isset($post_user) || !empty($post_user)){
                                   echo "<td>$post_user</td>"; 
                                }
                                // ----->
                                echo "<td>$post_title</td>";
                                /*
                                $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                                $select_categories_id = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_assoc($select_categories_id)) {
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                }
                                */
                                echo "<td>$cat_title</td>";
                                
                                
                                echo "<td>$post_status</td>";
                                echo "<td><img src='../images/$post_image' width=100px></img></td>";
                                echo "<td>$post_tags</td>";
                                //broj komentara objave cuvamo u varijablu comms_count
                                $get_comms = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                                $comms_result = mysqli_query($connection, $get_comms);
                                $comms_count = mysqli_num_rows($comms_result);
                                // --------->
                                //$row = mysqli_fetch_assoc($comms_result);
                                //broj komentara u tabeli se azurira sa comms_count
                                $update_query = "UPDATE posts SET post_comment_count = $comms_count WHERE post_id = $post_id";
                                $update_post_comment_count = mysqli_query($connection, $update_query);
                                //odvedi nas na pojedinacnu stranicu post_comments.php
                                echo "<td><a href='./post_comments.php?id=$post_id'>$comms_count</a></td>";
                                // --------->
                                echo "<td>$post_date</td>";
                                //resetovanje pregleda objave
                                echo "<td><a href='posts.php?reset=$post_id'>$post_views_counts</a></td>";
                                //prikaz pojedinacne objave
                                echo "<td><a href='../post.php?p_id=$post_id'>View Post</a></td>";
                                //edit
                                echo "<td><a href='posts.php?source=edit_post&p_id=$post_id' class='btn btn-primary'>Edit</a></td>";
                                //edit
                                ?>
            <form action="" method="post">
                <input type="hidden" name="post_id" value="<?php echo $post_id?>">
                <td>
                    <input class="btn btn-danger" type="submit" name="delete" value="Delete">
                </td>
            </form>
            <?php
                                //delete
                                echo "</tr>";
                            }
                            ?>
        </tbody>
    </table>
    <?php 
    if(isset($_GET['reset'])) {
        $id = $_GET['reset'];
        $query = "UPDATE posts SET post_views_counts = 0 WHERE post_id = $id";
        $send = mysqli_query($connection, $query);
        header("Location: posts.php");
    }    
    ?>
    <?php 
if(isset($_POST['delete'])) {
    //kada korisnik pritisne dugme Delete, uzimamo ID broj objave iz inputa i cuvamo ga u del_post
    $del_post = $_POST['post_id'];
    //upit
    $query = "DELETE FROM posts WHERE post_id = $del_post";
    $delete_query = mysqli_query($connection, $query);
    //vracanje na istu stranicu
    header("Location: posts.php");
}
?>
</form>
