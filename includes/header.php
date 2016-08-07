<?php session_start(); ?>
<?php
  if(!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = 'false';
  }
  ?>
<?php ob_start(); ?>
<?php include "backoffice/includes/db.php"; ?>
<?php include "backoffice/functions.php"; ?>
<!DOCTYPE html>
<html lang="dk">
  <head>
    <title>Storekor || Odense</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"/>
    <!-- ****** CSS ******-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" rel="stylesheet"/>
    <!-- ****** SCRIPTS ******-->
    <script src="js/min/jquery2.1.1.min.js"></script>
    <script src="js/materialize.js"></script>
    <script src="js/init.js"></script>
  </head>
  <body>
