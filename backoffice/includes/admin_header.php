<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "db.php"; ?>
<?php include "functions.php"; ?>
<?php
if($_SESSION['logged_in'] != true) {
    header("Location: ../../index.php");
}
?>
<!DOCTYPE html>
<html lang="dk">
  <head>
    <title>Storekor || Odense</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
    <!-- ****** CSS ******-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="../css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" rel="stylesheet"/>
    <link href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.css" rel="stylesheet"/>
    <link href="css/admin_style.css" rel="stylesheet"/>
    <!-- ****** SCRIPTS ******-->
    </script>
    <script src="../js/min/jquery2.1.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
    <script src="../js/materialize.js"></script>
  </head>
  <body class="admin-area">
