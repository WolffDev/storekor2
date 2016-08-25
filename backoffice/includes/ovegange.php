<?php if (session_status() === PHP_SESSION_NONE){session_start();} ?>
<?php
  if(isset($_POST['add_event'])) {
    $start_date = escape($_POST['start_date']);
    $start_time = escape($_POST['start_time']);

    $db_start_date = '';


    $end_date = escape($_POST['end_date']);
    $end_time = escape($_POST['end_time']);

    $db_end_date = '';


    $e_title = escape($_POST['e_title']);
    $e_type = escape($_POST['e_type']);
    $e_text = escape($_POST['e_text']);

    $query = "INSERT INTO events(start_date, end_date, title, type, text) VALUES('{$db_start_date}', '{$db_end_date}', '{$e_title}', '{$e_type}', '{$e_text}')";
    $insert_event = mysqli_query($conn, $query);
    if(!$insert_event) {
      die("Query Failed: " . mysqli_error($conn));
    } else {
      $message = urlencode('event_added');
      header("Location: index.php?action=ovegange&message=".$message);
      mysqli_close($conn);
    }
  }

  if(isset($_POST['add_ovegange'])) {
    $ove_datoer = escape($_POST['ove_datoer']);
    $pieces = explode(",", $ove_datoer);
    $pieces_end = explode(",", $ove_datoer);
    $count = count($pieces);
    $i = 0;
    $now = date("Y-m-d H:i:s");
    $tid = '19:00:00';
    $ny_tid = strtotime($tid);
    $ove_tid = date('H:i:s', $ny_tid);
    $tid_slut = '21:30:00';
    $ny_tid_slut = strtotime($tid_slut);
    $ove_tid_slut = date('H:i:s', $ny_tid_slut);

    while($i < $count) {
      $start_date = $pieces[$i] .= " ".$ove_tid;
      $end_date = $pieces_end[$i] .= " ".$ove_tid_slut;
      $query = "INSERT INTO events(start_date, end_date, created) VALUES('{$start_date}','{$end_date}', '{$now}')";
      $create_ovegang = mysqli_query($conn, $query);
      $i++;
    }
    if(!$create_ovegang) {
      die("Query Failed: " . mysqli_error($conn));
    } else {
      $message = urlencode('ovegange_added');
      header("Location: index.php?action=ovegange&message=".$message);
      mysqli_close($conn);
    }
  }
?>

<div class="container">
<?php
  if(isset($_SESSION['auth']) && $_SESSION['auth'] < 3 ) {
    $query = "SELECT start_date FROM events";
    $select = mysqli_query($conn, $query);
    $count = mysqli_num_rows($select);
    if($count != 0) {
      while($row = mysqli_fetch_assoc($select)) {
        $date_selected[] = date('Y/m/d', strtotime($row['start_date']));
      }
      $dates = json_encode($date_selected);
    }
?>
<script type="text/javascript">
$( document ).ready(function() {
  $('#ove_datoer').datepicker({
    language: "da",
    multidate: true,
    multidateSeparator: ",",
    calendarWeeks: true,
    todayHighlight: true,
    weekStart: 1,
    format: "yyyy/mm/dd",
    datesDisabled: <?php echo $dates; ?>
  });
});
</script>

  <div class="row">
    <form action="" method="post" class="col s12 m6">
      <p>Tilføj en koncert og/eller en øvegang</p>

      <div class="row">
        <div class="input-field col s6">
          <input id="start_date" type="date" name="start_date" class="datepicker">
          <label for="start_date">Start dato</label>
        </div>
        <div class="input-field col s6">
          <input type="time" class="timepicker" id="start_time" name="start_time" value="">
          <label for="start_time">Start tidspunkt</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s6">
          <input id="end_date" type="date" name="end_date" class="datepicker">
          <label for="end_date">Slut dato</label>
        </div>
        <div class="input-field col s6">
          <input type="time" class="timepicker" id="end_time" name="end_time" value="">
          <label for="end_time">Slut tidspunkt</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s6">
          <input id="e_title" type="text" name="e_title">
          <label for="e_title">Titel på event</label>
        </div>
        <div class="input-field col s6">
          <input type="text" id="e_type" name="e_type" value="">
          <label for="e_type">Type af event</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
          <input type="text" id="e_text" name="e_text" value="">
          <label for="e_text">Lidt tekst om eventet</label>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <button class="btn waves-effect waves-light" type="submit" name="add_event">Tilføj event
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>

    </form>

    <form action="" method="post" class="col s12 m6">
      <p>Tilføj flere øvegange herunder</p>

      <div class="row">
        <div class="input-field col s12">
          <input id="ove_datoer" type="text" name="ove_datoer">
          <label for="ove_datoer">Indtast datoer for øvegange</label>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <button class="btn waves-effect waves-light" type="submit" name="add_ovegange">Tilføj øvegange
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>

    </form>
  </div>
<?php } ?>

<table class="centered highlight striped">
  <div class="div center">
    <h5>Planlagte øvegange/koncerter mm.</h5>
  </div>
  <thead>
    <tr>
      <th data-field="name">Type</th>
      <th data-field="date">Start</th>
      <th data-field="date">Slut</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $query = "SELECT * FROM events";
    $select = mysqli_query($conn, $query);
    $count = mysqli_num_rows($select);
    if($count != 0) {
      while($row = mysqli_fetch_assoc($select)) {
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $type = $row['type'];
        $e_id = $row['id'];
        echo "<tr>";
        if($_SESSION['auth'] < 3 ) {
          echo "<td><a href='index.php?action=event&e_id=".$e_id."'>".$type."</a></td>";
        } else {
          echo "<td>".$type."</td>";
        }
        echo "<td>".date_format(new DateTime($start_date), 'D \d\. j\. M \k\l\. H:i')."</td>";
        echo "<td>".date_format(new DateTime($end_date), 'D \d\. j\. M \k\l\. H:i')."</td>";
        echo "</tr>";
      }
    } else {
      echo "make error message = no events.";
    }
  ?>
  </tbody>
</table>
</div>
