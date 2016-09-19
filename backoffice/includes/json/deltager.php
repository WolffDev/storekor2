<?php session_start(); ?>
<?php ob_start(); ?>
<?php include "../db.php"; ?>
<?php include "../../functions.php"; ?>

<?php
  if(isset($_POST['deltager']) && $_POST['deltager'] == 'add') {
    $member_id = escape($_POST['member_id']);
    $event_id = escape($_POST['event_id']);

    $deltager_add_query = "INSERT INTO deltagere
      (
        d_m_id,
        d_e_id,
        d_date
      )
    VALUES
      (
        {$member_id},
        {$event_id},
        NOW()
      )";
    $result = mysqli_query($conn, $deltager_add_query);
  }

  if(isset($_POST['deltager']) && $_POST['deltager'] == 'remove') {
    $deltager_id = escape($_POST['deltager_id']);

    $deltager_delete_query = "DELETE FROM deltagere WHERE d_id = {$deltager_id} ";
    $result = mysqli_query($conn, $deltager_delete_query);
  }
?>
