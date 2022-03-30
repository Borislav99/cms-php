<?php
//dodavanje kategorija
function insert_categories() {
    global $connection;
    if(isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if($cat_title==='' || empty($cat_title)) {
            echo "<h1>Enter some values</h1>";
                } else {
            $stmt1 = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES (?)");
            mysqli_stmt_bind_param($stmt1, 's', $cat_title);
            mysqli_stmt_execute($stmt1);
                            }
                        }
};
//brisanje kategorija
function deleteCategories() {
    global $connection;
        if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM categories WHERE cat_id = $id";
        $result = mysqli_query($connection, $query);
        if(!$result) {
            echo "failed";
        };
        header("Location: categories.php");
    }
}
//prikaz svih kategorija
function findAllCategories() {
    global $connection;
    $query = "SELECT * FROM categories";
    $result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>$cat_id</td>";
        echo "<td>$cat_title</td>";
        echo "<td><a href='categories.php?id=$cat_id'>DELETE</a></td>";
        echo "<td><a href='categories.php?edit=$cat_id'>EDIT</a></td>";
        echo "</tr>";
    }
}
//confirm query
function confirm($result) {
    global $connection;
    if(!$result) {
        die('Query Failed'). " ". mysqli_error($connection);
    }
}
//users online functions
function users_online() {
    global $connection;
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 60;
    $time_out = $time - $time_out_in_seconds;
   $query = "SELECT * FROM users_online WHERE session = '$session'";
    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query);
    if($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
    } 
    else {
        mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");        
    }
    $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > $time_out");
    return $count_user = mysqli_num_rows($users_online_query);
}
//calculate rows
function recordCount($table) {
global $connection;
  $query = "SELECT * FROM ". "$table";
  $get_data = mysqli_query($connection, $query);
  $result = mysqli_num_rows($get_data);
    return $result;
}
//broj objava
function get_all_user_posts($table, $status) {
    global $connection;
    $username = $_SESSION['username'];
    if($status == null) {
    $query = "SELECT * FROM $table WHERE post_user = '$username'";
    $get_data = mysqli_query($connection, $query);
    $result = mysqli_num_rows($get_data);
    } else if($status == 'published') {
    $query = "SELECT * FROM $table WHERE post_user = '$username' AND post_status = 'published'";
    $get_data = mysqli_query($connection, $query);
    $result = mysqli_num_rows($get_data);
    } else if($status == 'draft') {
    $query = "SELECT * FROM $table WHERE post_user = '$username' AND post_status = 'draft'";
    $get_data = mysqli_query($connection, $query);
    $result = mysqli_num_rows($get_data);
    }
    return $result;
}
//broj komentara
function get_all_post_user_comms($status) {
        global $connection;
    $username = $_SESSION['username'];
    $query = "SELECT post_id FROM posts WHERE post_user = '$username'";
    $result = mysqli_query($connection, $query);
    $post_arr = [];
    while($row = mysqli_fetch_assoc($result)) {
        $post_id_num = $row['post_id'];
        array_push($post_arr, $post_id_num);
    };
    $num = 0;
    if($status == null) {
         foreach($post_arr as $item) {
        $query = "SELECT * FROM comments WHERE comment_post_id = $item";
        $result = mysqli_query($connection, $query);
        $rows = mysqli_num_rows($result);
        $num += $rows;
    };   
    } else if($status == 'approved') {
         foreach($post_arr as $item) {
        $query = "SELECT * FROM comments WHERE comment_post_id = $item AND comment_status = 'approved'";
        $result = mysqli_query($connection, $query);
        $rows = mysqli_num_rows($result);
        $num += $rows;
    };    
    } else if($status == 'unapproved') {
         foreach($post_arr as $item) {
        $query = "SELECT * FROM comments WHERE comment_post_id = $item AND comment_status = 'unapproved'";
        $result = mysqli_query($connection, $query);
        $rows = mysqli_num_rows($result);
        $num += $rows;
    }; 
    }
    return $num;
}
//broj kategorija
function get_all_user_cats() {
  global $connection;
    $user_id = $_SESSION['user_id'];
    $query = "SELECT user_id FROM categories WHERE user_id = $user_id";
    $result = mysqli_query($connection, $query);
    $num = mysqli_num_rows($result);
    return $num;
};
function checkStatus($table, $column, $status) {
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$status'";
    $select = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select);
    return $result;
}
function getUserRole($table, $role) {
    global $connection;
    $query = "SELECT * FROM $table WHERE user_role = '$role'";
    $get_data = mysqli_query($connection, $query);
    $result = mysqli_num_rows($get_data);
    return $result;
};
function isLoggedIn() {
    if(isset($_SESSION['user_role'])) {
        return true;
    } else {
        return false;
    }
}
function is_admin($username) {
    if(isLoggedIn()) {
    global $connection;
    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    if(isset($_SESSION['user_role'])) {
        if($row['user_role']=='admin') {
        return true;            
        }
    } 
    else {
        return false;
    }   
    }
}
//da li korisnik postoji na bazi
function user_exists($username) {
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    };
};
//da li mejl vec postoji na bazi
function email_exists($email) {
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    };
}
function redirect($location) {
    return header("Location: $location");
}
// register user --->
function register_user($username, $email, $password) {
    global $connection;
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $query = "INSERT INTO users(username, user_email, user_password, user_role) VALUES ('$username', '$email', '$password', 'subscriber')";
    $register_user_query = mysqli_query($connection, $query);
}
// register user --->

// prijavljivanje korisnika
function login_user($username, $password) {
    global $connection;
    //brisemo whitespace
    $username = trim($username);
    $password = trim($password);
    //ciscenje podataka
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);
    //izbor korisnika gdje je username isti kao onaj sa inputa
    $query = "SELECT * FROM users WHERE username = '$username'";
    $select_user_query = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_user_query)) {
            //uzimanje njegovih podatka
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];
        };
    //da li su iste unesena sifra i ona sa baze
    if(password_verify($password, $db_user_password)) {
        //ako jesu, postavljamo sesiju kada se loguje
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        $_SESSION['user_id'] = $db_user_id;
        //ide na stranicu index
        redirect("/demo/cms/admin/index.php");
    } else {
        //ako nisu ostaje na normalnom indeksu
        redirect("/demo/cms/index.php");
    }
}
// login user --->
function get_user_name() {
    $username = $_SESSION['username'];
    return $username;
}
?>
