<div class="container content-container">
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
      </tr>
    </thead>
    <tbody>


    <?php
      $_SESSION['user_id'] = $user_id;

      $query = "SELECT event_id, start_date, end_date, title, text, type
      FROM events
      WHERE start_date >= NOW()
      ORDER BY start_date ASC";
      $select = mysqli_query($conn, $query);
      $count = mysqli_num_rows($select);

      if($count != 0) {
        while($row = mysqli_fetch_assoc($select)) {
          $e_id = $row['event_id'];
          $start_date = $row['start_date'];
          $end_date = $row['end_date'];
          $title = $row['title'];
          $text = $row['text'];
          $type = $row['type'];

          $start_date_format = date_format(new DateTime($start_date), 'D \d\. j\. M \k\l\. H:i');
          $end_date_format = date_format(new DateTime($end_date), 'D \d\. j\. M \k\l\. H:i');
          $start_date_check = date_format(new DateTime($start_date), 'd m Y');
          $end_date_check = date_format(new DateTime($end_date), 'd m Y');
          $end_date_time = date_format(new DateTime($end_date), '\k\l\. H:i');

          echo "<tr>";
          if($_SESSION['auth'] < 3 ) {
            echo "<td><a href='index.php?action=protocol_detail&e_id=" . $e_id . "'>" . $type . "</a></td>";
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
