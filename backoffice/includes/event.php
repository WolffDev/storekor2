<?php checkAuth('3'); ?>
<?php
/*
 * https://github.com/chingyawhao/materialize-clockpicker#developing
 */
  if(isset($_GET['e_id'])) {
    $e_id = escape($_GET['e_id']);
  } else {
    header("Location: index.php?action=ovegange");
  }

  $query = "SELECT * FROM events WHERE id = {$e_id}";
  $select = mysqli_query($conn, $query);

  while($row = mysqli_fetch_assoc($select)) {
    $type = $row['type'];
    $title = $row['title'];
    $text = $row['text'];
    $start_date = $row['start_date'];
    $end_date = $row['end_date'];
    $created = $row['created'];
    $modified = $row['modified'];
  }
?>
<div class="container events">
  <div class="row">
    <form class="col s12" action="" method="post">
      <div class="row">
        <div class="input-field col s12 m8">
          <input id="title" type="text" value="<?php echo $type; ?>">
          <label for="title">Type (øvegang, koncert etc.)</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12 m8">
          <textarea id="textarea1" class="materialize-textarea"></textarea>
          <label for="textarea1">Info om event</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input type="time" class="timepicker" id="timepicker" name="time" value="">
          <label for="timepicker">Tidspunkt</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="password" type="password" class="validate">
          <label for="password">Password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
    </form>
  </div>
</div>
