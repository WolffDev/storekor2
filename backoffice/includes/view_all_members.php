<table class="" id="medlemmer_table">
  <thead>
    <tr>
      <th data-field="id">Fornavn</th>
      <th data-field="id">Efternavn</th>
      <th data-field="price">Brugernavn</th>
      <th data-field="id">Telefon</th>
      <th data-field="id">Stemme</th>
      <th data-field="id">Rolle</th>
      <th data-field="id">Status</th>
      <th data-field="id">Tilmeldt</th>
      <th data-field="id">Nye tilmeldinger</th>
    </tr>
  </thead>

  <!-- <tbody> -->
    <?php
      // global $conn;
      // $query = "SELECT * FROM medlemmer ORDER BY id DESC";
      // $select_users = mysqli_query($conn, $query);
      //
      // while($row = mysqli_fetch_assoc($select_users )) {
      //   $fornavn = $row['fornavn'];
      //   $efternavn = $row['efternavn'];
      //   $brugernavn = $row['brugernavn'];
      //   $telefon = $row['telefon'];
      //   $stemme = $row['stemme'];
      //   $bruger_rolle = $row['bruger_rolle'];
      //   $bruger_status = $row['bruger_status'];
      //   $dato_oprettet = $row['dato_oprettet'];
      //   $app_status = $row['app_status'];
      //
      //   echo "<tr>";
      //   echo "<td>$fornavn $efternavn</td>";
      //   echo "<td>$brugernavn</td>";
      //   echo "<td>$telefon</td>";
      //   echo "<td>$stemme</td>";
      //   echo "<td>$bruger_rolle</td>";
      //   echo "<td>$bruger_status</td>";
      //   $date = date_create($dato_oprettet);
      //   $date_show = date_format($date, 'd\. M - Y');
      //   echo "<td>$date_show</td>";
      //   if($app_status == 'ny' || $app_status == 'oprettet af bestyrrelsen') {
      //     echo "<td>$app_status</td>";
      //   }
      //   echo "<tr>";
      // }
    ?>
  <!-- </tbody> -->
</table>
<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#medlemmer_table').DataTable( {
					"processing": false,
					"serverSide": true,
          'iDisplayLength': 150,
          'bLengthChange': false,
          "sPaginationType": "full_numbers",
					"ajax":{
						url :"includes/medlemmer_data.php", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".employee-grid-error").html("");
							$("#medlemmer_table").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#employee-grid_processing").css("display","none");

						}
					},
				} );
        $('#medlemmer_table_paginate').hide();
        $('#medlemmer_table_filter label input').appendTo('#medlemmer_table_filter');
        $('#medlemmer_table_filter label').appendTo('#medlemmer_table_filter');
			} );
		</script>