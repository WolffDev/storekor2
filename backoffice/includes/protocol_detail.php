<?php
  if(isset($_GET['action']) && $_GET['action'] == 'protocol_detail') {
    $e_id = escape($_GET['e_id']);
  }

  $check_status_query = "SELECT
    status
  FROM
    events
  WHERE
  event_id = $e_id";

  $check_status_result = mysqli_query($conn, $check_status_query);

  while($check_status = mysqli_fetch_assoc($check_status_result)) {
    $event_status = $check_status['status'];
  }
  if($event_status == 0) {
    $insert_query = "INSERT INTO
      absence(
        absence_member_id,
        absence_event_id
      )
    SELECT
      medlemmer.id,
      $e_id
    FROM
      medlemmer
    WHERE
      medlemmer.bruger_status = 'aktiv'
    AND id != 1";
    $result_insert = mysqli_query($conn, $insert_query);

    $update_status = "UPDATE events SET status = 1 WHERE event_id = {$e_id}";
    $result_update = mysqli_query($conn, $update_status);
  }
?>
<div class="container content-container protocol_detail">
  <form action="" method="post">
    <div class="row">
      <div class="col s12 m9 l10">
        <h5 class="center">Dagens Protokol</h5>

        <?php protocol_detail('1sopran', '1. Sopran'); ?>
        <?php protocol_detail('2sopran', '2. Sopran'); ?>
        <?php protocol_detail('1alt', '1. Alt'); ?>
        <?php protocol_detail('2alt', '2. Alt'); ?>
        <?php protocol_detail('1tenor', '1. Tenor'); ?>
        <?php protocol_detail('2tenor', '2. Tenor'); ?>
        <?php protocol_detail('1bass', '1. Bass'); ?>
        <?php protocol_detail('2bass', '2. Bass'); ?>

      </div>

      <div class="col hide-on-small-only m3 l2">
        <ul class="section table-of-contents fixedElement">
          <li><a href="#1sopran">1. Sopran</a></li>
          <li><a href="#2sopran">2. Sopran</a></li>
          <li><a href="#1alt">1. Alt</a></li>
          <li><a href="#2alt">2. Alt</a></li>
          <li><a href="#1tenor">1. Tenor</a></li>
          <li><a href="#2tenor">2. Tenor</a></li>
          <li><a href="#1bass">1. Bass</a></li>
          <li><a href="#2bass">2. Bass</a></li>
        </ul>
      </div>

    </div>
  </form>
</div>
