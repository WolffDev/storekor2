<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "db.php"; ?>
<?php include "functions.php"; ?>
<!DOCTYPE html>
<html lang="dk">
  <head>
    <title>Storekor || Odense</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
    <!-- ****** CSS ******-->
    <link href="../css/materialIcons.css" rel="stylesheet"/>
    <link href="../css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" rel="stylesheet"/>
    <link href="css/dataTables.css" rel="stylesheet"/>
    <link href="css/admin_style.css" rel="stylesheet"/>
    <link href="css/bootstrap-datepicker.standalone.css" rel="stylesheet">
    <!-- ****** SCRIPTS ******-->
    <script src="../js/min/jquery2.1.1.min.js"></script>
    <script src="js/dataTables.js"></script>
    <script src="../js/materialize.js"></script>
    <script src="js/dataTables.fixedHeader.min.js"></script>
    <script src="js/dataTables.checkboxes.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js">

    </script>
    <script src="js/script.js">

    </script>
  </head>
  <body class="admin-area">
