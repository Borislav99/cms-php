<?php ob_start() ?>
<?php  include "includes/header.php"; ?>
<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>
<?php 
//LANGUAGE
if(isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'>location.reload();</sciprt>";
    }
}
    if(isset($_SESSION['lang'])) {
        include "includes/languages/". $_SESSION['lang']. ".php";
    } else {
        include "includes/languages/en.php";
    }
?>

<!-- Page Content -->
<div class="container">
    <form method="get" class="navbar-form navbar-right" id="language_form">
        <select name="lang" class="form-control" onchange="changeLanguage()">
            <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang']=='en') {echo "selected";} ?>>English</option>
            <option value="srb" <?php if(isset($_SESSION['lang']) && $_SESSION['lang']=='srb') {echo "selected";} ?>>Serbian</option>
        </select>
    </form>

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1><?php echo _REGISTER?></h1>
                        <?php 
/* ----- REGISTRACIJA ----- */
if(isset($_POST['register'])) {
    //uzimamo podatke iz inputa i cistimo ih
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    //prazan asocijativni niz za validaciju
    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];
    //ako je ime manje od 3 karaktera, username kljuc dobija vrijednost ...
    if(strlen($username) < 3) {
        $error['username'] = 'Username needs to be longer';
    }
    //ako je polje ime prazno, kljuc username dobija vrijednost...
    if($username == "") {
        $error['username'] = "Username cannot be empty";
    }
    //funkcija user_exist dobija argument uneseni username, kljuc dobija vrijednost...
    if(user_exists($username)) {
        $error['username'] = "Username  already exists";
    }
    //polje email je prazno, kljuc dobija vrijednost...
    if($email == "") {
        $error['email'] = "Email cannot be empty";
    }
    //funkcija email_exists dobija argument email, kljuc dobija vrijednost...
    if(email_exists($email)) {
        $error['email'] = "Email already exists";
    }
    //polje password je prazno, kljuc dobija vrijednost...
    if(strlen($password) == 0) {
        $error['password'] = "Password cannot be empty";
    }
    //validacija, prolazimo kroz niz
    foreach($error as $key => $value) {
        //ako su polja prazna, praznimo niz error
        if(empty($value)) {
            unset($error[$key]);
        } 
    };
    //ako je niz prazan
    if(empty($error)) {
        //prvo ide funkcija register_user
        register_user($username, $email, $password);
        //nakon toga ide funkcija login_user
        login_user($username, $password);
    }
    //register_user($username, $email, $password);
}
//u slucaju da niz error nije prazan ispod svakog inputa smo napisali da se ispise vrijednost
/* ----- REGISTRACIJA ----- */
?>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME; ?>" autocomplete="on" value="<?php echo isset($username) ? $username: '' ?>">
                                <p>
                                    <?php 
                                    if(isset($error['username'])) {
                                        echo $error['username'];
                                    };
                                    ?>
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL; ?>" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>">
                                <p>
                                    <?php 
                                    if(isset($error['email'])) {
                                        echo $error['email'];
                                    };
                                    ?>
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD; ?>">
                                <p>
                                    <?php 
                                    if(isset($error['password'])) {
                                        echo $error['password'];
                                    };
                                    ?>
                                </p>
                            </div>

                            <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="<?php echo _REGISTER ?>">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>


    <script>
        function changeLanguage() {
            document.querySelector('#language_form').submit();
        }

    </script>
    <?php include "includes/footer.php";?>
