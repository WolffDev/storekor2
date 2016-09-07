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

  $query = "SELECT * FROM events WHERE event_id = {$e_id}";
  $select = mysqli_query($conn, $query);

  while($row = mysqli_fetch_assoc($select)) {
    $type = $row['type'];
    $title = $row['title'];
    $text = $row['text'];
    $long_text = $row['long_text'];
    $start_date = $row['start_date'];
    $end_date = $row['end_date'];
    $created = $row['created'];
  }
  $start_date_time = date_format(new DateTime($start_date), 'H:i');
  $end_date_time = date_format(new DateTime($end_date), 'H:i');

  if(isset($_POST['update_event'])) {
    $start_date = escape($_POST['start_date']);
    $start_time = escape($_POST['start_time']);
    $db_start_date = $start_date . " " . $start_time;

    $end_date = escape($_POST['end_date']);
    $end_time = escape($_POST['end_time']);
    $db_end_date = $end_date . " " . $end_time;

    $long_text = escape($_POST['long_text']);
    $e_title = escape($_POST['e_title']);
    $e_type = escape($_POST['e_type']);
    $e_text = escape($_POST['e_text']);
    $now = date('Y-m-d H:i:s');
    if(!empty($e_type)) {
      $query = "UPDATE events SET ";
      $query .="type = '{$e_type}', ";
      $query .="title = '{$e_title}', ";
      $query .="long_text = '{$long_text}', ";
      $query .="text = '{$e_text}', ";
      $query .="start_date = '{$db_start_date}', ";
      $query .="end_date = '{$db_end_date}', ";
      $query .="modified = '{$now}' ";
      $query .="WHERE event_id = {$e_id} ";
      $update_event = mysqli_query($conn, $query);
      if(!$update_event) {
        die("Query Failed123: " . mysqli_error($conn));
      } else {
        $message = urlencode('event_updated');
        header("Location: index.php?action=ovegange&message=".$message);
        mysqli_close($conn);
      }
    } else {
      $message = urlencode('type_missing');
      header("Location: index.php?action=event&e_id=".$e_id."&message=".$message);
      mysqli_close($conn);
    }
  }

  if(isset($_POST['delete_event'])) {
    $query = "DELETE FROM events WHERE event_id = {$e_id}";
    $delete_event = mysqli_query($conn, $query);
    if(!$delete_event) {
      die("Query Failed123: " . mysqli_error($conn));
    } else {
      $message = urlencode('event_delete');
      header("Location: index.php?action=ovegange&message=".$message);
      mysqli_close($conn);
    }
  }

?>
<div class="container events">

  <div class="row">
    <form class="col s12" action="" method="post">

      <div class="row">
        <div class="input-field col s6">
          <input id="start_date" type="date" name="start_date" class="datepicker" data-value="<?php if(isset($start_date)) { echo $start_date;} ?>">
          <label for="start_date">Start dato</label>
        </div>
        <div class="input-field col s6">
          <input type="time" class="timepicker" id="start_time" name="start_time" value="<?php if(isset($start_date_time)) { echo $start_date_time;} ?>">
          <label for="start_time">Start tidspunkt</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s6">
          <input id="end_date" type="date" name="end_date" class="datepicker" data-value="<?php if(isset($end_date)) { echo $end_date;} ?>">
          <label for="end_date">Slut dato</label>
        </div>
        <div class="input-field col s6">
          <input type="time" class="timepicker" id="end_time" name="end_time" value="<?php if(isset($end_date_time)) { echo $end_date_time;} ?>">
          <label for="end_time">Slut tidspunkt</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s6">
          <input id="e_title" type="text" name="e_title" length="30" value="<?php if(isset($title)) { echo $title;} ?>">
          <label for="e_title">Titel på event</label>
        </div>
        <div class="input-field col s6">
          <select name="e_type">
            <option value="" disabled selected>Vælg type her</option>
            <option value="koncert">Koncert</option>
            <option value="øvegang">Øvegang</option>
            <option value="korlørdag">Korlørdag</option>
            <option value="generalprøve">Generalprøve</option>
            <option value="generalforsamling">Generalforsamling</option>
            <option value="spisning">Spisning</option>
            <option value="evt">Eventuelt</option>
          </select>
          <label>Type af event</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input type="text" id="e_text" name="e_text" value="<?php if(isset($text)) { echo $text;} ?>" length="50">
          <label for="e_text">Lidt tekst om eventet</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <textarea type="text" id="long_text" name="long_text" class="materialize-textarea"><?php if(isset($long_text)) { echo $long_text;} ?></textarea>
          <label for="long_text">Her kan du tilføje en længere tekst som vil blive vist på forsiden, hvis det er en koncert du opretter</label>
        </div>
      </div>

      <div class="row center">
        <div class="col s6">
          <button class="btn waves-effect waves-light" type="submit" name="update_event">Opdater event
            <i class="material-icons right">send</i>
          </button>
        </div>
        <div class="col s6">
          <button class="btn waves-effect waves-light red" type="submit" name="delete_event">Slet event
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>

    </form>
  </div>
</div>
