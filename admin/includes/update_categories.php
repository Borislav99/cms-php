                        <!-- UPDATE -->
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat_title">Edit Category</label>
                                <?php 
                                //kada pritisnemo na dugme za uredjivanje kategorije u GET ubacujemo ID broj objave
                                if(isset($_GET['edit'])) {
                                //id broj objave
                                    $id = $_GET['edit'];
                                //upit pretrage kategorije
                                    $query = "SELECT * FROM categories WHERE cat_id = $id";
                                    $result = mysqli_query($connection, $query);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $cat_title = $row['cat_title'];
                                        $cat_id = $row['cat_id'];
                                        ?>
                                <!-- <!-- HTML --> 
                                <!-- Prikaz kategorije -->
                                <input class="form-control" type="text" name="cat_title" value="<?php echo $cat_title?>" id="">
                                <!-- HTML -->
                                <?php
                                } }
                                ?>
                            </div>
                            <div class="form-group">
                                <?php 
                                //postavili smo informacije preko GET-a, sad ih hvatamo preko POST-a
                                if(isset($_POST['update_category'])) {
                                    //uzimamo vrijednost iz inputa
                                    $the_cat_title = $_POST['cat_title'];
                                    //upit
                                    $stmt1 = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?");
                                    mysqli_stmt_bind_param($stmt1, "si", $the_cat_title, $id);
                                    mysqli_stmt_execute($stmt1);
                                    mysqli_stmt_close($stmt1);
                                    // --->
                                    //vracamo na stranicu categories.php
                                    redirect("/demo/cms/admin/categories.php");
                                }
                                ?>
                                <input class="btn btn-primary" type="submit" name="update_category" id="" value="Edit Category">
                            </div>
                        </form>
                        <!-- UPDATE -->
