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
        $brugernavn = $row['brugernavn'];
        $db_password = $row['password'];
        $fornavn = $row['fornavn'];
        $efternavn = $row['efternavn'];
        $bruger_status = $row['bruger_status'];
        $bruger_rolle = $row['bruger_rolle'];
      }
      if($bruger_status === 'ikke_godkendt') {
        $message = urlencode("unapproved");
        header("Location: ../../index.php?message=".$message);
        die;
      }
      if(password_verify($password, $db_password)) {


        $_SESSION['brugernavn'] = $brugernavn;
        $_SESSION['fornavn'] = $fornavn;
        $_SESSION['efternavn'] = $efternavn;
        $_SESSION['bruger_status'] = $bruger_status;
        $_SESSION['bruger_rolle'] = $bruger_rolle;
        $_SESSION['logged_in'] = true;

        header("Location: ../");

      } else {
        $message = urlencode("invalid_login");
        header("Location: ../../index.php?message=".$message);
        die;
      }
    }
  }
?>