<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "db.php"; ?>
<?php include "../functions.php"; ?>
<?php
  if(isset($_POST['login'])) {
    $username = escape($_POST['username']);
    $password = escape($_POST['password']);

    $query = "SELECT * FROM medlemmer WHERE brugernavn = '{$username}'";
    $select_user_query = mysqli_query($conn, $query);

    if(!$select_user_query) {
      die("Query failed: ". mysqli_error($conn));
    } else {
      while($row = mysqli_fetch_array($select_user_query)) {
        $user_id = $row['id'];
        $brugernavn = $row['brugernavn'];
        $db_password = $row['password'];
        $fornavn = $row['fornavn'];
        $efternavn = $row['efternavn'];
        $bruger_status = $row['bruger_status'];
        $bruger_rolle = $row['bruger_rolle'];
        $auth = $row['auth'];
        $changed_pass = $row['changed_pass'];
      }
      if($bruger_status === 'ikke godkendt') {
        $message = urlencode("unapproved");
        header("Location: ../../?message=".$message);
        die;
      }
      if(password_verify($password, $db_password)) {

        $_SESSION['user_id'] = $user_id;
        $_SESSION['brugernavn'] = $brugernavn;
        $_SESSION['fornavn'] = $fornavn;
        $_SESSION['efternavn'] = $efternavn;
        $_SESSION['bruger_status'] = $bruger_status;
        $_SESSION['bruger_rolle'] = $bruger_rolle;
        $_SESSION['logged_in'] = 'true';
        $_SESSION['auth'] = $auth;
        if($changed_pass == 0) {
          $_SESSION['changed_pass'] = 0;
        } else {
          $_SESSION['changed_pass'] = 1;
        }

        header("Location: ../index.php");

      } else {
        $message = urlencode("invalid_login");
        header("Location: ../../?message=".$message);
        die;
      }
    }
  }
?>
