<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "../db.php"; ?>
<?php include "../../functions.php"; ?>

<?php
  if(isset($_POST['absence']) && $_POST['absence'] == 'update') {
    $absence_id = escape($_POST['absence_id']);
    $absence_status = escape($_POST['absence_status']);

    $absence_update_query = "UPDATE
      absence
    SET
      absence_status = $absence_status
    WHERE
      absence_id = $absence_id";
    $result = mysqli_query($conn, $absence_update_query);
  }
?>
