<!-- Ukljucivanje baze -->
<?php include "db.php";?>
<!-- Pokretanje sesije -->
<?php session_start() ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">HOMEPAGE</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php 
                // ----- UPIT ZA SVE KATEGORIJE ----- //
                $query = "SELECT * FROM categories";
                $result = mysqli_query($connection, $query);
                if(!$result) {
                    echo "connection failed";
                }
                while($row = mysqli_fetch_assoc($result)) {
                    //izvlacenje informacija
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    $category_class = '';
                    $registration_class = '';
                    //trenutna stranica
                    $pageName = basename($_SERVER['PHP_SELF']);
                    $registration = 'registration.php';
                    //ako nesto ima u var category i to se isto nalazi u GET super globalnoj varijabli category_class var je aktivan
                    if(isset($_GET['category'])&& $_GET['category']==$cat_id) {
                      $category_class = 'active';  
                    } else if($pageName == $registration) {
                        //ukoliko je trenutna stranica gdje se nalazimo registration.php onda je registration_class var aktivna
                        $registration_class = 'active';
                    }
                    echo "<li class='$category_class'><a href='category.php?category=$cat_id'>$cat_title</a></li>";
                }
                ?>
                <li><a href="admin/index.php">Admin</a></li>
                <li class="<?php echo $registration_class?>"><a href="../cms/registration.php">Registration</a></li>
                <!-- // ----- UPIT ZA SVE KATEGORIJE ----- // -->
                <?php 
                //ako je korisnik prijavljen na nasu stranicu, a to znamo ako mu je sesije user_role postavljena onda mu prikazujemo link
                if(isset($_SESSION['user_role'])) {
                    if(isset($_GET['p_id'])) {
                        $the_post_id = $_GET['p_id'];
                        //link ga odvodi u admin stranicu posts i vrsi ured
                        echo "<li><a href='admin/posts.php?source=edit_post&p_id=$the_post_id'>Edit post</a></li>";
                    }
                }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
