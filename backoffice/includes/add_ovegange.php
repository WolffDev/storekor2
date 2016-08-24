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

  if(isset($_POST['action'])) {
    $ove_dato = $_POST['ove_dato'];
    $pieces = explode(",", $ove_dato);
    $count = count($pieces);
    $i = 0;
    while($i < $count) {
      $query = "INSERT INTO events(start_date) VALUES('{$pieces[$i]}')";
      $create_ovegang = mysqli_query($conn, $query);
      $i++;
    }
    if(!$create_ovegang) {
      die("Query Failed: " . mysqli_error($conn));
    } else {
      $message = urlencode('ovegange_added');
      header("Location: index.php?action=add_ovegange&message=".$message);
      mysqli_close($conn);
    }
  }
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
      <h4>Tilføj øvegange herunder</h4>
      <div class="row">
        <div class="input-field col s12">
          <input id="ove_dato" type="text" class="validate" name="ove_dato">
          <label for="ove_dato">Indtast datoer for øvegange</label>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <button class="btn waves-effect waves-light" type="submit" name="action">Submit
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
