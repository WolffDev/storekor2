<?php
  if (session_status() === PHP_SESSION_NONE){session_start();}
  if(!isset($_SESSION['bruger_status']) || $_SESSION['bruger_status'] == 'ikke godkendt') {
    header("Location: ../index.php");
  }
?>
<?php
  if(isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $checkbox_member_id) {
      $bulk_options = $_POST['bulk_options'];

      switch ($bulk_options) {
        case 'formand':
          $query = "UPDATE medlemmer SET bruger_rolle = '{$bulk_options}', auth = '1' WHERE id = '{$checkbox_member_id}'";
          $update = mysqli_query($conn, $query);
          break;
        case 'bestyrelsen':
          $query = "UPDATE medlemmer SET bruger_rolle = '{$bulk_options}', auth = '2' WHERE id = '{$checkbox_member_id}'";
          $update = mysqli_query($conn, $query);
          break;
        case 'dirigent':
          $query = "UPDATE medlemmer SET bruger_rolle = '{$bulk_options}', auth = '3' WHERE id = '{$checkbox_member_id}'";
          $update = mysqli_query($conn, $query);
          break;
        case 'sanger':
          $query = "UPDATE medlemmer SET bruger_rolle = '{$bulk_options}', auth = '4' WHERE id = '{$checkbox_member_id}'";
          $update = mysqli_query($conn, $query);
          break;
        case 'aktiv':
          $query = "UPDATE medlemmer SET bruger_status = '{$bulk_options}' WHERE id = '{$checkbox_member_id}'";
          $update = mysqli_query($conn, $query);
          break;
        case 'orlov':
          $query = "UPDATE medlemmer SET bruger_status = '{$bulk_options}' WHERE id = '{$checkbox_member_id}'";
          $update = mysqli_query($conn, $query);
          break;
        case 'godkendt':
          $query = "UPDATE medlemmer SET app_status = '{$bulk_options}' WHERE id = '{$checkbox_member_id}'";
          $update = mysqli_query($conn, $query);

          $query1 = "UPDATE medlemmer SET bruger_status = 'aktiv', auth = '4' WHERE id = '{$checkbox_member_id}'";
          $update1 = mysqli_query($conn, $query1);

          $query1 = "UPDATE medlemmer SET bruger_rolle = 'sanger' WHERE id = '{$checkbox_member_id}'";
          $update1 = mysqli_query($conn, $query1);
          break;
        case 'delete':
          $query = "DELETE FROM medlemmer WHERE id = '{$checkbox_member_id}'";
          $delete = mysqli_query($conn, $query);
          break;
      }
    }
  }
?>
<?php
  if(isset($_GET['message'])) {
    if ($_GET['message'] === 'success_edit_member') {
      $edit_name = escape($_GET['edit_name']); ?>
      <div class="container">
        <div class="row teal">
          <div class="col s12 center white-text bold">
            <p>
              <?php echo $edit_name; ?> er blevet opdateret.
            </p>
          </div>
        </div>
      </div>
    <?php } ?>
  <?php } ?>
<form class="view-all-members" action="" method="post">
  <div class="row">
    <div class="col m3"></div>
    <div id="bulkOptionContainer" class="col s12 m3">
      <select class="form-control" name="bulk_options">
        <option disabled selected value="">Vælg handling</option>
        <option value="formand">Sæt formand</option>
        <option value="bestyrelsen">Sæt bestyrelse medlem</option>
        <option value="dirigent">Sæt dirigent</option>
        <option value="sanger">Sæt medlem til sanger</option>
        <option value="aktiv">Sæt medlem aktiv</option>
        <option value="orlov">Sæt medlem orlov</option>
        <option value="godkendt">Sæt til godkendt</option>
        <option value="delete">Slet medlem</option>
      </select>
    </div>
    <div class="col s12 m3">
      <button class="btn waves-effect waves-light" type="submit" name="submit">Opdater</button>
    </div>
    <div class="col m3"></div>
  </div>
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
          "dom": 'fti',
          "language": {
            "search": "Indtast søgeord:",
            "zeroRecords": "Intet resultat - prøv igen.",
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
                    return '<a href="medlemmer.php?action=view&id=' + row[0] + '">' + data +' '+ row[2] + ' ' + '</a>';
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
			}); // <---- Document.ready END
		</script>
