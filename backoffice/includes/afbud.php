<div class="afbud">
<?php
  if(isset($_GET['cancel']) && $_GET['cancel'] == 'true') {
    include "includes/afbud_popup.php";
  }
  if(isset($_GET['state']) && $_GET['state'] == 'overview') {
?>

    <div class="container content-container">
          <?php
            $query = "SELECT
              afbud.e_id,
              events.event_id,
              events.type,
              events.start_date,
              events.title,
              COUNT(afbud.e_id) AS antal_afbud
            FROM
              afbud
            LEFT JOIN
              events
            ON
              afbud.e_id = events.event_id
            WHERE
            	afbud.afbud_start_date >= SUBDATE( NOW(), INTERVAL 12 HOUR)
            GROUP BY
              afbud.e_id
            ";
            $select = mysqli_query($conn, $query);
            $afbud_check =  mysqli_num_rows($select);
            if($afbud_check == 0) {
              echo '<p class="center">';
              echo 'Der er ikke meldt nogen afbud på fremtidige events.';
              echo '</p>';
            } else {
              ?>
              <table class="centered highlight striped responsive-table">
                <div class="div center">
                  <h5>Registrerede afbud til hvert event</h5>
                </div>
                <thead>
                  <tr>
                    <th>Dato</th>
                    <th>Afbud antal</th>
                    <th>Type</th>
                    <th>Titel</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  while($row = mysqli_fetch_assoc($select)) {
                    $e_id = $row['e_id'];
                    $event_id = $row['event_id'];
                    $type = $row['type'];
                    $start_date = $row['start_date'];
                    $title = $row['title'];
                    $antal_afbud = $row['antal_afbud'];
                    $start_date_format = date_format(new DateTime($start_date), 'j\. M');

                    echo '<tr>';
                      echo '<td><a href="index.php?action=afbud_detail&event=' . $event_id . '&type=' . $type . '&date=' . $start_date_format . '">' . $start_date_format . '</a></td>';
                      echo '<td>' . $antal_afbud . '</td>';
                      echo '<td>' . $type . '</td>';
                      echo '<td>' . $title . '</td>';
                    echo '</tr>';
                  }
                ?>
              </tbody>
            </table>
          <?php } ?>

    </div>
<?php } ?>


</div>
