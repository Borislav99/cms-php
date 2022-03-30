<div class="col-md-4">

    <!-- Blog Search Well -->
    <!-- MASINA PRETRAZIVACA FORMA -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" name="search" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" name="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>

        </form>
        <!-- /.input-group -->
    </div>
    <!-- MASINA PRETRAZIVACA FORMA -->
    
    <!-- Login -->
    <div class="well">
        <?php 
        /* ----- LAKSI NACIN PRIJAVLJIVANJA ----- */
        if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        ?>
        <h4>Logged in as <?php echo $username?></h4>
        <a href="includes/logout.php" class="btn btn-primary">Log out</a>
        <?php
        } else {
        ?>
        <h4>Login</h4>
        <form action="includes/login.php" method="post">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Enter username">
            </div>
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="Enter password">
                <span class="input-group-btn">
                    <button class="btn btn-primary" name="login" type="submit">Submit</button>
                </span>
            </div>

        </form>
        <!-- /.input-group -->
        <?php
                }
        /* ----- LAKSI NACIN PRIJAVLJIVANJA ----- */
                ?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <?php 
                    /* ----- KATEGORIJE U SIDEBARU ----- */
                            $query = "SELECT * FROM categories";
                            $result = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                                ?>
                    <li><a href="category.php?category=<?php echo $cat_id?>"><?php echo $cat_title;?></a></li>
                    <?php
                            }
                    /* ----- KATEGORIJE U SIDEBARU ----- */
                            ?>
                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php";?>

</div>
