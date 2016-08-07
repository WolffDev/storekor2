<?php if (session_status() === PHP_SESSION_NONE){session_start();}
if(!isset($_SESSION['bruger_status']) || $_SESSION['bruger_status'] == 'ikke godkendt') {
  header("Location: ../index.php");
}
?>
<form class="" action="" method="post">
  <table class="striped" id="medlemmer_table">
    <thead>
      <tr>
        <th><input name="select_all" value="" id="selectAllBoxes" type="checkbox" /></th>
        <th data-field="id">Navn</th>
        <th data-field="id">Efternavn</th>
        <th data-field="price">Brugernavn</th>
        <th data-field="id">Telefon</th>
        <th data-field="id">Stemme</th>
        <th data-field="id">Rolle</th>
        <th data-field="id">Status</th>
        <th data-field="id">Tilmeldt</th>
        <th data-field="id">Tilmelding</th>
        <th data-field="id">Alder</th>
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
        //   if($app_status == 'ny' || $app_status == 'oprettet af bestyrelsen') {
        //     echo "<td>$app_status</td>";
        //   }
        //   echo "<tr>";
        // }
      ?>
    <!-- </tbody> -->
  </table>
</form>
<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#medlemmer_table').DataTable( {
					"processing": false,
          'order': [[1, 'asc']],
					"serverSide": true,
          'iDisplayLength': 150,
          'bLengthChange': false,
          "sPaginationType": "full_numbers",
          "dom": '<"row form-accept"<"col s12 m5"f>><"top"i>t',
          "language": {
            "search": "Indtast søgeord:",
            "zeroRecords": "Der blev ikke fundet noget på det du søgte efter - prøv igen.",
            "info": "Viser _TOTAL_ medlemmer",
            "infoFiltered": "(filtreret fra _MAX_ medlemmer)",
          },
					"ajax":{
						url :"includes/medlemmer_data.php", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							$(".employee-grid-error").html("");
							$("#medlemmer_table").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							$("#employee-grid_processing").css("display","none");

						}
					},
          "columnDefs": [
            {
              "render": function ( data, type, row ) {
                    return '<a href="medlemmer.php?action=edit_member&id=' + row[0] + '">' + data +' '+ row[2] + ' ' + '</a> (' + row[10] + ' år)';
                },
              "targets": 1,

            },
            {
              'targets': 0,
              'searchable':false,
              'orderable':false,
              'className': 'dt-body-center',
              'render': function (data, type, full, meta){
                return '<input class=".checkBoxes" type="checkbox" name="checkBoxArray[]" value="'
                    + $('<div/>').text(data).html() + '">';
              },
            },
            { "visible": false,  "targets": [ 2, 10 ] },
          ],
          "fixedHeader": true
				} );
        // $('#medlemmer_table_paginate').hide();
        $('#medlemmer_table_filter label input').appendTo('#medlemmer_table_filter');
        $('#medlemmer_table_filter label').appendTo('#medlemmer_table_filter');

        // Handle click on checkbox to set state of "Select all" control
        $('#medlemmer_table #selectAllBoxes').click(function(e){
          var table= $(e.target).closest('table');
          $('td input:checkbox',table).prop('checked',this.checked);
        });


        $('<div id="bulkOptionContainer" class="col s12 m3"><select class="form-control" name="bulk_options"><option disabled selected value="">Vælg handling</option><option value="Published">Publish</option><option value="Draft">Draft</option><option value="delete">Delete</option><option value="clone">Clone</option></select></div><div class="col s12 m4"><button class="btn waves-effect waves-light" type="submit" name="submit">Opdater</button>').prependTo('#medlemmer_table_wrapper .form-accept');


			}); // <---- Document.ready END
		</script>
