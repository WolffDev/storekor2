<?php   if (session_status() === PHP_SESSION_NONE){session_start();} ?>
<?php
  if(isset($_POST['add_ovegang'])) {
    $ove_dato = $_POST['ove_dato'];
    $pieces = explode(",", $ove_dato);
    $pieces_end = explode(",", $ove_dato);
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
      echo $end_date = $pieces_end[$i] .= " ".$ove_tid_slut;
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
<?php
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
<?php
  if(isset($_SESSION['auth']) && $_SESSION['auth'] < 3 ) {
?>
<script type="text/javascript">
$( document ).ready(function() {
  $('#ove_dato').datepicker({
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

<div class="container">
  <div class="row">
    <form action="" method="post" class="col s12">
      <h5>Tilføj flere øvegange herunder</h5>
      <div class="row">
        <div class="input-field col s12">
          <input id="ove_dato" type="text" class="validate" name="ove_dato">
          <label for="ove_dato">Indtast datoer for øvegange</label>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <button class="btn waves-effect waves-light" type="submit" name="add_ovegang">Tilføj øvegange
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>
