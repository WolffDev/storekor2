<?php
  if(isset($_POST['cancel_afbud'])) {
     $afbud_id = escape($_POST['afbud_id']);

     $query = "DELETE FROM afbud WHERE a_id = '{$afbud_id}'";
     $delete_afbud = mysqli_query($conn, $query);
  }

  if(isset($_POST['add_event'])) {
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

    $query = "INSERT INTO events(start_date, end_date, title, type, text, long_text, created) VALUES('{$db_start_date}', '{$db_end_date}', '{$e_title}', '{$e_type}', '{$e_text}', '{$long_text}', '$now')";
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

<div class="container events content-container">
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
  <ul class="collapsible" data-collapsible="accordion">
    <li>
     <div class="collapsible-header"><i class="material-icons ">add_to_queue</i>Tryk her for at tilføje en øvegang, koncert m.m.</div>
     <div class="collapsible-body">

      <div class="container">
        <div class="row">
          <form action="" method="post" class="col s12 m6 dotted">
            <h5>Tilføj en enkelt koncert, øvegang etc.</h5>
            <p class="flow-text">
              Herunder kan du oprette et enkelt event og specificere flere detaljer for eventet.
            </p>

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
                <input id="e_title" type="text" name="e_title" length="30">
                <label for="e_title">Titel på event</label>
              </div>
              <div class="input-field col s6">
                <select name="e_type">
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
                <input type="text" id="e_text" name="e_text" value="" length="50">
                <label for="e_text">Lidt tekst om eventet</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <textarea type="text" id="long_text" name="long_text" value="" class="materialize-textarea"></textarea>
                <label for="long_text">Her kan du tilføje en længere tekst som vil blive vist på forsiden, hvis det er en koncert du opretter</label>
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
            <h5>Tilføj flere øvegange</h5>
            <p class="flow-text">Her kan du tilføje flere datoer for øvegange på samme tid, hvor tidsrummet automatisk er sat til at være 19:00 - 21:30.</p>

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
      </div>
    </div>
  </li>
  </ul>
  <?php } ?>

  <table class="centered highlight striped responsive-table">
    <div class="div center">
      <h5>Planlagte øvegange/koncerter mm.</h5>
    </div>
    <thead>
      <tr>
        <th data-field="name">Type</th>
        <th data-field="name">Titel</th>
        <th data-field="name">Info</th>
        <th data-field="date">Start</th>
        <th data-field="date">Slut</th>
        <th data-field="date">Afbud</th>
      </tr>
    </thead>
    <tbody>
    <?php
      $_SESSION['user_id'] = $user_id;

      $query = "SELECT events.event_id, events.start_date, events.end_date, events.title, events.text, events.type, afbud.e_id, afbud.m_id, afbud.a_id FROM events LEFT JOIN afbud ON events.event_id = afbud.e_id WHERE events.start_date >= NOW() ORDER BY events.start_date ASC";
      $select = mysqli_query($conn, $query);
      $count = mysqli_num_rows($select);
      if($count != 0) {
        while($row = mysqli_fetch_assoc($select)) {
          $e_id = $row['event_id'];
          $start_date = $row['start_date'];
          $end_date = $row['end_date'];
          $title = $row['title'];
          $text = $row['text'];
          $afbud_e_id = $row['e_id'];
          $afbud_m_id = $row['m_id'];
          $afbud_a_id = $row['a_id'];

          $start_date_format = date_format(new DateTime($start_date), 'D \d\. j\. M \k\l\. H:i');
          $end_date_format = date_format(new DateTime($end_date), 'D \d\. j\. M \k\l\. H:i');
          $start_date_check = date_format(new DateTime($start_date), 'd m Y');
          $end_date_check = date_format(new DateTime($end_date), 'd m Y');
          $end_date_time = date_format(new DateTime($end_date), '\k\l\. H:i');

          $type = $row['type'];
          echo "<tr>";if($_SESSION['auth'] < 3 ) {
            echo "<td><a href='index.php?action=event&e_id=" . $e_id . "'>" . $type . "</a></td>";
          } else {
            echo "<td>" . $type . "</td>";
          }

          echo "<td>" . $title . "</td>";
          echo "<td>" . $text . "</td>";
          echo "<td>" . $start_date_format . "</td>";

          if($start_date_check === $end_date_check) {
            echo "<td>" . $end_date_time . "</td>";
          } else {
            echo "<td>" . $end_date_format . "</td>";
          }

          if($user_id != $afbud_m_id && $e_id != $afbud_e_id) {
            echo "<td><a href='index.php?action=afbud&cancel=true&e_id=" . $e_id . "&m_id=" . $user_id . "'><button class='btn red darken-3 white-text waves-effect waves-light'>Meld afbud</button></a></td>";
          } else { ?>
            <td>
              <form method="post" action="">
                <input type="hidden" name="afbud_id" value="<?php echo $afbud_a_id;?>">
                <button class="btn waves-effect waves-light" type="submit" name="cancel_afbud">Fortryd afbud</button>
              </form>
            </td>
          <?php }

          echo "</tr>";
        }
      } else {
        echo "Der er ikke blevet oprettet fremtidige events endnu.";
      }
    ?>
    </tbody>
  </table>
  <div class="row">
    <p class="center"><a href="index.php?action=old_ovegange">Se gamle events</a></p>
  </div>
</div>
