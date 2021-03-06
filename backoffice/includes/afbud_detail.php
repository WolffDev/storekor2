<div class="container div content-container">
  <?php
    if(isset($_GET['action']) && $_GET['action'] == 'afbud_detail') {
      $event_id = escape($_GET['event']);
      $type = escape($_GET['type']);
      $date = escape($_GET['date']);
    }
    ?>
      <table class="centered highlight striped responsive-table">
        <div class="div center">
          <h5>Registrede afbud for <?php echo $type; ?>, der afholdes d. <?php echo $date; ?></h5>
        </div>
        <thead>
          <tr>
            <th>Stemme</th>
            <th data-field="name">Navn</th>
            <th data-field="name">Begrundelse</th>
            <th data-field="name">Dato for afbud</th>
          </tr>
        </thead>
        <tbody>
    <?php
    $query = "SELECT a.e_id, a.m_id, a.date_cancel, a.reason, m.id, m.fornavn, m.efternavn, m.stemme
    FROM afbud AS a
    LEFT JOIN medlemmer AS m ON a.m_id = m.id
    WHERE a.e_id = $event_id
    ORDER BY stemme ASC";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)) {
      $fornavn = $row['fornavn'];
      $efternavn = $row['efternavn'];
      $navn = $fornavn . " " . $efternavn;
      $stemme = $row['stemme'];
      $date_cancel= $row['date_cancel'];
      $reason = $row['reason'];
      $date_format = date_format(new DateTime($date_cancel), 'D \d\. j\. M \k\l\. H:i');


      echo "<tr>";
      echo "<td>" . $stemme . "</td>";
      echo "<td>" . $navn . "</td>";
      echo "<td>" . $reason . "</td>";
      echo "<td>" . $date_format . "</td>";
      echo "</tr>";
    }
  ?>
</tbody>
</table>
</div>
