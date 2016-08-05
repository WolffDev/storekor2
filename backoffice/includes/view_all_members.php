<table class="striped highlight responsive-table">
  <thead>
    <tr>
      <th data-field="id">Fornavn</th>
      <th data-field="name">Efternavn</th>
      <th data-field="price">Brugernavn</th>
      <th data-field="id">Telefon</th>
      <th data-field="id">Stemme</th>
      <th data-field="id">Rolle</th>
      <th data-field="id">Status</th>
    </tr>
  </thead>

  <tbody>
    <?php
      global $conn;
      $query = "SELECT * FROM medlemmer";
      $select_users = mysqli_query($conn, $query);

      while($row = mysqli_fetch_assoc($select_users )) {
        $fornavn = $row['fornavn'];
        $efternavn = $row['efternavn'];
        $brugernavn = $row['brugernavn'];
        $telefon = $row['telefon'];
        $stemme = $row['stemme'];
        $bruger_rolle = $row['bruger_rolle'];
        $bruger_status = $row['bruger_status'];
        $flag_status = $row['flag_status'];
        $dato_oprettet = $row['dato_oprettet'];
        $app_status = $row['app_status'];

        echo "<tr>";
        echo "<td>$fornavn</td>";
        echo "<td>$efternavn</td>";
        echo "<td>$brugernavn</td>";
        echo "<td>$telefon</td>";
        echo "<td>$stemme</td>";
        echo "<td>$bruger_rolle</td>";
        echo "<td>$bruger_status</td>";
        if($app_status != 'godkendt') {
          $date = date_create($dato_oprettet);
          echo "<td>".date_format($date, 'D, d/M-Y')."</td>";
        }
        if($app_status == 'ny') {
          echo "<td>$app_status</td>";
        }
        if($flag_status == 1) {
          echo "<td>$flag_status</td>";
        }
        echo "<tr>";
      }
    ?>
  </tbody>
</table>
